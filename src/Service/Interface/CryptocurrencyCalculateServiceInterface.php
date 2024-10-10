<?php

namespace app\src\Service\Interface;

interface CryptocurrencyCalculateServiceInterface
{
    public function handler(
        string $symbol,
        int $amount,
        string $currency
    ) : mixed;
}