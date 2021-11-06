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
        $task = $this->buildTask($addTask);

        $this->taskRepository->store($task);
    }

    public function buildTask(AddTask $addTask): Task
    {
        $id = $this->taskIdentityProvider->nextId();

        $description = new TaskDescription($addTask->description());

        return new Task($id, $description);
    }
}
