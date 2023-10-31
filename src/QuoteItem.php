<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class QuoteItem
{
    public float $amount;
    public int $quantity;

    public function __construct(
        float $amount,
        int   $quantity
    )
    {
        $this->amount = $amount;
        $this->quantity = $quantity;
    }

    public function getSubtotal(): float
    {
        return $this->amount * $this->quantity;
    }
}