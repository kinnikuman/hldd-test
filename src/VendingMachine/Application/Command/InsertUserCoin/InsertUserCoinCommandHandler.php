<?php

declare(strict_types=1);

namespace App\VendingMachine\Application\Command\InsertUserCoin;

use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\UserCoinRepository;

class InsertUserCoinCommandHandler
{
    public function __construct(private readonly UserCoinRepository $userCoinRepository)
    {
    }

    public function __invoke(InsertUserCoinCommand $command): void
    {
        $this->userCoinRepository->save(Coin::fromFloat($command->coinValue));
    }
}