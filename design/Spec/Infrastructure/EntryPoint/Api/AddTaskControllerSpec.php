<?php

namespace Spec\App\Infrastructure\EntryPoint\Api;

use App\Application\AddTask\AddTask;
use App\Application\CommandBus;
use App\Domain\InvalidTaskDescription;
use App\Infrastructure\EntryPoint\Api\AddTaskController;
use PhpSpec\ObjectBehavior;
use Symfony\Component\HttpFoundation\Request;

/**
 * @mixin AddTaskController
 */
class AddTaskControllerSpec extends ObjectBehavior
{
    private const TASK_DESCRIPTION = 'Write a test that fails.';
    private const ANOTHER_TASK_DESCRIPTION = 'Write code to make test pass.';

    public function let(CommandBus $commandBus): void
    {
        $this->beConstructedWith($commandBus);
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AddTaskController::class);
    }

    public function it_returns_created_status(): void
    {
        $response = $this->__invoke($this->requestWithPayload(self::TASK_DESCRIPTION));

        $response->getStatusCode()->shouldBe(201);
    }

    public function it_invokes_add_task_command_with_task_description(CommandBus $commandBus): void
    {
        $this->__invoke($this->requestWithPayload(self::TASK_DESCRIPTION));

        $commandBus->execute(new AddTask(self::TASK_DESCRIPTION))->shouldHaveBeenCalled();
    }

    public function it_invokes_add_task_command_with_another_task_description(CommandBus $commandBus): void
    {
        $this->__invoke($this->requestWithPayload(self::ANOTHER_TASK_DESCRIPTION));

        $commandBus->execute(new AddTask(self::ANOTHER_TASK_DESCRIPTION))->shouldHaveBeenCalled();
    }

    public function it_fails_with_bad_request_when_task_description_is_empty(CommandBus $commandBus): void
    {
        $commandBus->execute(new AddTask(''))->willThrow(InvalidTaskDescription::class);
        
        $response = $this->__invoke($this->requestWithPayload(''));

        $response->getStatusCode()->shouldBe(400);
    }

    public function it_notifies_error_when_task_description_is_empty(CommandBus $commandBus): void
    {
        $commandBus->execute(new AddTask(''))->willThrow(InvalidTaskDescription::class);

        $response = $this->__invoke($this->requestWithPayload(''));

        $payload = ['message' => 'Task description is too short or empty'];
        $response->getContent()->shouldBe(json_encode($payload, JSON_THROW_ON_ERROR));
    }

    private function requestWithPayload(string $taskDescription): Request
    {
        return new Request(
            [],
            [],
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['task' => $taskDescription], JSON_THROW_ON_ERROR)
        );
    }
}
