<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\ReturnUserCoins;

use App\VendingMachine\Domain\UserCoinRepository;

class ReturnUserCoinsCommandHandler
{
    public function __construct(
        private readonly UserCoinRepository $userCoinRepository
    ) {
    }

    public function __invoke(ReturnUserCoinsCommand $command): void
    {
        $this->userCoinRepository->removeAll();
    }
}