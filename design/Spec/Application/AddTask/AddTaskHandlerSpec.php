<?php

namespace Spec\App\Application\AddTask;

use App\Application\AddTask\AddTask;
use App\Application\AddTask\AddTaskHandler;
use App\Domain\TaskId;
use App\Domain\TaskIdentityProvider;
use App\Domain\TaskRepository;
use PhpSpec\ObjectBehavior;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin AddTaskHandler
 */
class AddTaskHandlerSpec extends ObjectBehavior
{
    private const TASK_ID = '1';
    private const TASK_DESCRIPTION = 'Write a test that fails.';

    public function let(
        TaskIdentityProvider $identityProvider,
        TaskRepository $taskRepository
    ): void {
        $this->beConstructedWith($identityProvider, $taskRepository);
    }

    public function it_adds_new_task(
        TaskIdentityProvider $identityProvider,
        TaskRepository $taskRepository
    ): void {
        $identityProvider->nextId()->willReturn(new TaskId(self::TASK_ID));

        $this->__invoke(new AddTask(self::TASK_DESCRIPTION));

        $task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);
        $taskRepository->store($task)->shouldHaveBeenCalled();
    }
}
