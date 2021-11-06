<?php

namespace Spec\App\Application\GetTasks;

use App\Application\GetTasks\GetTasks;
use App\Application\GetTasks\GetTasksHandler;
use App\Application\GetTasks\TaskDataTransformer;
use App\Domain\TaskRepository;
use PhpSpec\ObjectBehavior;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin GetTasksHandler
 */
class GetTasksHandlerSpec extends ObjectBehavior
{
    private const TASK_ID = '1';
    private const TASK_DESCRIPTION = 'Write a test that fails';

    public function let(TaskRepository $taskRepository): void
    {
        $this->beConstructedWith($taskRepository);
    }

    public function it_should_get_tasks(
        TaskRepository $taskRepository,
        TaskDataTransformer $taskDataTransformer
    ): void {
        $task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);
        $taskRepository->findAll()->willReturn([$task]);

        $transformedTask = TaskRepresentationExamples::arrayFromData(self::TASK_ID, self::TASK_DESCRIPTION);
        $taskDataTransformer->transform($task)->willReturn($transformedTask);

        $getTasks = new GetTasks($taskDataTransformer->getWrappedObject());

        $this->__invoke($getTasks)->shouldEqual([$transformedTask]);
    }
}
