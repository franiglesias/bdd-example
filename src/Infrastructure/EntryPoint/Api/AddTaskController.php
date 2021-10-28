<?php
declare (strict_types=1);

namespace App\Infrastructure\EntryPoint\Api;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;

class AddTaskController
{
    public function __invoke()
    {
        throw new \RuntimeException('Implement __invoke() method.');
    }
}
