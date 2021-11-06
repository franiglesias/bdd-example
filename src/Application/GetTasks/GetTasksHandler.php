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

        return $this->transformTasksIntoRepresentation($getTasks, $tasks);
    }

    public function transformTasksIntoRepresentation(GetTasks $getTasks, $tasks): array
    {
        $transformer = $getTasks->transformer();

        return array_map(static fn(Task $task) => $transformer->transform($task), $tasks);
    }
}
