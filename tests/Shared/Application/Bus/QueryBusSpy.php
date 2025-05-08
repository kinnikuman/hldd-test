<?php

declare(strict_types=1);

namespace App\Tests\Shared\Application\Bus;

use App\Shared\Application\Bus\Message\Query;
use App\Shared\Application\Bus\QueryBus;

class QueryBusSpy implements QueryBus
{

    private ?Query $executedQuery = null;
    private mixed $response = null;

    public function execute(Query $query): mixed
    {
        $this->executedQuery = $query;
        return $this->response;
    }

    public function getExecutedQuery(): Query
    {
        return $this->executedQuery;
    }

    public function willReturn(mixed $response): void
    {
        $this->response = $response;
    }
}
