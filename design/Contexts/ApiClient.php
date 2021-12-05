<?php

declare(strict_types=1);

namespace Design\App\Contexts;

interface ApiClient
{

	public function apiGet(string $uri): ApiResponse;

	public function apiPostWithPayload(string $uri, array $payload): ApiResponse;

	public function apiPatchWithPayload(string $uri, array $payload): ApiResponse;
}
