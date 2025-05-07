<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\Service;

class ItemData
{
    public function __construct(
        public readonly string $name,
        public readonly int $count,
        public readonly float $price,
    )
    {
    }
}