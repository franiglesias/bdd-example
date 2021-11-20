<?php
declare (strict_types=1);

namespace App\Infrastructure\DataTransformer;

use App\Application\GetTasks\TaskDataTransformer;
use App\Domain\Task;

final class TaskToArrayDataTransformer implements TaskDataTransformer
{

    public function transform(Task $task): array
    {
        return [
            'id' => $task->id()->toString(),
            'description' => $task->description()->toString(),
            'done' => $task->isCompleted() ? 'yes' : 'no'
        ];
    }
}
