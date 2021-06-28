<?php declare(strict_types=1);

namespace Knops\GunfireClient\Model;

final class ProductImage
{
    private ?Product $product = null;
    private int $position = 0;
    private string $externalUrl;

    public function __construct(string $url)
    {
        $this->externalUrl = $url;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): void
    {
        $this->product = $product;
    }

    public function getPosition(): int
    {
        return $this->position;
    }

    public function setPosition(int $position): void
    {
        $this->position = $position;
    }

    public function getExternalUrl(): string
    {
        return $this->externalUrl;
    }

    public function setExternalUrl(string $externalUrl): void
    {
        $this->externalUrl = $externalUrl;
    }
}