<?php

namespace Spec\App\Infrastructure\QueryBus;

use App\Application\GetTasks\GetTasks;
use App\Application\GetTasks\GetTasksHandler;
use App\Application\GetTasks\TaskDataTransformer;
use App\Infrastructure\CommandBus\HandlerLocator;
use App\Infrastructure\QueryBus\TodoListQueryBus;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TodoListQueryBus
 */
class TodoListQueryBusSpec extends ObjectBehavior
{
    public function it_handles_command_to_handler(
        HandlerLocator $handlerLocator,
        GetTasksHandler $getTasksHandler,
        TaskDataTransformer $taskDataTransformer
    ): void {
        $handlerLocator->getHandlerFor(GetTasks::class)->willReturn($getTasksHandler);
        $getTasksQuery = new GetTasks($taskDataTransformer->getWrappedObject());

        $getTasksHandler->__invoke($getTasksQuery)->willReturn(['tasks collection']);
        $this->beConstructedWith($handlerLocator);

        $this->execute($getTasksQuery)->shouldEqual(['tasks collection']);

        $getTasksHandler->__invoke($getTasksQuery)->shouldHaveBeenCalled();
    }
}
