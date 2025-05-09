<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Query\ReturnUserCoins;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\VendingMachineRepository;

class ReturnUserCoinsQueryHandler
{
    public function __construct(
        private readonly VendingMachineRepository $vendingMachineRepository
    ) {
    }

    /**
     * @return float[]
     */
    public function __invoke(ReturnUserCoinsQuery $query): array
    {
        $vendingMachine = $this->vendingMachineRepository->get();

        $coins = $vendingMachine->returnCoins();

        $this->vendingMachineRepository->save($vendingMachine);

        return array_map(static fn(Coin $coin) => $coin->getCoinAsFloat(), $coins);
    }
}