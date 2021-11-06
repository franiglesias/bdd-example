<?php
declare (strict_types=1);

namespace App\Domain;

class Task
{

    private TaskId $id;
    private TaskDescription $description;

    public function __construct(TaskId $id, TaskDescription $description)
    {
        $this->id = $id;
        $this->description = $description;
    }

    public function id(): TaskId
    {
        return $this->id;
    }

    public function description(): TaskDescription
    {
        return $this->description;
    }
}
