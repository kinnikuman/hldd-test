<?php

declare(strict_types=1);

namespace App\VendingMachine\Infrastructure\Domain;

use App\Shared\Domain\Uuid\Uuid;
use App\VendingMachine\Domain\Coin;
use App\VendingMachine\Domain\Item;
use App\VendingMachine\Domain\MachineCoins;
use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;
use Doctrine\DBAL\Connection;
use ReflectionClass;

class VendingMachineRepositoryDBAL implements VendingMachineRepository
{
    public function __construct(
        private readonly Connection $connection,
    ) {
    }

    public function save(VendingMachine $vendingMachine): void
    {
        $queryBuilder = $this->connection->createQueryBuilder();

        $queryBuilder->delete('vending_machine_items')->executeQuery();
        $queryBuilder->delete('vending_machine_coins')->executeQuery();
        $queryBuilder->delete('user_coins')->executeQuery();

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

        foreach ($vendingMachine->getUserCoins() as $coin) {
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

    public function get(): VendingMachine
    {
        $queryBuilder = $this->connection->createQueryBuilder();
        $coinsData = $queryBuilder
            ->select('coin_in_cents')
            ->from('user_coins')
            ->executeQuery()
            ->fetchAllAssociative();

        $userCoins = array_map(static fn(array $coinData) => new Coin($coinData['coin_in_cents']), $coinsData);

        $queryBuilder = $this->connection->createQueryBuilder();
        $machineCoinsData = $queryBuilder
            ->select('coin_in_cents', 'number_of_coins')
            ->from('vending_machine_coins')
            ->executeQuery()
            ->fetchAllAssociative();

        $coins = array_map(
            static fn(array $machineCoinData) => new MachineCoins(
                new Coin($machineCoinData['coin_in_cents']),
                $machineCoinData['number_of_coins'],
            ),
            $machineCoinsData
        );

        $queryBuilder = $this->connection->createQueryBuilder();
        $itemsData = $queryBuilder
            ->select('name', 'count', 'price_in_cents')
            ->from('vending_machine_items')
            ->executeQuery()
            ->fetchAllAssociative();

        $items = array_map(static fn(array $itemData) => new Item(
            $itemData['name'],
            $itemData['count'],
            $itemData['price_in_cents']
        ), $itemsData);

        $reflectionClass = new ReflectionClass(VendingMachine::class);

        return $reflectionClass->newInstanceArgs([$items, $coins, $userCoins]);
    }
}