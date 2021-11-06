<?php
declare (strict_types=1);

namespace App\Application\GetTasks;

final class GetTasks
{

    private TaskDataTransformer $taskDataTransformer;

    public function __construct(TaskDataTransformer $taskDataTransformer)
    {
        $this->taskDataTransformer = $taskDataTransformer;
    }

    public function transformer(): TaskDataTransformer
    {
        return $this->taskDataTransformer;
    }
}
