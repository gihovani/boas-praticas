<?php
declare(strict_types=1);

use PHPUnit\Framework\TestCase;

final class CalculateCheckoutTest extends TestCase
{
    private \GihovaniDemetrio\BoasPraticas\CalculateCheckout $calculateCheckout;

    public function setUp(): void
    {
        parent::setUp();
//        $currencyGateway = new \GihovaniDemetrio\BoasPraticas\CurrencyGatewayHttp();
        $currencyGateway = $this->createMock(\GihovaniDemetrio\BoasPraticas\CurrencyGateway::class);
        $currencyGateway->method('getCurrency')
            ->willReturnCallback(function ($currency) {
                if ($currency === 'BRL') {
                    return 5.41178;
                } elseif ($currency === 'EUR') {
                    return 0.9467;
                }
                return 1.0;
            });
//        $productRepository = new \GihovaniDemetrio\BoasPraticas\ProductRepositoryDataBase();
        $productRepository = $this->createMock(\GihovaniDemetrio\BoasPraticas\ProductRepository::class);
        $productRepository->method('getProduct')
            ->willReturnCallback(function ($productId) {
                if ($productId === 1) {
                    return new \GihovaniDemetrio\BoasPraticas\Product(1, 'Product A', 951.60);
                } elseif ($productId === 2) {
                    return new \GihovaniDemetrio\BoasPraticas\Product(2, 'Product A', 59.00);
                }
                return null;
            });
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
    public function testMainWithExceptionCountryNotFound()
    {
        $this->expectException(\Error::class);
        $this->calculateCheckout->execute(new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
            'items' => [['productId' => 1, 'quantity' => 1]],
            'country' => 'AR',
            'currency' => 'BRL',
        ]));
    }
    public function testMainWithExceptionProductNotFound()
    {
        $this->expectException(\Error::class);
        $this->calculateCheckout->execute(new \GihovaniDemetrio\BoasPraticas\CalculateCheckoutInput([
            'items' => [['productId' => 3, 'quantity' => 1]],
            'country' => 'BR',
            'currency' => 'BRL',
        ]));
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