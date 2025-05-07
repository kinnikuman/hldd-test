<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class Item
{
    public function __construct(
        private readonly string $name,
        private readonly int $count,
        private readonly int $priceInCents,
    ) {
        if ($count < 0) {
            throw InvalidItemException::forCount($count);
        }
        if ($priceInCents <= 0) {
            throw InvalidItemException::forPrice($priceInCents);
        }
    }

    public static function fromFloatPrice(
        string $name,
        int $count,
        float $price
    ): self {
        return new self($name, $count, (int)($price * 100));
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getCount(): int
    {
        return $this->count;
    }

    public function getPriceInCents(): int
    {
        return $this->priceInCents;
    }

}
