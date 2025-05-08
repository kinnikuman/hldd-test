<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Application\Query\ReturnUserCoins;

use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQuery;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsQueryHandler;
use PHPUnit\Framework\TestCase;

class ReturnUserCoinsQueryHandlerTest extends TestCase
{

    private ReturnUserCoinsQueryHandler $returnUserCoinsQueryHandler;
    private ReturnUserCoinsReadModelStub $returnUserCoinsReadModel;

    protected function setUp(): void
    {
        $this->returnUserCoinsReadModel = new ReturnUserCoinsReadModelStub();
        $this->returnUserCoinsQueryHandler = new ReturnUserCoinsQueryHandler($this->returnUserCoinsReadModel);
    }

    public function testReturnAllUserCoins(): void
    {
        $readModelData = [0.25,0.25,1,0.10];
        $this->returnUserCoinsReadModel->willReturn($readModelData);

        $response = $this->returnUserCoinsQueryHandler->__invoke(new ReturnUserCoinsQuery());

        self::assertEquals($readModelData, $response);
    }

}
