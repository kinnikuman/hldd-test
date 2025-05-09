<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\BuyItem;

use App\Shared\Application\Bus\Message\Command;

class BuyItemCommand extends Command
{
    public function __construct(
        public readonly string $item
    ) {
    }
}