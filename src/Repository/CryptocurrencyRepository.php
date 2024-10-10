<?php

namespace app\src\Repository;

use app\models\Cryptocurrency;
use app\src\Repository\Interface\CryptocurrencyRepositoryInterface;
use app\src\Service\Interface\CryptocurrencyUpdateServiceInterface;
use Exception;
use GuzzleHttp\Client;
use GuzzleHttp\Exception\BadResponseException;
use GuzzleHttp\Exception\GuzzleException;
use RuntimeException;
use Yii;
use yii\db\ActiveRecord;

class CryptocurrencyRepository implements CryptocurrencyRepositoryInterface
{
    public function getAll(?int $limit = null, ?int $offset = null): array
    {
        $query = Cryptocurrency::find();

        if ($limit) {
            $query->limit($limit);
        }

        if ($offset) {
            $query->offset($offset);
        }

        return $query->all();
    }

    public function getBySymbol(string $symbol): ActiveRecord|array|null
    {
        return Cryptocurrency::find()->where(['symbol' => $symbol])->one();
    }
}