<?php

declare(strict_types=1);

namespace Design\App\Contexts;

interface ApiClient
{

	public function get(string $uri): ApiResponse;

	public function postWithPayload(string $uri, array $payload): ApiResponse;

	public function patchWithPayload(string $uri, array $payload): ApiResponse;
}
