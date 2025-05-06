<?php

declare(strict_types=1);

namespace App\Shared\Domain\Uuid;

use Ramsey\Uuid\Uuid as RamseyUuid;

class Uuid
{
    private function __construct(private readonly string $id)
    {
    }

    public function __toString()
    {
        return $this->id;
    }

    public static function generate(): self
    {
        return new self((RamseyUuid::uuid4())->toString());
    }
}
