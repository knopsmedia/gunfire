<?php declare(strict_types=1);

namespace Knops\Gunfire\Model;

use DateTimeInterface;
use Knops\Utilities\Traits\CreateSlugTrait;

final class Product
{
    use CreateSlugTrait;

    private int $externalId = 0;
    private int $shopifyExternalId = 0;
    private string $externalSku = '';
    private string $handle = '';
    private string $name = '';
    private string $description = '';
    private string $externalListingUrl = '';
    private ?Manufacturer $manufacturer = null;
    private ?Category $category = null;
    private int $nextImagePosition = 1;
    private ?float $priceAmount = null;
    private ?string $priceCurrency = null;
    private int $stockQuantity = 0;

    /** @var string[] */
    private array $tags = [];

    /** @var ProductImage[] */
    private array $images = [];

    /** @var ProductAttribute[] */
    private array $attributes = [];

    private ?DateTimeInterface $createdAt = null;
    private ?DateTimeInterface $updatedAt = null;

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function setExternalId(int $externalId): void
    {
        $this->externalId = $externalId;
    }

    public function getShopifyExternalId(): int
    {
        return $this->shopifyExternalId;
    }

    public function setShopifyExternalId(int $shopifyExternalId): void
    {
        $this->shopifyExternalId = $shopifyExternalId;
    }

    public function getExternalSku(): string
    {
        return $this->externalSku;
    }

    public function setExternalSku(string $externalSku): void
    {
        $this->externalSku = $externalSku;
    }

    public function getHandle(): string
    {
        if ('' === $this->handle) {
            $this->handle = $this->createSlug($this->getName());
        }

        return $this->handle;
    }

    public function setHandle(string $handle): void
    {
        $this->handle = $handle;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): void
    {
        $this->description = trim($description);
    }

    public function getExternalListingUrl(): string
    {
        return $this->externalListingUrl;
    }

    public function setExternalListingUrl(string $externalListingUrl): void
    {
        $this->externalListingUrl = $externalListingUrl;
    }

    public function getManufacturer(): ?Manufacturer
    {
        return $this->manufacturer;
    }

    public function setManufacturer(Manufacturer $manufacturer): void
    {
        $this->manufacturer = $manufacturer;
    }

    public function getCategory(): ?Category
    {
        return $this->category;
    }

    public function setCategory(Category $category): void
    {
        $this->category = $category;
        $this->setTags($category->getTags());
    }

    public function getPriceAmount(): ?float
    {
        return $this->priceAmount;
    }

    public function setPriceAmount(?float $priceAmount): void
    {
        $this->priceAmount = $priceAmount;
    }

    public function getPriceCurrency(): ?string
    {
        return $this->priceCurrency;
    }

    public function setPriceCurrency(?string $priceCurrency): void
    {
        $this->priceCurrency = $priceCurrency;
    }

    public function getTags(): array
    {
        return $this->tags;
    }

    public function setTags(array $tags): void
    {
        $this->tags = $tags;
    }

    public function getWeightInGrams(): float
    {
        $attribute = $this->findAttributeByName('Weight [g]');
        $weight = $attribute ? (float)$attribute->getValue() : .0;

        return $weight;
    }

    public function getWeightInKg(): float
    {
        return $this->getWeightInGrams() / 1000;
    }

    public function getAttributes(): array
    {
        return $this->attributes;
    }

    public function findAttributeByName(string $name): ?ProductAttribute
    {
        foreach ($this->getAttributes() as $attribute) {
            if ($attribute->getName() === $name) {
                return $attribute;
            }
        }

        return null;
    }

    public function addAttributes(array $attributes): self
    {
        foreach ($attributes as $attribute) {
            $this->addAttribute($attribute);
        }

        return $this;
    }

    public function addAttribute(ProductAttribute $attribute): ProductAttribute
    {
        $attribute->setProduct($this);
        $this->attributes[] = $attribute;

        return $attribute;
    }

    public function getImages(): array
    {
        return $this->images;
    }

    public function addImages(array $images): self
    {
        foreach ($images as $image) {
            $this->addImage($image);
        }

        return $this;
    }

    public function addImage(ProductImage $image, ?int $position = null): ProductImage
    {
        if ($position !== null && $position >= $this->nextImagePosition) {
            $this->nextImagePosition = $position + 1;
        }

        $image->setProduct($this);
        $image->setPosition($position ?? $this->incrementNextImagePosition());
        $this->images[] = $image;

        return $image;
    }

    public function getNextImagePosition(): int
    {
        return $this->nextImagePosition;
    }

    public function incrementNextImagePosition(): int
    {
        $position = $this->nextImagePosition++;

        return $position;
    }

    /**
     * @param int $nextImagePosition
     * @internal
     */
    public function setNextImagePosition(int $nextImagePosition): void
    {
        $this->nextImagePosition = $nextImagePosition;
    }

    public function getStockQuantity(): int
    {
        return $this->stockQuantity;
    }

    public function setStockQuantity(int $stockQuantity): void
    {
        $this->stockQuantity = $stockQuantity;
    }

    public function getCreatedAt(): ?DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): void
    {
        $this->createdAt = $createdAt;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt = null): void
    {
        $this->updatedAt = $updatedAt;
    }
}