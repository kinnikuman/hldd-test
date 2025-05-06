<?php

declare(strict_types=1);

namespace App\Shared\Domain\Event;

final class EventBag
{
    /** @var Event[]  */
    private static array $events = [];

    public static function addEvent(Event $event): void
    {
        self::$events[] = $event;
    }

    /**
     * @return Event[]
     */
    public static function events(): array
    {
        $events = self::$events;
        self::empty();

        return $events;
    }

    public static function empty(): void
    {
        self::$events = [];
    }
}
