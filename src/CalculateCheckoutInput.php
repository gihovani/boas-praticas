<?php

namespace GihovaniDemetrio\BoasPraticas;

class CalculateCheckoutInput extends DataObject
{
    public array $items;
    public string $country;
    public string $currency;
}