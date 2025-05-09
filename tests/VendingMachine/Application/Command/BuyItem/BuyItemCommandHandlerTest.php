<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Command\BuyItem;

use App\Tests\VendingMachine\Domain\VendingMachineRepositorySpy;
use App\VendingMachine\Application\Command\BuyItem\BuyItemCommand;
use App\VendingMachine\Application\Command\BuyItem\BuyItemCommandHandler;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\Item;
use App\VendingMachine\Domain\ItemNotFoundException;
use App\VendingMachine\Domain\ItemOutOfStockException;
use App\VendingMachine\Domain\MachineCoins;
use App\VendingMachine\Domain\NotEnoughChangeException;
use App\VendingMachine\Domain\NotEnoughMoneyException;
use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;
use PHPUnit\Framework\TestCase;

class BuyItemCommandHandlerTest extends TestCase
{

    private BuyItemCommandHandler $commandHandler;
    private VendingMachineRepository $vendingMachineRepositorySpy;

    protected function setUp(): void
    {
        $this->vendingMachineRepositorySpy = new VendingMachineRepositorySpy();
        $this->commandHandler = new BuyItemCommandHandler($this->vendingMachineRepositorySpy);
    }

    public function testBuyItemThatNotExistsMustFail(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(new VendingMachine([], [], []));
        $this->expectException(ItemNotFoundException::class);
        $this->execute('WATER');
    }

    public function testBuyItemWithoutEnoughMoneyMustFail(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 500)], [], []
            )
        );
        $this->expectException(NotEnoughMoneyException::class);
        $this->execute('WATER');
    }

    public function testVendingMachineWithoutEnoughChangeMustFail(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 90)],
                [new MachineCoins(Coin::fromFloat(0.05), 1)],
                [new Coin(100)]
            )
        );
        $this->expectException(NotEnoughChangeException::class);
        $this->execute('WATER');
    }

    public function testBuyItemWithoutStockMustFail(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 0, 100)],
                [],
                [new Coin(100)]
            )
        );
        $this->expectException(ItemOutOfStockException::class);
        $this->execute('WATER');
    }

    public function testBuyWithExactAmountMustReturnOnlyItemName(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 100)],
                [],
                [new Coin(100)]
            )
        );
        $result = $this->execute('WATER');
        self::assertEquals(['WATER'], $result);
    }

    public function testBuyWithoutExactAmountMustReturnItemNameAndChange(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 65)],
                [
                    new MachineCoins(Coin::fromFloat(0.05), 2)
                ],
                [
                    Coin::fromFloat(0.25),
                    Coin::fromFloat(0.25),
                    Coin::fromFloat(0.10),
                    Coin::fromFloat(0.25),
                ]
            )
        );
        $result = $this->execute('WATER');
        self::assertEquals([0.10, 0.05, 0.05, 'WATER'], $result);
    }


    public function testBuyMustDecreaseVendingMachineItems(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 100)],
                [],
                [new Coin(100)]
            )
        );
        $this->execute('WATER');

        $vendingMachine = $this->vendingMachineRepositorySpy->getSavedVendingMachine();
        $machineItems = $vendingMachine->getItems();

        self::assertCount(1, $machineItems);
        self::assertEquals('WATER', $machineItems[0]->getName());
        self::assertEmpty($machineItems[0]->getCount());
    }

    public function testBuyMustUpdateMachineCoins(): void
    {
        $this->vendingMachineRepositorySpy->withVendingMachine(
            new VendingMachine(
                [new Item('WATER', 1, 150)],
                [new MachineCoins(Coin::fromFloat(0.05), 2)],
                [
                    Coin::fromFloat(1),
                    Coin::fromFloat(0.25),
                    Coin::fromFloat(0.10),
                    Coin::fromFloat(0.10),
                    Coin::fromFloat(0.10),
                ],
            )
        );
        $this->execute('WATER');

        $vendingMachine = $this->vendingMachineRepositorySpy->getSavedVendingMachine();
        $machineCoins = $vendingMachine->getCoins();

        self::assertCount(4, $machineCoins);
        self::assertEquals(new MachineCoins(Coin::fromFloat(0.05), 1), $machineCoins[0]);
        self::assertEquals(new MachineCoins(Coin::fromFloat(1), 1), $machineCoins[1]);
        self::assertEquals(new MachineCoins(Coin::fromFloat(0.25), 1), $machineCoins[2]);
        self::assertEquals(new MachineCoins(Coin::fromFloat(0.1), 3), $machineCoins[3]);
    }

    private function execute(string $itemName): array
    {
        return $this->commandHandler->__invoke(new BuyItemCommand($itemName));
    }

}
