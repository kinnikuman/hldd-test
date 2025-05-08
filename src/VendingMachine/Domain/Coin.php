<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class Coin
{
    private const FIVE_CENTS = 5;
    private const TEN_CENTS = 10;
    private const TWENTY_FIVE_CENTS = 25;
    private const EURO = 100;

    private const VALID_COINS = [
        self::FIVE_CENTS,
        self::TEN_CENTS,
        self::TWENTY_FIVE_CENTS,
        self::EURO,
    ];

    public function __construct(
        private readonly int $coinCents,
    ) {
        if(!in_array($coinCents, self::VALID_COINS)) {
            throw InvalidCoinException::forCents($this->coinCents);
        }
    }

    public static function fromFloat(float $coinValue): self
    {
        return new self((int)($coinValue * 100));
    }

    public function getCoinCents(): int
    {
        return $this->coinCents;
    }

}
