<?php

namespace app\src\Service;

use app\src\Dto\DtoFactory;
use app\src\Dto\Response\CalculateResponseDto;
use app\src\Repository\Interface\CryptocurrencyRepositoryInterface;
use app\src\Service\Interface\CryptocurrencyCalculateServiceInterface;
use yii\web\HttpException;

class CryptocurrencyCalculateService implements CryptocurrencyCalculateServiceInterface
{
    public function __construct(
        public CryptocurrencyRepositoryInterface $cryptocurrencyRepository,
    ) {

    }

    public function handler(
        string $symbol,
        int $amount,
        string $currency
    ) : CalculateResponseDto {
        $asset = $this->cryptocurrencyRepository->getBySymbol($symbol);

        //Сделаем вид, что в базе есть несколько видов фиатных валют
        if ($asset && $currency === 'USD') {
            $pricePerUnit = (float) $asset->price_usd;
        } else {
            throw new HttpException(404, 'Переданная фиатная валюта не найдена');
        }

        return DTOFactory::create(CalculateResponseDto::class, [
            'amount' => $amount,
            'symbol' => $symbol,
            'pricePerUnit' => $pricePerUnit,
            'currency' => $currency,
            'totalPrice' => bcmul($amount, $pricePerUnit, 20)
        ]);

    }
}