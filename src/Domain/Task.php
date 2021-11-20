<?php
declare (strict_types=1);

namespace App\Domain;

class Task
{

    private TaskId $id;
    private TaskDescription $description;
    private bool $done;

    public function __construct(TaskId $id, TaskDescription $description)
    {
        $this->id = $id;
        $this->description = $description;
        $this->done = false;
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function description(): TaskDescription
    {
        return $this->description;
    }

    public function markCompleted(): void
    {
        $this->done = true;
    }

    public function isCompleted(): bool
    {
        return $this->done;
    }
}
