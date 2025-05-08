<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class InvalidCoinException extends DomainException
{
    public static function forCents(int $cents): self
    {
        throw new self('Invalid coin cents: ' . $cents);
    }
}