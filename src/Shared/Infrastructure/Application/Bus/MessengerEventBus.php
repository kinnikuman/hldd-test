<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Application\Bus;

use App\Shared\Application\Bus\EventBus;
use App\Shared\Domain\Event\Event;
use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;
use Symfony\Component\Messenger\Stamp\DispatchAfterCurrentBusStamp;

class MessengerEventBus implements EventBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function dispatch(Event ...$events): void
    {
        array_walk(
            $events,
            function ($event) {
                $this->handle($event);
            }
        );
    }

    private function dispatchEvent(Event $event): void
    {
        try {
            $this->messageBus->dispatch((new Envelope($event))->with(new DispatchAfterCurrentBusStamp()));
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
