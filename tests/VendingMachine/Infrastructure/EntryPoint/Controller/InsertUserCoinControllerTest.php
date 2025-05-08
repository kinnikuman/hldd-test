<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Tests\Shared\Application\Bus\CommandBusSpy;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommand;
use App\VendingMachine\Infrastructure\EntryPoint\Controller\InsertUserCoinController;
use PHPUnit\Framework\TestCase;

class InsertUserCoinControllerTest extends TestCase
{

    private InsertUserCoinController $controller;
    private CommandBusSpy $commandBusSpy;

    protected function setUp(): void
    {
        $this->commandBusSpy = new CommandBusSpy();
        $this->controller = new InsertUserCoinController($this->commandBusSpy);
    }

    public function testRequestWithValidDataMustSendCommand(): void
    {
        $this->execute(0.05);

        self::assertEquals(new InsertUserCoinCommand(0.05), $this->commandBusSpy->getExecutedCommand());
    }

    private function execute(float $value): void
    {
        $this->controller->__invoke($value);
    }
}
