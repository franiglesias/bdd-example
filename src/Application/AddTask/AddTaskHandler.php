<?php
declare (strict_types=1);

namespace App\Application\AddTask;

use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskIdentityProvider;
use App\Domain\TaskRepository;

class AddTaskHandler
{
    private TaskIdentityProvider $taskIdentityProvider;
    private TaskRepository $taskRepository;

    public function __construct(TaskIdentityProvider $taskIdentityProvider, TaskRepository $taskRepository)
    {
        $this->taskIdentityProvider = $taskIdentityProvider;
        $this->taskRepository = $taskRepository;
    }

    public function __invoke(AddTask $addTask): void
    {
        $id = $this->taskIdentityProvider->nextId();

        $description = new TaskDescription($addTask->description());

        $task = new Task($id, $description);

        $this->taskRepository->store($task);
    }
}
