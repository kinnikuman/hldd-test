<?php

declare(strict_types=1);

namespace App\Shared\Application\Bus;

use App\Shared\Application\Bus\Message\Query;

interface QueryBus
{
    public function execute(Query $query);
}
