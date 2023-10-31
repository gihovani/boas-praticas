<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CalculateTaxBR implements CalculateTax
{
    public function calculate(float $subtotal, float $freight, float $protection): float
    {
        if (!$subtotal) {
            return 0;
        }
        if ($subtotal + $freight > 50) {
            $importTax = ($subtotal + $freight) * 0.60;
            $icms = ($subtotal + $freight + $importTax) * 0.17;
            $taxes = $importTax + $icms + ($subtotal * $protection);
        } else {
            $taxes = ($subtotal + $freight) * 0.17;
        }
        return $taxes;
    }
}