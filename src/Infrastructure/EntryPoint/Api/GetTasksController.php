<?php
declare (strict_types=1);

namespace App\Infrastructure\EntryPoint\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class GetTasksController
{
    public function __invoke(): Response
    {
        $tasks = [
            [
                'id' => '1',
                'description' => 'Write a test that fails',
                'done' => 'no'
            ]
        ];

        return new JsonResponse($tasks, Response::HTTP_OK);
    }
}
