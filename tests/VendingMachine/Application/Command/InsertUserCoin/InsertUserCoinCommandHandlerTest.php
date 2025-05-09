<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Command\InsertUserCoin;

use App\Tests\VendingMachine\Domain\VendingMachineRepositorySpy;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommand;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommandHandler;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\VendingMachine;
use PHPUnit\Framework\TestCase;

class InsertUserCoinCommandHandlerTest extends TestCase
{

    private InsertUserCoinCommandHandler $insertUserCoinCommandHandler;
    private VendingMachineRepositorySpy $vendingMachineRepository;

    protected function setUp(): void
    {
        $this->vendingMachineRepository = new VendingMachineRepositorySpy();
        $this->insertUserCoinCommandHandler = new InsertUserCoinCommandHandler($this->vendingMachineRepository);
    }

    public function testInsertMoney():void
    {
        $this->vendingMachineRepository->withVendingMachine(new VendingMachine([],[],[]));

        $this->execute(0.10);

        $vendingMachine = $this->vendingMachineRepository->getSavedVendingMachine();

        self::assertEquals([Coin::fromFloat(0.10)], $vendingMachine->getUserCoins());
    }

    private function execute(float $coinValue): void
    {
        $this->insertUserCoinCommandHandler->__invoke(new InsertUserCoinCommand($coinValue));
    }
}
