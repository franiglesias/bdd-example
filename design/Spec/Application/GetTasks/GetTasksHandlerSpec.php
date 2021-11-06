<?php

namespace Spec\App\Application\GetTasks;

use App\Application\GetTasks\GetTasks;
use App\Application\GetTasks\GetTasksHandler;
use App\Application\GetTasks\TaskDataTransformer;
use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskId;
use App\Domain\TaskRepository;
use PhpSpec\ObjectBehavior;

/**
 * @mixin GetTasksHandler
 */
class GetTasksHandlerSpec extends ObjectBehavior
{
    public function it_should_get_tasks(TaskRepository $taskRepository, TaskDataTransformer $taskDataTransformer): void
    {
        $task = new Task(
            new TaskId('1'),
            new TaskDescription('Write a test that fails')
        );

        $taskRepository->findAll()->willReturn(
            [
                $task
            ]
        );

        $transformedTask = [
            'id' => 1,
            'description' => 'Write a test that fails',
            'done' => 'no'
        ];

        $taskDataTransformer->transform($task)->willReturn($transformedTask);

        $this->beConstructedWith($taskRepository);

        $getTasks = new GetTasks($taskDataTransformer->getWrappedObject());

        $this->__invoke($getTasks)->shouldEqual(
            [
                $transformedTask
            ]
        );
    }
}
