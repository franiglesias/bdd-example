<?php

namespace Spec\App\Infrastructure\DataTransformer;

use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskId;
use App\Infrastructure\DataTransformer\TaskToArrayDataTransformer;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TaskToArrayDataTransformer
 */
class TaskToArrayDataTransformerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TaskToArrayDataTransformer::class);
    }

    public function it_transforms_task_in_array_representation(): void
    {
        $task = new Task(
            new TaskId('1'),
            new TaskDescription('Write a test that fails')
        );

        $this->transform($task)->shouldEqual(
            [
                'id' => '1',
                'description' => 'Write a test that fails',
                'done' => 'no'
            ]
        );
    }
}
