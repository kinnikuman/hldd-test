<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class VendingMachine
{
    /**
     * @param Item[] $items
     * @param MachineCoins[] $coins
     */
    public function __construct(
        private readonly array $items,
        private readonly array $coins,
    )
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }

}