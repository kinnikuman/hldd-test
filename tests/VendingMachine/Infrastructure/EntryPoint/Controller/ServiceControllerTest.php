<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Infrastructure\EntryPoint\Controller;

use App\Tests\Shared\Application\Bus\CommandBusSpy;
use App\VendingMachine\Application\Command\Service\ItemData;
use App\VendingMachine\Application\Command\Service\MoneyData;
use App\VendingMachine\Application\Command\Service\ServiceCommand;
use App\VendingMachine\Infrastructure\EntryPoint\Controller\ServiceController;
use PHPUnit\Framework\TestCase;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;

class ServiceControllerTest extends TestCase
{
    private ServiceController $controller;
    private CommandBusSpy $commandBusSpy;

    protected function setUp(): void
    {
        $this->commandBusSpy = new CommandBusSpy();
        $this->controller = new ServiceController($this->commandBusSpy);
    }

    /**
     * @dataProvider invalidDataProvider
     */
    public function testRequestWithInvalidDataMustFail(Request $request): void
    {
        $this->expectException(BadRequestHttpException::class);
        $this->execute($request);
    }

    public function invalidDataProvider(): array
    {
        return [
            [ServiceRequestMother::withoutItems()],
            [ServiceRequestMother::withoutMoney()],
            [ServiceRequestMother::withoutItemName()],
            [ServiceRequestMother::withoutItemCount()],
            [ServiceRequestMother::withoutItemPrice()],
            [ServiceRequestMother::withoutMoneyCoinCents()],
            [ServiceRequestMother::withoutMoneyNumberOfCoins()],
            [ServiceRequestMother::withWrongTypeItemName()],
            [ServiceRequestMother::withWrongTypeItemCount()],
            [ServiceRequestMother::withWrongTypePriceCount()],
            [ServiceRequestMother::withWrongTypeMoneyCoinCents()],
            [ServiceRequestMother::withWrongTypeMoneyCoinNumberOfCoins()],
        ];
    }

    public function testRequestWithValidDataMustSendCommand(): void
    {
        $data = [
            'items' => [['name' => 'WATER', 'count' => 100, 'price' => 1]],
            'money' => [['coinCents' => 100, 'numberOfCoins' => 1]]
        ];

        $request = ServiceRequestMother::withValiData($data);
        $this->execute($request);

        $items = [new ItemData('WATER', 100, 1)];
        $money = [new MoneyData(100, 1)];

        self::assertEquals(new ServiceCommand($items, $money), $this->commandBusSpy->getExecutedCommand());
    }

    private function execute(Request $request): JsonResponse
    {
        return $this->controller->__invoke($request);
    }

}
