<?php

namespace Spec\App\Infrastructure\EntryPoint\Api;

use App\Application\CommandBus;
use App\Application\MarkTaskCompleted\MarkTaskCompleted;
use App\Infrastructure\EntryPoint\Api\MarkTaskController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;
use Symfony\Component\HttpFoundation\Request;

/**
 * @mixin MarkTaskController
 */
class MarkTaskControllerSpec extends ObjectBehavior
{
    public function let(CommandBus $commandBus)
    {
        $this->beConstructedWith($commandBus);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(MarkTaskController::class);
    }

    public function it_invokes_mark_task(CommandBus $commandBus): void
    {
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['done' => true], JSON_THROW_ON_ERROR)
        );

        $response = $this->__invoke('1', $request);
        
        $response->getStatusCode()->shouldEqual(200);

        $command = new MarkTaskCompleted('1');
        $commandBus->execute($command)->shouldHaveBeenCalled();
    }

    public function it_should_not_invoke_mark_task_completed(CommandBus $commandBus): void
    {
        $request = new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['done' => false], JSON_THROW_ON_ERROR)
        );

        $response = $this->__invoke('1', $request);

        $response->getStatusCode()->shouldEqual(200);

        $command = new MarkTaskCompleted('1');
        $commandBus->execute($command)->shouldNotHaveBeenCalled();
    }
}
