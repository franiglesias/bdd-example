<?php

declare(strict_types=1);

namespace Design\App\Contexts;

use Symfony\Component\HttpFoundation\Request;

interface ApiClient
{

	public function apiGet(string $uri): ApiResponse;

	public function apiPostWithPayload(string $uri, array $payload): ApiResponse;
}
