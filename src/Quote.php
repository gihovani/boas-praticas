<?php declare(strict_types=1);

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
            $this->subtotal += $item->getSubtotal();
        }
    }

    private function calculateTaxes()
    {
        $this->taxes = CalculateTaxFactory::create($this->country)
            ->calculate($this->subtotal, $this->freight, $this->protection);
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