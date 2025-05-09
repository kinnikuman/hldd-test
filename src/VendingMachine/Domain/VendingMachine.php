<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class VendingMachine
{
    /**
     * @param Item[] $items
     * @param MachineCoins[] $coins
     * @param Coin[] $userCoins
     */
    public function __construct(
        private readonly array $items,
        private readonly array $coins,
        private array $userCoins = [],
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

    /**
     * @return Coin[]
     */
    public function getUserCoins(): array
    {
        return $this->userCoins;
    }

    public function insertCoin(Coin $coin): void
    {
        $this->userCoins[] = $coin;
    }

    /**
     * @return Coin[]
     */
    public function returnCoins(): array
    {
        $userCoins = $this->userCoins;
        $this->userCoins = [];

        return $userCoins;
    }

}