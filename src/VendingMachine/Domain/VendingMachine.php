<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

class VendingMachine
{
    /**
     * @param Item[] $items
     * @param MachineCoins[] $coins
     * @param Coin[] $userCoins
     */
    public function __construct(
        private readonly array $items,
        private array $coins,
        private array $userCoins = [],
    ) {
    }

    public function getItems(): array
    {
        return $this->items;
    }

    public function getCoins(): array
    {
        return $this->coins;
    }

    /**
     * @return Coin[]
     */
    public function getUserCoins(): array
    {
        return $this->userCoins;
    }

    public function insertCoin(Coin $coin): void
    {
        $this->userCoins[] = $coin;
    }

    /**
     * @return Coin[]
     */
    public function returnCoins(): array
    {
        $userCoins = $this->userCoins;
        $this->userCoins = [];

        return $userCoins;
    }

    /**
     * @return Coin[]
     */
    public function buy(string $item): array
    {
        $machineItem = $this->getItemByName($item);

        $totalCentsInserted = array_reduce(
            $this->userCoins,
            static fn(int $totalCents, Coin $coin) => $totalCents + $coin->getCoinCents(),
            0
        );

        if ($totalCentsInserted < $machineItem->getPriceInCents()) {
            throw NotEnoughMoneyException::forItem($item, $machineItem->getPriceInCents(), $totalCentsInserted);
        }

        $changeToReturn = $totalCentsInserted - $machineItem->getPriceInCents();

        $changeCoins = $this->calculateChange($changeToReturn, $item);

        $machineItem->decrease();
        $this->chargeUserCoins();
        $this->decreaseMachineCoins($changeCoins);

        return $changeCoins;

    }

    private function getItemByName(string $itemName): Item
    {
        foreach ($this->items as $item) {
            if ($item->getName() === $itemName) {
                return $item;
            }
        }

        throw ItemNotFoundException::forItem($itemName);
    }

    /**
     * @return Coin[]
     */
    private function calculateChange(int $amountInCents, string $itemName): array
    {
        if($amountInCents === 0) {
            return [];
        }

        $availableCoins = [];

        foreach ($this->coins as $machineCoin) {
            for ($i = 0; $i < $machineCoin->getNumberOfCoins(); $i++) {
                $availableCoins[] = $machineCoin->getCoin();
            }
        }

        $availableCoins = [...$availableCoins, ...$this->userCoins];

        usort($availableCoins, static fn(Coin $a, Coin $b) => $b->getCoinCents() <=> $a->getCoinCents());

        $changeCoins = [];
        $remaining = $amountInCents;

        foreach ($availableCoins as $coin) {
            if ($coin->getCoinCents() <= $remaining) {
                $changeCoins[] = $coin;
                $remaining -= $coin->getCoinCents();
            }
            if ($remaining === 0) {
                return $changeCoins;
            }
        }

        throw NotEnoughChangeException::forItem($itemName);
    }

    /**
     * @param Coin[] $changeCoins
     */
    private function decreaseMachineCoins(array $changeCoins): void
    {
        foreach ($changeCoins as $changeCoin) {
            foreach ($this->coins as $machineCoin) {
                if ($machineCoin->getCoin()->isEqualTo($changeCoin)) {
                    $machineCoin->decrease();
                    break;
                }
            }
        }
    }

    private function chargeUserCoins(): void
    {
        foreach ($this->userCoins as $userCoin) {
            $added = false;

            foreach ($this->coins as $machineCoin) {
                if ($machineCoin->getCoin()->isEqualTo($userCoin)) {
                    $machineCoin->increase();
                    $added = true;
                    break;
                }
            }

            if (!$added) {
                $this->coins[] = new MachineCoins($userCoin, 1);
            }
        }

        $this->userCoins = [];
    }

}