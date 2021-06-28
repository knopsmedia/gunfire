<?php declare(strict_types=1);

namespace Knops\GunfireClient\Model;

final class ProductPrice
{
    private int $productExternalId;
    private float $priceAmount;
    private string $priceCurrency;
    private int $stockQuantity;

    public function __construct(int $productExternalId, int $stockQuantity, float $priceAmount, string $priceCurrency)
    {
        $this->productExternalId = $productExternalId;
        $this->stockQuantity = $stockQuantity;
        $this->priceAmount = $priceAmount;
        $this->priceCurrency = $priceCurrency;
    }

    public function getProductExternalId(): int
    {
        return $this->productExternalId;
    }

    public function getPriceAmount(): float
    {
        return $this->priceAmount;
    }

    public function getPriceCurrency(): string
    {
        return $this->priceCurrency;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }
}