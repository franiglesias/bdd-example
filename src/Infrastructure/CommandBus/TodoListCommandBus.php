<?php
declare (strict_types=1);

namespace App\Infrastructure\CommandBus;

use App\Application\CommandBus;

class TodoListCommandBus implements CommandBus
{

    private HandlerLocator $handlerLocator;

    public function __construct(HandlerLocator $handlerLocator)
    {
        $this->handlerLocator = $handlerLocator;
    }

    public function execute($command): void
    {
        $handler = $this->handlerLocator->getHandlerFor(get_class($command));

        ($handler)($command);
    }
}
