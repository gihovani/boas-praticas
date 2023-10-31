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
        $freight = 0;
        $protection = 0.055706;
        $quote = new Quote($freight, $protection, $input->country);
        foreach ($input->items as $item) {
            $productId = $item['productId'];
            $productQuantity = $item['quantity'];
            $product = $this->productRepository->getProduct($productId);
            $quote->addItem($product->amount, $productQuantity);
        }

        $quote->calculate();
        return new CalculateCheckoutOutput([
            'subtotal' => round($quote->subtotal * $currency, 2),
            'taxes' => round($quote->taxes * $currency, 2),
            'total' => round($quote->total * $currency, 2)
        ]);
    }
}

