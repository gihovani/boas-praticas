<?php
declare(strict_types=1);
function currencies(array $params): array
{
    return [
        'USD' => 1,
        'BRL' => 5.41178,
        'EUR' => 0.9467
    ];
}
$render = currencies($_GET);
print json_encode($render);