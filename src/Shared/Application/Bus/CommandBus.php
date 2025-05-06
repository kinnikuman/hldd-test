<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Application\Bus\Message\Command;

interface CommandBus
{
    public function execute(Command $command);
}
