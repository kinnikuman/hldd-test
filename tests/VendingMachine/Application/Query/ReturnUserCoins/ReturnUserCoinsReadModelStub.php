<?php

declare(strict_types=1);


namespace App\Tests\VendingMachine\Application\Query\ReturnUserCoins;

use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsReadModel;

class ReturnUserCoinsReadModelStub implements ReturnUserCoinsReadModel
{

    private array $returnData = [];

    public function all(): array
    {
        return $this->returnData;
    }

    public function willReturn(array $returnData): void
    {
        $this->returnData = $returnData;
    }
}
