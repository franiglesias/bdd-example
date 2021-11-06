<?php

namespace Spec\App\Infrastructure\DataTransformer;

use App\Infrastructure\DataTransformer\TaskToArrayDataTransformer;
use PhpSpec\ObjectBehavior;
use Spec\App\Application\GetTasks\TaskRepresentationExamples;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin TaskToArrayDataTransformer
 */
class TaskToArrayDataTransformerSpec extends ObjectBehavior
{
    private const ID = '1';
    private const DESCRIPTION = 'Write a test that fails';

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TaskToArrayDataTransformer::class);
    }

    public function it_transforms_task_in_array_representation(): void
    {
        $task = TaskExamples::withData(self::ID, self::DESCRIPTION);

        $this->transform($task)->shouldEqual(
            TaskRepresentationExamples::arrayFromData(self::ID, self::DESCRIPTION)
        );
    }
}
