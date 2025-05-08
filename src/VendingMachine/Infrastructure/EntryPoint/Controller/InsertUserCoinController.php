<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Shared\Application\Bus\CommandBus;
use App\VendingMachine\Application\Command\InsertUserCoin\InsertUserCoinCommand;
use App\VendingMachine\Application\Command\Service\ItemData;
use App\VendingMachine\Application\Command\Service\MoneyData;
use App\VendingMachine\Application\Command\Service\ServiceCommand;
use RuntimeException;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class InsertUserCoinController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/api/coins/{coinType}', methods: Request::METHOD_POST)]
    public function __invoke(float $coinType): JsonResponse
    {
        $this->commandBus->execute(new InsertUserCoinCommand($coinType));

        return new JsonResponse([]);
    }
}
