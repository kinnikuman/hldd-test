<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

interface UserCoinRepository
{
    public function save(Coin $coin): void;
}