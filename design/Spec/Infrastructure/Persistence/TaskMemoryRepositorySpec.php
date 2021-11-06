<?php

namespace Spec\App\Infrastructure\Persistence;

use App\Infrastructure\Persistence\TaskMemoryRepository;
use PhpSpec\ObjectBehavior;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin TaskMemoryRepository
 */
class TaskMemoryRepositorySpec extends ObjectBehavior
{
    private const TASK_ID = '1';
    private const TASK_DESCRIPTION = 'Write a test that fails.';
    private const ANOTHER_TASK_ID = '2';
    private const ANOTHER_TASK_DESCRIPTION = 'Write code to make test pass';

    public function it_stores_tasks(): void
    {
        $task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);

        $this->store($task);
        $this->nextId()->shouldBe(2);
    }

    public function it_retrieves_all_tasks(): void
    {
        $task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);
        $anotherTask = TaskExamples::withData(self::ANOTHER_TASK_ID, self::ANOTHER_TASK_DESCRIPTION);

        $this->store($task);
        $this->store($anotherTask);
        $this->findAll()->shouldEqual([$task, $anotherTask]);
    }
}
