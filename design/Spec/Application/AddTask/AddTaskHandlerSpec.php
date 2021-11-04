<?php

namespace Spec\App\Application\AddTask;

use App\Application\AddTask\AddTask;
use App\Application\AddTask\AddTaskHandler;
use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskId;
use App\Domain\TaskIdentityProvider;
use App\Domain\TaskRepository;
use PhpSpec\ObjectBehavior;

/**
 * @mixin AddTaskHandler
 */
class AddTaskHandlerSpec extends ObjectBehavior
{
    public function it_adds_new_task(TaskIdentityProvider $identityProvider, TaskRepository $taskRepository): void
    {
        $this->beConstructedWith($identityProvider, $taskRepository);

        $identityProvider->nextId()->willReturn(new TaskId('1'));

        $this->__invoke(new AddTask('Write a test that fails.'));

        $task = new Task(
            new TaskId('1'),
            new TaskDescription('Write a test that fails.')
        );

        $taskRepository->store($task)->shouldHaveBeenCalled();
    }
}
