<?php

declare(strict_types=1);


namespace App\Tests\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Tests\Shared\Application\Bus\CommandBusSpy;
use App\VendingMachine\Application\Command\BuyItem\BuyItemCommand;
use App\VendingMachine\Infrastructure\EntryPoint\Controller\BuyItemController;
use PHPUnit\Framework\TestCase;

class BuyItemControllerTest extends TestCase
{

    private BuyItemController $controller;
    private CommandBusSpy $commandBusSpy;

    protected function setUp(): void
    {
        $this->commandBusSpy = new CommandBusSpy();
        $this->controller = new BuyItemController($this->commandBusSpy);
    }

    public function testMustSendCommand(): void
    {
        $this->execute();

        self::assertEquals(new BuyItemCommand('WATER'), $this->commandBusSpy->getExecutedCommand());
    }

    private function execute(): void
    {
        $this->controller->__invoke('WATER');
    }
}
