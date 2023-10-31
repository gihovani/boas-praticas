<?php declare(strict_types=1);

namespace GihovaniDemetrio\BoasPraticas;

class CalculateCheckout
{
    private CurrencyGateway $currencyGateway;
    private ProductRepository $productRepository;

    public function __construct(CurrencyGateway $currencyGateway, ProductRepository $productRepository)
    {
        $this->currencyGateway = $currencyGateway;
        $this->productRepository = $productRepository;
    }

    function execute(CalculateCheckoutInput $input): CalculateCheckoutOutput
    {
        $currency = $this->currencyGateway->getCurrency($input->currency);
        $subtotal = 0;
        $freight = 0;
        foreach ($input->items as $item) {
            $productId = $item['productId'];
            $productQuantity = $item['quantity'];
            $product = $this->productRepository->getProduct($productId);
            $amount = floatval($product['amount']);
            $itemAmount = $productQuantity * $amount;
            $subtotal += $itemAmount;
        }

        $taxes = 0;
        $protection = 0.055706;
        if ($subtotal && $input->country === 'BR') {
            if ($subtotal + $freight > 50) {
                $importTax = ($subtotal + $freight) * 0.60;
                $icms = ($subtotal + $freight + $importTax) * 0.17;
                $taxes = $importTax + $icms + ($subtotal * $protection);
            } else {
                $taxes = ($subtotal + $freight) * 0.17;
            }
        }

        $total = $subtotal + $taxes + $freight;
        return new CalculateCheckoutOutput([
            'subtotal' => round($subtotal * $currency, 2),
            'taxes' => round($taxes * $currency, 2),
            'total' => round($total * $currency, 2)
        ]);
    }
}

