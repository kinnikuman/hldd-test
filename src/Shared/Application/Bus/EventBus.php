<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Domain\Event\Event;

interface EventBus
{
    public function dispatch(Event ...$events): void;
}
