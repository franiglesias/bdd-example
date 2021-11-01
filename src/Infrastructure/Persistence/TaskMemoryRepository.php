<?php
declare (strict_types=1);

namespace App\Infrastructure\Persistence;

use App\Domain\Task;
use App\Domain\TaskRepository;

final class TaskMemoryRepository implements TaskRepository
{
    private array $tasks = [];

    public function store(Task $task): void
    {
        $this->tasks[(string)$task->id()] = $task;
    }

    public function nextId(): int
    {
        $max = array_reduce(
            $this->tasks,
            static fn($max, $task) => max((int)(string)$task->id(), $max),
            0
        );

        return $max + 1;
    }
}
