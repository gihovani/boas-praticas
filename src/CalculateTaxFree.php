<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CalculateTaxFree implements CalculateTax
{
    public function calculate(float $subtotal, float $freight, float $protection): float
    {
        return 0;
    }
}