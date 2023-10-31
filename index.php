<?php
require_once __DIR__ . '/vendor/autoload.php';

$checkout = new \GihovaniDemetrio\BoasPraticas\CalculateCheckout();
$render = $checkout->execute(new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
    'country' => 'BR',
    'currency' => 'BRL',
]));

if ((php_sapi_name() !== 'cli')) print json_encode($render);