<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

interface CurrencyGateway {
    public function getCurrency(string $currency): float;
}
