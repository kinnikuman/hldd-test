<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\Service;

class MoneyData
{
    public function __construct(
        public readonly int $coinCents,
        public readonly int $numberOfCoins,
    ) {
    }
}