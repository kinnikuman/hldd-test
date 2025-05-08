<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Domain;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\UserCoinRepository;

class UserCoinRepositorySpy implements UserCoinRepository
{

    private ?Coin $coinForSave = null;

    private bool $removeAllHasBeenCalled = false;

    public function save(Coin $coin): void
    {
        $this->coinForSave = $coin;
    }

    public function getCoinForSave(): ?Coin
    {
        return $this->coinForSave;
    }

    public function removeAll(): void
    {
        $this->removeAllHasBeenCalled = true;
    }

    public function removeAllHasBeenCalled(): bool
    {
        return $this->removeAllHasBeenCalled;
    }
}
