<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CalculateTaxFactory
{
    public static function create(string $country): CalculateTax
    {
        if ($country === 'BR') return new CalculateTaxBR();
        if ($country === 'FR') return new CalculateTaxFree();
        if ($country === 'US') return new CalculateTaxFree();
        throw new \Error(sprintf('PAIS (%s) NAO DISPONÍVEL', $country));
    }
}