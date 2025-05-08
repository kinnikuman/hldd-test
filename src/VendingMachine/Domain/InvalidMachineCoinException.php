<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

use DomainException;

class InvalidMachineCoinException extends DomainException
{
    public static function forNumberOfCoins(): self
    {
        throw new self('Number of coins must be greater or equals than 0');
    }
}