<?php

declare(strict_types=1);

namespace App\VendingMachine\Domain;

interface VendingMachineRepository
{
    public function save(VendingMachine $vendingMachine): void;

    public function get(): VendingMachine;
}