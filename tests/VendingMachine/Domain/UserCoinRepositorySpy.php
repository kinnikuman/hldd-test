<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Domain;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\UserCoinRepository;

class UserCoinRepositorySpy implements UserCoinRepository
{

    private ?Coin $coinForSave = null;

    public function save(Coin $coin): void
    {
        $this->coinForSave = $coin;
    }

    public function getCoinForSave(): ?Coin
    {
        return $this->coinForSave;
    }
}
