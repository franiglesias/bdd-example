<?php
declare (strict_types=1);

namespace App\Infrastructure\CommandBus;

use App\Application\AddTaskHandler;
use App\Domain\TaskIdentityProvider;
use App\Domain\TaskRepository;

class HandlerLocator
{
    private array $handlers = [];

    public function getHandlerFor($command): object
    {
        return $this->handlers[$command];
    }

    public function registerHandler(string $commandFQCN, object $handler): void
    {
        $this->handlers[$commandFQCN] = $handler;
    }
}
