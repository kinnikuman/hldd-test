<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\Domain;

use App\Shared\Domain\Uuid\Uuid;
use App\VendingMachine\Application\Query\ReturnUserCoins\ReturnUserCoinsReadModel;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\UserCoinRepository;
use Doctrine\DBAL\Connection;

class UserCoinRepositoryDBAL implements UserCoinRepository, ReturnUserCoinsReadModel
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

    /**
     * @return float[]
     */
    public function all(): array
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $data = $queryBuilder
            ->select('coin_in_cents')
            ->from('user_coins')
            ->executeQuery()
            ->fetchAllAssociative();

        return array_map(static fn(array $item) => $item['coin_in_cents'] / 100, $data);
    }

    public function removeAll(): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $queryBuilder->delete('user_coins')->executeQuery();
    }
}