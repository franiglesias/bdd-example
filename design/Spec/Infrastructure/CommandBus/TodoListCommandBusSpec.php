<?php

namespace Spec\App\Infrastructure\CommandBus;

use App\Application\AddTask\AddTask;
use App\Application\AddTask\AddTaskHandler;
use App\Infrastructure\CommandBus\HandlerLocator;
use App\Infrastructure\CommandBus\TodoListCommandBus;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TodoListCommandBus
 */
class TodoListCommandBusSpec extends ObjectBehavior
{
    public function it_handles_command_to_handler(HandlerLocator $handlerLocator, AddTaskHandler $addTaskHandler): void
    {
        $taskDescription = 'Task description';

        $handlerLocator->getHandlerFor(AddTask::class)->willReturn($addTaskHandler);

        $this->beConstructedWith($handlerLocator);

        $this->execute(new AddTask($taskDescription));

        $addTaskHandler->__invoke(new AddTask($taskDescription))->shouldHaveBeenCalled();
    }
}
