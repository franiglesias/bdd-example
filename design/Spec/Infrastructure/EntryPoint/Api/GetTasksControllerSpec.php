<?php

namespace Spec\App\Infrastructure\EntryPoint\Api;

use App\Application\GetTasks\GetTasks;
use App\Application\GetTasks\TaskDataTransformer;
use App\Application\QueryBus;
use App\Infrastructure\EntryPoint\Api\GetTasksController;
use PhpSpec\ObjectBehavior;

/**
 * @mixin GetTasksController
 */
class GetTasksControllerSpec extends ObjectBehavior
{
    public function let(QueryBus $queryBus, TaskDataTransformer $dataTransformer): void
    {
        $this->beConstructedWith($queryBus, $dataTransformer);
    }

    public function it_should_respond_with_OK(): void
    {
        $response = $this->__invoke();

        $response->getStatusCode()->shouldBe(200);
    }

    public function it_should_return_empty_collection_when_no_tasks(
        QueryBus $queryBus,
        TaskDataTransformer $dataTransformer
    ): void {
        $getTasksUseCase = new GetTasks($dataTransformer->getWrappedObject());
        $taskCollection = [
            [
                'id' => '1',
                'description' => 'Write a test that fails',
                'done' => 'no'
            ]
        ];
        $queryBus->execute($getTasksUseCase)->willReturn($taskCollection);

        $response = $this->__invoke();

        $queryBus->execute($getTasksUseCase)->shouldHaveBeenCalled();
        $response->getContent()->shouldEqual(json_encode($taskCollection, JSON_THROW_ON_ERROR));
    }
}
