<?php
declare (strict_types=1);

namespace App\Infrastructure\QueryBus;

use App\Application\QueryBus;
use App\Infrastructure\CommandBus\HandlerLocator;

final class TodoListQueryBus implements QueryBus
{

    private HandlerLocator $handlerLocator;

    public function __construct(HandlerLocator $handlerLocator)
    {
        $this->handlerLocator = $handlerLocator;
    }

    public function execute($query)
    {
        $handler = $this->handlerLocator->getHandlerFor(get_class($query));

        return ($handler)($query);
    }
}
