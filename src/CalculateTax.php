<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

interface CalculateTax
{
    public function calculate(float $subtotal, float $freight, float $protection): float;
}