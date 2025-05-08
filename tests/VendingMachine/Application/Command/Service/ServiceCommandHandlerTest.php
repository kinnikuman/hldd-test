<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Command\Service;

use App\Tests\VendingMachine\Domain\VendingMachineRepositorySpy;
use App\VendingMachine\Application\Command\Service\ItemData;
use App\VendingMachine\Application\Command\Service\MoneyData;
use App\VendingMachine\Application\Command\Service\ServiceCommand;
use App\VendingMachine\Application\Command\Service\ServiceCommandHandler;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\InvalidMachineCoinException;
use App\VendingMachine\Domain\MachineCoins;
use App\VendingMachine\Domain\InvalidCoinException;
use App\VendingMachine\Domain\InvalidItemException;
use App\VendingMachine\Domain\Item;
use App\VendingMachine\Domain\VendingMachineRepository;
use PHPUnit\Framework\TestCase;

class ServiceCommandHandlerTest extends TestCase
{

    private ServiceCommandHandler $serviceCommandHandler;
    private VendingMachineRepository $vendingMachineRepositorySpy;

    protected function setUp(): void
    {
        $this->vendingMachineRepositorySpy = new VendingMachineRepositorySpy();
        $this->serviceCommandHandler = new ServiceCommandHandler($this->vendingMachineRepositorySpy);
    }

    public function testWhenItemPriceIsZeroMustFail():void
    {
        $items = [new ItemData('WATER', 1, 0.0)];
        $money = [new MoneyData(100, 10)];

        $this->expectException(InvalidItemException::class);
        $this->execute($items, $money);
    }

    public function testWhenItemCountIsLowerThanZeroMustFail():void
    {
        $items = [new ItemData('WATER', -1, 0.25)];
        $money = [new MoneyData(100, 10)];

        $this->expectException(InvalidItemException::class);
        $this->execute($items, $money);
    }

    public function testWhenMoneyTypeIsNotValidMustFail():void
    {
        $items = [new ItemData('WATER', 1, 0.25)];
        $money = [new MoneyData(22, 10)];

        $this->expectException(InvalidCoinException::class);
        $this->execute($items, $money);
    }

    public function testWhenMoneyNumberOfCoinsIsLowerThanZeroMustFail():void
    {
        $items = [new ItemData('WATER', 1, 0.25)];
        $money = [new MoneyData(100, -1)];

        $this->expectException(InvalidMachineCoinException::class);
        $this->execute($items, $money);
    }

    public function testMustUpdateVendorMachineItemsAndMoney():void
    {
        $items = [new ItemData('WATER', 1, 0.25)];
        $money = [new MoneyData(100, 2)];

        $this->execute($items, $money);

        $savedVendorMachine = $this->vendingMachineRepositorySpy->getVendingMachineForSave();

        self::assertEquals([new Item('WATER', 1, 25)], $savedVendorMachine->getItems());
        self::assertEquals([new MachineCoins( new Coin(100), 2)], $savedVendorMachine->getCoins());
    }


    /**
     * @param ItemData[] $items
     * @param MoneyData[] $money
     * @return void
     */
    private function execute(array $items, array $money): void
    {
        $this->serviceCommandHandler->__invoke(new ServiceCommand($items, $money));
    }


}
