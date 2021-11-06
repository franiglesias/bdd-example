<?php
declare (strict_types=1);

namespace App\Application\GetTasks;

use App\Domain\Task;

interface TaskDataTransformer
{

    public function transform(Task $task): array;
}
