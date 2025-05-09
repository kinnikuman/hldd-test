<?php

declare(strict_types=1);

namespace App\Shared\Infrastructure\Application\Bus;

use App\Shared\Application\Bus\CommandBus;
use App\Shared\Application\Bus\Message\Command;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\HandleTrait;
use Symfony\Component\Messenger\MessageBusInterface;

class MessengerCommandBus implements CommandBus
{
    use HandleTrait;

    public function __construct(MessageBusInterface $messageBus)
    {
        $this->messageBus = $messageBus;
    }

    public function execute(Command $command)
    {
        try {
            return $this->handle($command);
        } catch (HandlerFailedException $e) {
            throw $e->getPrevious();
        }
    }
}
