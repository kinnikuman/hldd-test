<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class ItemOutOfStockException extends DomainException
{
    public static function forItem(string $name): self
    {
        throw new self(sprintf('Item "%s" is out of stock.', $name));
    }
}