<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class NotEnoughChangeException extends DomainException
{
    public static function forItem(string $name): self
    {
        throw new self(
            sprintf(
                'Not enough change for item "%s"',
                $name
            )
        );
    }
}