<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class Product
{
    public int $productId;
    public string $description;
    public float $amount;

    public function __construct(
        int    $productId,
        string $description,
        float  $amount
    )
    {
        $this->productId = $productId;
        $this->description = $description;
        $this->amount = $amount;
    }
}