<?php declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class IndexTest extends TestCase
{
    public function setUp(): void
    {
        require_once __DIR__ . '/../index.php';
        parent::setUp();
    }

    /**
     * @dataProvider inputDataProvider
     */
    public function testMain(array $input, array $expected): void
    {
        $result = main($input);
        $this->assertEquals($result, $expected);
    }

    public function inputDataProvider(): array
    {
        return [
            [[
                'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                'country' => 'BR',
                'currency' => 'BRL',
            ], ['subtotal' => 5788.44, 'taxes' => 5369.97, 'total' => 11158.41]],
            [[
                'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                'country' => 'BR',
                'currency' => 'USD',
            ], ['subtotal' => 1069.60, 'taxes' => 992.27, 'total' => 2061.87]],
            [[
                'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                'country' => 'US',
                'currency' => 'USD',
            ], ['subtotal' => 1069.60, 'taxes' => 0, 'total' => 1069.60]],
            [[
                'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                'country' => 'BR',
                'currency' => 'EUR',
            ], ['subtotal' => 1012.59, 'taxes' => 939.39, 'total' => 1951.98]],
            [[
                'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                'country' => 'FR',
                'currency' => 'EUR',
            ], ['subtotal' => 1012.59, 'taxes' => 0, 'total' => 1012.59]],
            [[
                'items' => [],
                'country' => 'BR',
                'currency' => 'BRL',
            ], ['subtotal' => 0, 'taxes' => 0, 'total' => 0]],
        ];
    }
}