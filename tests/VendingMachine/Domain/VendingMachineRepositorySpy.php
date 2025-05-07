<?php

declare(strict_types=1);

namespace App\Tests\VendingMachine\Domain;

use App\VendingMachine\Domain\VendingMachine;
use App\VendingMachine\Domain\VendingMachineRepository;

class VendingMachineRepositorySpy implements VendingMachineRepository
{
    private ?VendingMachine $vendingMachineForSave = null;

    public function save(VendingMachine $vendingMachine): void
    {
        $this->vendingMachineForSave = $vendingMachine;
    }

    public function getVendingMachineForSave(): VendingMachine
    {
        return $this->vendingMachineForSave;
    }
}
