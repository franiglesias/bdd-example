<?php

namespace Spec\App\Infrastructure\Persistence;

use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskId;
use App\Infrastructure\Persistence\TaskMemoryRepository;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TaskMemoryRepository
 */
class TaskMemoryRepositorySpec extends ObjectBehavior
{
    public function it_stores_tasks(): void
    {
        $task = new Task(
            new TaskId('1'),
            new TaskDescription('Write a test that fails')
        );
        $this->store($task);
        $this->nextId()->shouldBe(2);
    }
}
