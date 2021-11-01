<?php
declare (strict_types=1);

namespace App\Application\AddTask;

class AddTask
{

    private string $taskDescription;

    public function __construct(string $taskDescription)
    {
        $this->taskDescription = $taskDescription;
    }

    public function description(): string
    {
        return $this->taskDescription;
    }
}
