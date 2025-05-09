<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Query\ReturnUserCoins;

use App\Tests\VendingMachine\Domain\VendingMachineRepositorySpy;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQuery;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQueryHandler;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\VendingMachine;
use PHPUnit\Framework\TestCase;

class ReturnUserCoinsQueryHandlerTest extends TestCase
{

    private ReturnUserCoinsQueryHandler $returnUserCoinsQueryHandler;
    private VendingMachineRepositorySpy $vendingMachineRepository;

    protected function setUp(): void
    {
        $this->vendingMachineRepository = new VendingMachineRepositorySpy();
        $this->returnUserCoinsQueryHandler = new ReturnUserCoinsQueryHandler($this->vendingMachineRepository);
    }

    public function testReturnAllUserCoins(): void
    {
        $this->vendingMachineRepository->withVendingMachine(
            new VendingMachine([], [], [Coin::fromFloat(0.1),Coin::fromFloat(1)])
        );

        $response = $this->returnUserCoinsQueryHandler->__invoke(new ReturnUserCoinsQuery());

        self::assertEquals([], $this->vendingMachineRepository->getSavedVendingMachine()->getUserCoins());
        self::assertEquals([0.1,1], $response);
    }

}
