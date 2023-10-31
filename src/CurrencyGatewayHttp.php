<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CurrencyGatewayHttp implements CurrencyGateway
{
    public function getCurrency(string $currency): float
    {
        $response = file_get_contents('https://localhost/boas-praticas/currencies.php', false, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
        $currencies = json_decode($response, true);
        return $currencies[$currency];
    }
}