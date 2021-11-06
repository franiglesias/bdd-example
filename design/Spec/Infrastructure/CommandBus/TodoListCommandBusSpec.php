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
    private const TASK_DESCRIPTION = 'Task description';

    public function let($handlerLocator): void
    {
        $this->beConstructedWith($handlerLocator);
    }

    public function it_handles_command_to_handler(HandlerLocator $handlerLocator, AddTaskHandler $addTaskHandler): void
    {
        $handlerLocator->getHandlerFor(AddTask::class)->willReturn($addTaskHandler);
        $addTaskCommand = new AddTask(self::TASK_DESCRIPTION);

        $this->execute($addTaskCommand);

        $addTaskHandler->__invoke($addTaskCommand)->shouldHaveBeenCalled();
    }
}
