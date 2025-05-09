<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class ItemNotFoundException extends DomainException
{

    public static function forItem(string $name): self
    {
        throw new self(sprintf('Item "%s" not found.', $name));
    }
}