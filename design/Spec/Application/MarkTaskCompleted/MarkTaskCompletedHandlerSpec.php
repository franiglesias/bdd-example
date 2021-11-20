<?php

namespace Spec\App\Application\MarkTaskCompleted;

use App\Application\MarkTaskCompleted\MarkTaskCompleted;
use App\Application\MarkTaskCompleted\MarkTaskCompletedHandler;
use App\Domain\Task;
use App\Domain\TaskId;
use App\Domain\TaskRepository;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin MarkTaskCompletedHandler
 */
class MarkTaskCompletedHandlerSpec extends ObjectBehavior
{
    public function let(TaskRepository $taskRepository): void
    {
        $this->beConstructedWith($taskRepository);    
    }
    
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MarkTaskCompletedHandler::class);
    }

    public function it_should_mark_task_completed(TaskRepository $taskRepository): void
    {
        $task = TaskExamples::withData('1', 'Some description');
        $taskRepository->retrieve(new TaskId('1'))->willReturn($task);
        
        $this->__invoke(new MarkTaskCompleted('1'));

        $taskRepository->store(Argument::that(function (Task $task) {
            return $task->isCompleted();
        }))->shouldHaveBeenCalled();
    }
}
