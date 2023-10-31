<?php

namespace GihovaniDemetrio\BoasPraticas;

class Quote
{
    /**
     * @var QuoteItem[]
     */
    private array $items;
    private float $freight;
    private float $protection;
    private string $country;
    public float $subtotal;
    public float $taxes;
    public float $total;

    public function __construct(float $freight, float $protection, string $country)
    {
        $this->items = [];
        $this->freight = $freight;
        $this->protection = $protection;
        $this->country = $country;
    }

    public function addItem(float $amount, int $quantity)
    {
        $this->items[] = new QuoteItem($amount, $quantity);
    }

    private function calculateSubtotal()
    {
        $this->subtotal = 0;
        foreach ($this->items as $item) {
            $this->subtotal += $item->quantity * $item->amount;
        }
    }

    private function calculateTaxes()
    {
        $this->taxes = 0;
        if ($this->subtotal && $this->country === 'BR') {
            if ($this->subtotal + $this->freight > 50) {
                $importTax = ($this->subtotal + $this->freight) * 0.60;
                $icms = ($this->subtotal + $this->freight + $importTax) * 0.17;
                $this->taxes = $importTax + $icms + ($this->subtotal * $this->protection);
            } else {
                $this->taxes = ($this->subtotal + $this->freight) * 0.17;
            }
        }
    }

    private function calculateTotal()
    {
        $this->total = $this->subtotal + $this->taxes + $this->freight;
    }

    public function calculate()
    {
        $this->calculateSubtotal();
        $this->calculateTaxes();
        $this->calculateTotal();
    }

}