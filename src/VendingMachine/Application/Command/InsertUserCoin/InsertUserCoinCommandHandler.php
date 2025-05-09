<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\InsertUserCoin;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\VendingMachineRepository;

class InsertUserCoinCommandHandler
{
    public function __construct(private readonly VendingMachineRepository $vendingMachineRepository)
    {
    }

    public function __invoke(InsertUserCoinCommand $command): void
    {
        $vendingMachine = $this->vendingMachineRepository->get();

        $vendingMachine->insertCoin(Coin::fromFloat($command->coinValue));
        $this->vendingMachineRepository->save($vendingMachine);
    }
}