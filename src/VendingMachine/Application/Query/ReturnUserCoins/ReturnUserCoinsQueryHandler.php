<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Query\ReturnUserCoins;


class ReturnUserCoinsQueryHandler
{
    public function __construct(
        private readonly ReturnUserCoinsReadModel $returnUserCoinsReadModel,
    ) {
    }

    /**
     * @return float[]
     */
    public function __invoke(ReturnUserCoinsQuery $command): array
    {
        return $this->returnUserCoinsReadModel->all();
    }
}