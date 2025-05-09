<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Shared\Application\Bus\CommandBus;
use App\VendingMachine\Application\Command\BuyItem\BuyItemCommand;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class BuyItemController
{
    public function __construct(
        private readonly CommandBus $commandBus,
    ) {
    }

    #[Route('/api/items/{item}/buy', methods: Request::METHOD_POST)]
    public function __invoke(string $item): JsonResponse
    {
        $result = $this->commandBus->execute(new BuyItemCommand($item));

        return new JsonResponse($result);
    }
}
