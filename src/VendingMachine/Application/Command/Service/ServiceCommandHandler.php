<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\Service;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\MachineCoins;
use App\VendingMachine\Domain\Item;
use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;

class ServiceCommandHandler
{
    public function __construct(private readonly VendingMachineRepository $vendingMachineRepository)
    {
    }

    public function __invoke(ServiceCommand $command): void
    {
        $items = array_map(
            static fn(ItemData $itemData) => Item::fromFloatPrice(
                $itemData->name,
                $itemData->count,
                $itemData->price,
            ), $command->items
        );

        $coins = array_map(
            static fn(MoneyData $moneyData) => new MachineCoins(
                new Coin($moneyData->coinCents),
                $moneyData->numberOfCoins,
            ), $command->money
        );

        $this->vendingMachineRepository->save(new VendingMachine($items, $coins));
    }
}