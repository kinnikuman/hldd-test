<?php

declare(strict_types=1);


namespace App\Tests\Shared\Application\Bus;

use App\Shared\Application\Bus\CommandBus;
use App\Shared\Application\Bus\Message\Command;

class CommandBusSpy implements CommandBus
{

    private ?Command $executedCommand = null;

    public function execute(Command $command): void
    {
        $this->executedCommand = $command;
    }

    public function getExecutedCommand(): Command
    {
        return $this->executedCommand;
    }
}
