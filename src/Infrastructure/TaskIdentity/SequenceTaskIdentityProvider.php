<?php
declare (strict_types=1);

namespace App\Infrastructure\TaskIdentity;

use App\Domain\TaskId;
use App\Domain\TaskIdentityProvider;
use App\Domain\TaskRepository;

final class SequenceTaskIdentityProvider implements TaskIdentityProvider
{
    private TaskRepository $taskRepository;

    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    public function nextId(): TaskId
    {
        $id = (string)$this->taskRepository->nextId();

        return new TaskId($id);
    }
}
