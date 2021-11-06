<?php
declare (strict_types=1);

namespace App\Application\GetTasks;

use App\Domain\Task;
use App\Domain\TaskRepository;

class GetTasksHandler
{
    private TaskRepository $taskRepository;

    public function __construct(
        TaskRepository $taskRepository
    ) {
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(GetTasks $getTasks): array
    {
        $tasks = $this->taskRepository->findAll();

        $transformer = $getTasks->transformer();

        return array_map(static fn(Task $task) => $transformer->transform($task), $tasks);
    }
}
