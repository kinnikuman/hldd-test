<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\InsertUserCoin;

use App\Shared\Application\Bus\Message\Command;

class InsertUserCoinCommand extends Command
{
    public function __construct(
        public readonly float $coinValue
    ) {
    }
}