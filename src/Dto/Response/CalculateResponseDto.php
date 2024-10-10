<?php

declare(strict_types = 1);

namespace app\src\Dto\Response;

use app\src\Dto\BaseDto;

class CalculateResponseDto extends BaseDto
{
    protected int $amount;
    protected string $symbol;
    protected float $pricePerUnit;
    protected string $currency;
    protected float $totalPrice;

    public function getAmount(): int
    {
        return $this->amount;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function getPricePerUnit(): float
    {
        return $this->pricePerUnit;
    }

    public function getCurrency(): string
    {
        return $this->currency;
    }

    public function getTotalPrice(): float
    {
        return $this->totalPrice;
    }
}