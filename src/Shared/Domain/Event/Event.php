<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

use Stringable;

abstract class Event implements Stringable
{
    public readonly DateTimeImmutable $occurredOn;
    public readonly string $id;

    protected function __construct()
    {
        $this->occurredOn = new DateTimeImmutable('now', new DateTimeZone('UTC'));
        $this->id = uniqid('', true);
    }

    public function __toString(): string
    {
        $nameParts = explode('\\', get_class($this));

        return sprintf(
            '[%s] id: "%s", message: "%s",',
            $this->occurredOn->format('Y-m-d H:i:s'),
            $this->id,
            end($nameParts)
        );
    }
}
