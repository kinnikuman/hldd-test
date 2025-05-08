<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Shared\Application\Bus\CommandBus;
use App\Shared\Application\Bus\QueryBus;
use App\VendingMachine\Application\Command\ReturnUserCoins\ReturnUserCoinsCommand;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQuery;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ReturnUserCoinsController
{
    public function __construct(
        private readonly QueryBus $queryBus,
        private readonly CommandBus $commandBus,
    )
    {
    }

    #[Route('/api/coins', methods: Request::METHOD_GET)]
    public function __invoke(): JsonResponse
    {
        $coinsToReturn = $this->queryBus->execute(new ReturnUserCoinsQuery());
        $this->commandBus->execute(new ReturnUserCoinsCommand());

        return new JsonResponse($coinsToReturn);
    }
}
