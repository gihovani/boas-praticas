<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

interface ProductRepository
{
    public function getProduct(int $productId): Product;
}
