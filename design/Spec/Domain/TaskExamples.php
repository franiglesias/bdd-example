<?php
declare (strict_types=1);

namespace Spec\App\Domain;

use App\Domain\Task;
use App\Domain\TaskDescription;
use App\Domain\TaskId;

class TaskExamples
{

    public static function withData(string $id, string $description): Task
    {
        return new Task(
            new TaskId($id),
            new TaskDescription($description)
        );
    }
}
