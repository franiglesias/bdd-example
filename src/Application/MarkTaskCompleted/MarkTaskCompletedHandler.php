<?php
declare (strict_types = 1);

namespace App\Application\MarkTaskCompleted;

use App\Domain\TaskId;
use App\Domain\TaskRepository;

final class MarkTaskCompletedHandler
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(MarkTaskCompleted $markTaskCompleted): void
    {
        $taskId = new TaskId($markTaskCompleted->taskId());
        $task = $this->taskRepository->retrieve($taskId);
        
        $task->markCompleted();
        
        $this->taskRepository->store($task);
    }
}
