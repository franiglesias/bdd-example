<?php

namespace Spec\App\Infrastructure\CommandBus;

use App\Application\AddTask\AddTask;
use App\Application\AddTask\AddTaskHandler;
use App\Infrastructure\CommandBus\HandlerLocator;
use PhpSpec\ObjectBehavior;

/**
 * @mixin HandlerLocator
 */
class HandlerLocatorSpec extends ObjectBehavior
{
    public function let(AddTaskHandler $addTaskHandler): void
    {
        $this->beConstructedWith();
        $this->registerHandler(AddTask::class, $addTaskHandler);
    }

    public function it_associates_add_task_with_handler(): void
    {
        $handler = $this->getHandlerFor(AddTask::class);

        $handler->shouldHaveType(AddTaskHandler::class);
    }
}
