<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Domain;

use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;

class VendingMachineRepositorySpy implements VendingMachineRepository
{
    private ?VendingMachine $vendingMachine = null;
    private ?VendingMachine $vendingMachineForSave = null;

    public function save(VendingMachine $vendingMachine): void
    {
        $this->vendingMachineForSave = $vendingMachine;
    }

    public function getSavedVendingMachine(): VendingMachine
    {
        return $this->vendingMachineForSave;
    }

    public function get(): VendingMachine
    {
        return $this->vendingMachine;
    }

    public function withVendingMachine(VendingMachine $vendingMachine): void
    {
        $this->vendingMachine = $vendingMachine;
    }
}
