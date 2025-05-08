<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Tests\Shared\Application\Bus\CommandBusSpy;
use App\Tests\Shared\Application\Bus\QueryBusSpy;
use App\VendingMachine\Application\Command\ReturnUserCoins\ReturnUserCoinsCommand;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQuery;
use App\VendingMachine\Infrastructure\EntryPoint\Controller\ReturnUserCoinsController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;

class ReturnUserCoinsControllerTest extends TestCase
{

    private ReturnUserCoinsController $controller;
    private CommandBusSpy $commandBusSpy;
    private QueryBusSpy $queryBusSpy;

    protected function setUp(): void
    {
        $this->commandBusSpy = new CommandBusSpy();
        $this->queryBusSpy = new QueryBusSpy();
        $this->controller = new ReturnUserCoinsController(
            $this->queryBusSpy,
            $this->commandBusSpy
        );
    }

    public function testMustSendQuery(): void
    {
        $queryResponse = [0.25, 0.25, 0.10, 1];
        $this->queryBusSpy->willReturn($queryResponse);

        $response = $this->execute();

        self::assertEquals(new ReturnUserCoinsQuery(), $this->queryBusSpy->getExecutedQuery());

        $decodedResponse = json_decode($response->getContent());

        self::assertEquals($decodedResponse, $queryResponse);
    }

    public function testMustSendCommand(): void
    {
        $this->execute();

        self::assertEquals(new ReturnUserCoinsCommand(), $this->commandBusSpy->getExecutedCommand());
    }

    private function execute(): JsonResponse
    {
        return $this->controller->__invoke();
    }
}
