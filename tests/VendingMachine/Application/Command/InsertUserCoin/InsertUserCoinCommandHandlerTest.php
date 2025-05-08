<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Command\InsertUserCoin;

use App\Tests\VendingMachine\Domain\UserCoinRepositorySpy;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommand;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommandHandler;
use PHPUnit\Framework\TestCase;

class InsertUserCoinCommandHandlerTest extends TestCase
{

    private InsertUserCoinCommandHandler $insertUserCoinCommandHandler;
    private UserCoinRepositorySpy $userCoinRepository;

    protected function setUp(): void
    {
        $this->userCoinRepository = new UserCoinRepositorySpy();
        $this->insertUserCoinCommandHandler = new InsertUserCoinCommandHandler($this->userCoinRepository);
    }

    public function testInsertMoney():void
    {
        $this->execute(0.10);

        $savedCoin = $this->userCoinRepository->getCoinForSave();

        self::assertEquals(10, $savedCoin->getCoinCents());
    }

    private function execute(float $coinValue): void
    {
        $this->insertUserCoinCommandHandler->__invoke(new InsertUserCoinCommand($coinValue));
    }
}
