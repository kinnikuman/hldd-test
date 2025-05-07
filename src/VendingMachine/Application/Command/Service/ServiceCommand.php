<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\Service;

use App\Shared\Application\Bus\Message\Command;

class ServiceCommand extends Command
{
    /**
     * @param ItemData[] $items
     * @param MoneyData[] $money
     */
    public function __construct(
        public readonly array $items,
        public readonly array $money,
    ) {
    }
}