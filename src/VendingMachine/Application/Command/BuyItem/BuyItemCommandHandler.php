<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\BuyItem;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\VendingMachineRepository;

class BuyItemCommandHandler
{
    public function __construct(private readonly VendingMachineRepository $vendingMachineRepository)
    {
    }

    public function __invoke(BuyItemCommand $command): array
    {
        $vendingMachine = $this->vendingMachineRepository->get();

        $changeCoins = $vendingMachine->buy($command->item);

        $this->vendingMachineRepository->save($vendingMachine);

        $result = array_map(static fn(Coin $coin) => $coin->getCoinAsFloat(), $changeCoins);
        return [...$result, $command->item];
    }
}