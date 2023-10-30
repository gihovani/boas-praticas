<?php
declare(strict_types=1);

function main($input): array
{
    $db = new mysqli('127.0.0.1', 'magento', 'magento', 'test');
    $response = file_get_contents('https://localhost/boas-praticas/currencies.php', false, stream_context_create(['ssl' => ['verify_peer' => false, 'verify_peer_name' => false]]));
    $currencies = json_decode($response, true);
    $currency = $currencies[$input['currency']];
    $subtotal = 0;
    $freight = 0;
    foreach ($input['items'] as $item) {
        $productId = $item['productId'];
        $query = 'SELECT * FROM test.product WHERE product_id = ?';
        $stmt = $db->prepare($query);
        $stmt->bind_param('i', $productId);
        $stmt->execute();
        $result = $stmt->get_result();
        $product = $result->fetch_assoc();
        $amount = floatval($product['amount']);
        $itemAmount = $item['quantity'] * $amount;
        $subtotal += $itemAmount;
    }

    $taxes = 0;
    $protection = 0.055706;
    if ($input['country'] === 'BR') {
        if ($subtotal + $freight > 50) {
            $importTax = ($subtotal + $freight) * 0.60;
            $icms = ($subtotal + $freight + $importTax) * 0.17;
            $taxes = $importTax + $icms + ($subtotal * $protection);
        } else {
            $taxes = ($subtotal + $freight) * 0.17;
        }
    }


    $total = $subtotal + $taxes + $freight;

    $db->close();

    return [
        'subtotal' => round($subtotal * $currency, 2),
        'taxes' => round($taxes * $currency, 2),
        'total' => round($total * $currency, 2)
    ];
}

$render = main([
    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
    'country' => 'BR',
    'currency' => 'BRL',
]);

// subtotal US $1069,60 - R$5788,44
// impostos US $992,27 - R$5369,97
// total US $2061,87 - R$11158,41
print json_encode($render);