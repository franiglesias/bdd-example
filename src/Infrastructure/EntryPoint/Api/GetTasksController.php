<?php
declare (strict_types=1);

namespace App\Infrastructure\EntryPoint\Api;

use App\Application\GetTasks\GetTasks;
use App\Application\GetTasks\TaskDataTransformer;
use App\Application\QueryBus;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetTasksController
{
    private QueryBus $queryBus;
    private TaskDataTransformer $taskDataTransformer;

    public function __construct(QueryBus $queryBus, TaskDataTransformer $taskDataTransformer)
    {
        $this->queryBus = $queryBus;
        $this->taskDataTransformer = $taskDataTransformer;
    }

    public function __invoke(): Response
    {
        $getTasks = new GetTasks($this->taskDataTransformer);

        $tasks = $this->queryBus->execute($getTasks);

        return new JsonResponse($tasks, Response::HTTP_OK);
    }
}
