<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class InvalidItemException extends DomainException
{
    public static function forCount(int $count): self
    {
        throw new self('Number of items must be greater or equals than 0');
    }

    public static function forPrice(int $price): self
    {
        throw new self('Price must be greater than 0');
    }
}