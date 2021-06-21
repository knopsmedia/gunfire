<?php declare(strict_types=1);

namespace Knops\Gunfire\Model;

final class Category
{
    private int $externalId;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->externalId = $id;
        $this->name = $name;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getShortName(): string
    {
        $tags = $this->getTags();

        return end($tags);
    }

    public function getTags(): array
    {
        return explode('/', $this->getName());
    }
}