<?php
declare (strict_types=1);

namespace App\Application\MarkTaskCompleted;

class MarkTaskCompleted
{

    private string $taskId;

    public function __construct(string $taskId)
    {
        $this->taskId = $taskId;
    }

    public function taskId(): string
    {
        return $this->taskId;
    }
}
