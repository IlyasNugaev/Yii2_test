<?php

namespace app\src\Repository\Interface;

interface CryptocurrencyRepositoryInterface
{
    public function getAll(?int $limit, ?int $offset) : iterable;

    public function getBySymbol(string $symbol): mixed;
}