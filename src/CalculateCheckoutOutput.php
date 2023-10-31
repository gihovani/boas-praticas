<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CalculateCheckoutOutput extends DataObject
{
    public float $subtotal;
    public float $taxes;
    public float $freight;
    public float $total;
}