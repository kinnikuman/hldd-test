<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Shared\Application\Bus\CommandBus;
use App\VendingMachine\Application\Command\Service\ItemData;
use App\VendingMachine\Application\Command\Service\MoneyData;
use App\VendingMachine\Application\Command\Service\ServiceCommand;
use RuntimeException;
use JsonException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Symfony\Component\Routing\Annotation\Route;

class ServiceController
{
    public function __construct(private readonly CommandBus $commandBus)
    {
    }

    #[Route('/api/service', methods: Request::METHOD_PUT)]
    public function __invoke(Request $request): JsonResponse
    {
        $command = $this->transformRequestToCommand($request);

        $this->commandBus->execute($command);

        return new JsonResponse([]);
    }

    private function transformRequestToCommand(Request $request): ServiceCommand
    {
        try{
            $requestContent = json_decode($request->getContent(), false, 512, JSON_THROW_ON_ERROR);

            if(!property_exists($requestContent, 'items' )) {
                throw new BadRequestHttpException('Items property not provided');
            }

            if(!property_exists($requestContent, 'money')) {
                throw new BadRequestHttpException('Money property not provided');
            }

            $items = [];

            foreach ($requestContent->items as $item) {
                $this->isValidItemDataOrFail($item);
                $items[] = new ItemData($item->name, $item->count, $item->price);
            }

            $money = [];

            foreach ($requestContent->money as $moneyItem) {
                $this->isValidMoneyItemDataOrFail($moneyItem);
                $money[] = new MoneyData($moneyItem->coinCents, $moneyItem->numberOfCoins);
            }

            return new ServiceCommand($items, $money);


        } catch (JsonException $e) {
            throw new RuntimeException('invalid json request');
        }

    }

    private function isValidItemDataOrFail(object $item): void
    {
        if(!property_exists($item, 'name')) {
            throw new BadRequestHttpException('Item name property not provided');
        }
        if(!property_exists($item, 'count')) {
            throw new BadRequestHttpException('Item count property not provided');
        }
        if(!property_exists($item, 'price')) {
            throw new BadRequestHttpException('Item price property not provided');
        }
        if(!is_string($item->name)) {
            throw new BadRequestHttpException('Item name property must be string');
        }
        if(!is_int($item->count)) {
            throw new BadRequestHttpException('Item count property must be integer');
        }
        if(!is_float($item->price) && !is_int($item->price)) {
            throw new BadRequestHttpException('Item price property must be float or int');
        }
    }

    private function isValidMoneyItemDataOrFail(object $moneyItem): void
    {
        if(!property_exists($moneyItem, 'coinCents')) {
            throw new BadRequestHttpException('Item coinCents property not provided');
        }
        if(!is_int($moneyItem->coinCents)) {
            throw new BadRequestHttpException('Item coinCents property must be integer');
        }
        if(!property_exists($moneyItem, 'numberOfCoins')) {
            throw new BadRequestHttpException('Item numberOfCoins property not provided');
        }
        if(!is_int($moneyItem->numberOfCoins)) {
            throw new BadRequestHttpException('Item numberOfCoins property must be integer');
        }

    }
}
