<?php
declare (strict_types=1);

namespace App\Infrastructure\EntryPoint\Api;

use App\Application\AddTask\AddTask;
use App\Application\CommandBus;
use App\Domain\InvalidTaskDescription;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class AddTaskController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(Request $request): Response
    {
        $payload = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        try {
            $this->commandBus->execute(new AddTask($payload['task']));
        } catch (InvalidTaskDescription $invalidTaskDescription) {
            $response = [
                'message' => 'Task description is too short or empty'
            ];
            return new JsonResponse($response, 400);
        }

        return new JsonResponse(null, Response::HTTP_CREATED);
    }
}
