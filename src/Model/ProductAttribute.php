<?php declare(strict_types=1);

namespace Knops\GunfireClient\Model;

final class ProductAttribute
{
    private ?Product $product = null;
    private string $name;
    private string $value;

    public function __construct(string $name, string $value)
    {
        $this->value = $value;
        $this->name = $name;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getValue(): string
    {
        return $this->value;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }
}