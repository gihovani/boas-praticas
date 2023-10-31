<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalculateCheckoutTest extends TestCase
{
    private \GihovaniDemetrio\BoasPraticas\CalculateCheckout $calculateCheckout;

    public function setUp(): void
    {
        parent::setUp();
        $currencyGateway = new \GihovaniDemetrio\BoasPraticas\CurrencyGateway();
        $productRepository = new \GihovaniDemetrio\BoasPraticas\ProductRepository();
        $this->calculateCheckout = new \GihovaniDemetrio\BoasPraticas\CalculateCheckout($currencyGateway, $productRepository);
    }

    /**
     * @dataProvider inputDataProvider
     */
    public function testMain(
        \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput  $input,
        \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput $expected
    ): void
    {
        $result = $this->calculateCheckout->execute($input);
        $this->assertEquals($result, $expected);
    }

    public function inputDataProvider(): array
    {
        return [
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                    'country' => 'BR',
                    'currency' => 'BRL',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 5788.44, 'taxes' => 5369.97, 'total' => 11158.41])
            ],
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                    'country' => 'BR',
                    'currency' => 'USD',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 1069.60, 'taxes' => 992.27, 'total' => 2061.87])
            ],
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                    'country' => 'US',
                    'currency' => 'USD',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 1069.60, 'taxes' => 0, 'total' => 1069.60])
            ],
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                    'country' => 'BR',
                    'currency' => 'EUR',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 1012.59, 'taxes' => 939.39, 'total' => 1951.98])
            ],
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [['productId' => 1, 'quantity' => 1], ['productId' => 2, 'quantity' => 2]],
                    'country' => 'FR',
                    'currency' => 'EUR',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 1012.59, 'taxes' => 0, 'total' => 1012.59])
            ],
            [
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
                    'items' => [],
                    'country' => 'BR',
                    'currency' => 'BRL',
                ]),
                new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutOutput(['subtotal' => 0, 'taxes' => 0, 'total' => 0])
            ],
        ];
    }
}