<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class MachineCoins
{
    public function __construct(
        private readonly Coin $coin,
        private int $numberOfCoins,
    ) {
        if($numberOfCoins < 0) {
            throw InvalidMachineCoinException::forNumberOfCoins($numberOfCoins);
        }
    }

    public function getCoin(): Coin
    {
        return $this->coin;
    }

    public function getNumberOfCoins(): int
    {
        return $this->numberOfCoins;
    }

    public function decrease(): void
    {
        $this->numberOfCoins--;
    }

    public function increase(): void
    {
        $this->numberOfCoins++;
    }

}
