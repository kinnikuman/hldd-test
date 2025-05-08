<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\Domain;

use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;
use Doctrine\DBAL\Connection;

class VendingMachineRepositoryDBAL implements VendingMachineRepository
{
    public function __construct(
        private readonly Connection $connection,
    )
    {
    }

    public function save(VendingMachine $vendingMachine): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->delete('vending_machine_items')->executeQuery();
        $queryBuilder->delete('vending_machine_coins')->executeQuery();

        foreach ($vendingMachine->getItems() as $item) {
            $queryBuilder->insert('vending_machine_items')
                ->values([
                    'name' => ':name',
                    'count' => ':count',
                    'price_in_cents' => ':price_in_cents',

                ])
                ->setParameter('name', $item->getName())
                ->setParameter('count', $item->getCount())
                ->setParameter('price_in_cents', $item->getPriceInCents())
                ->executeQuery();
        }

        foreach ($vendingMachine->getCoins() as $coin) {
            $queryBuilder->insert('vending_machine_coins')
                ->values([
                    'coin_in_cents' => ':coin_in_cents',
                    'number_of_coins' => ':number_of_coins',

                ])
                ->setParameter('coin_in_cents', $coin->getCoin()->getCoinCents())
                ->setParameter('number_of_coins', $coin->getNumberOfCoins())
                ->executeQuery();
        }
    }
}