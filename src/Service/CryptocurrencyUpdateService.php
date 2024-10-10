<?php

namespace app\src\Service;

use app\models\Cryptocurrency;
use app\src\Service\Interface\CryptocurrencyUpdateServiceInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use Yii;

class CryptocurrencyUpdateService implements CryptocurrencyUpdateServiceInterface
{
    public function __construct(
        public Client $client
    ) {
      //
    }

    /**
     * @throws GuzzleException
     */
    public function handler() : void
    {
        $assets = $this->getDataFromRequest();

        foreach ($assets as $asset) {
            if (isset($asset['asset_id'], $asset['name'], $asset['price_usd'], $asset['type_is_crypto'])) {
                if ($asset['type_is_crypto'] === 1) {
                    $this->saveToDb(
                        $asset['asset_id'],
                        $asset['name'],
                        number_format($asset['price_usd'], 20, '.', '')
                    );
                }
            }
        }

    }

    private function getDataFromRequest() : array
    {
        try {
            $response = $this->client->request('GET', 'https://rest.coinapi.io/v1/assets', [
                'headers' => [
                    //По хорошему получать из env, но из коробки как я понял yii2 не поддердживает
                    'X-CoinAPI-Key' => 'C8A7E6B2-DC04-4AA4-9EBE-C61E767F6123'
                ]
            ]);

            return json_decode($response->getBody(), true, 512, JSON_BIGINT_AS_STRING);
        } catch (BadResponseException $e) {
            Yii::error('Ошибка ответа: ' . $e->getMessage());
        } catch (Exception $e) {
            Yii::error('Общая ошибка: ' . $e->getMessage());
        }

        throw new RuntimeException('Ошибка: ' . $e->getMessage());
    }

    private function saveToDb(
        string $asset_id,
        string $name,
        string $price_usd,
    ) : void
    {
        $crypto = Cryptocurrency::findOne(['symbol' => $asset_id]) ?: new Cryptocurrency();

        $crypto->symbol = $asset_id;
        $crypto->name = $name;
        $crypto->price_usd = $price_usd;
        $crypto->updated_at = date('Y-m-d H:i:s');

        if (!$crypto->save()) {
            Yii::error('Ошибка сохранения данных: ' . json_encode($crypto->errors));
        }
    }
}