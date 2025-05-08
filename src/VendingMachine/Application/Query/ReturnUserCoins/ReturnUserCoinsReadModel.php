<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Query\ReturnUserCoins;

interface ReturnUserCoinsReadModel
{
    /**
     * @return float[]
     */
    public function all(): array;
}