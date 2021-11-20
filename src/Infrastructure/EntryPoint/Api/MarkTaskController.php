<?php
declare (strict_types = 1);

namespace App\Infrastructure\EntryPoint\Api;

use App\Application\CommandBus;
use App\Application\MarkTaskCompleted\MarkTaskCompleted;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

final class MarkTaskController
{
    private CommandBus $commandBus;

    public function __construct(CommandBus $commandBus)
    {
        $this->commandBus = $commandBus;
    }

    public function __invoke(string $taskId, Request $request): Response
    {
        $payload = json_decode($request->getContent(), true, 512, JSON_THROW_ON_ERROR);

        if ($payload['done']) {
            $markTaskCompleted = new MarkTaskCompleted($taskId);
            $this->commandBus->execute($markTaskCompleted);
        }

        return new JsonResponse(null, Response::HTTP_OK);
    }
}
