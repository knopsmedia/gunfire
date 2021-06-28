<?php declare(strict_types=1);

namespace Knops\GunfireClient\Model;

final class Manufacturer
{
    private int $externalId;
    private string $name;

    public function __construct(int $id, string $name)
    {
        $this->name = $name;
        $this->externalId = $id;
    }

    public function getExternalId(): int
    {
        return $this->externalId;
    }

    public function getName(): string
    {
        return $this->name;
    }
}