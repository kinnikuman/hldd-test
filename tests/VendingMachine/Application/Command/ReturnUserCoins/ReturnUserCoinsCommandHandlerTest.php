<?php

declare(strict_types=1);


namespace App\Tests\VendingMachine\Application\Command\ReturnUserCoins;

use App\Tests\VendingMachine\Domain\UserCoinRepositorySpy;
use App\VendingMachine\Application\Command\ReturnUserCoins\ReturnUserCoinsCommand;
use App\VendingMachine\Application\Command\ReturnUserCoins\ReturnUserCoinsCommandHandler;
use PHPUnit\Framework\TestCase;

class ReturnUserCoinsCommandHandlerTest extends TestCase
{

    private ReturnUserCoinsCommandHandler $returnUserCoinsCommandHandler;
    private UserCoinRepositorySpy $userCoinRepository;

    protected function setUp(): void
    {
        $this->userCoinRepository = new UserCoinRepositorySpy();
        $this->returnUserCoinsCommandHandler = new ReturnUserCoinsCommandHandler($this->userCoinRepository);
    }

    public function testRemoveAllUserCoins():void
    {
        $this->execute();
        self::assertTrue($this->userCoinRepository->removeAllHasBeenCalled());
    }

    private function execute(): void
    {
        $this->returnUserCoinsCommandHandler->__invoke(new ReturnUserCoinsCommand());
    }
}
