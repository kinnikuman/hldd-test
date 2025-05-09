<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class NotEnoughMoneyException extends DomainException
{
    public static function forItem(string $name, int $itemCents, int $insertedCents): self
    {
        throw new self(
            sprintf(
                'Not enough money for item "%s". The price is "%s" but only "%s" inserted money',
                $name,
                $itemCents / 100,
                $insertedCents / 100
            )
        );
    }
}