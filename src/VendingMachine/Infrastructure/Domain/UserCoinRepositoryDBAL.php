<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\Domain;

use App\Shared\Domain\Uuid\Uuid;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\UserCoinRepository;
use Doctrine\DBAL\Connection;

class UserCoinRepositoryDBAL implements UserCoinRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function save(Coin $coin): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->insert('user_coins')
            ->values([
                'id' => ':id',
                'coin_in_cents' => ':coin_in_cents',

            ])
            ->setParameter('id', Uuid::generate())
            ->setParameter('coin_in_cents', $coin->getCoinCents())
            ->executeQuery();
    }
}