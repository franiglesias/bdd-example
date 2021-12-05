<?php

declare(strict_types=1);

namespace Design\App\Contexts;


use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;

final class SymfonyApiClient implements ApiClient
{

	private KernelInterface $kernel;

	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
	}

	public function get(string $uri): ApiResponse
	{
		$request = Request::create(
			$uri,
			'GET'
		);

		$response = $this->kernel->handle($request);

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getContent()
		);
	}

	public function postWithPayload(string $uri, array $payload): ApiResponse
	{
		$request = Request::create(
			$uri,
			'POST',
			[],
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			json_encode($payload, JSON_THROW_ON_ERROR)
		);

		$response = $this->kernel->handle($request);

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getContent()
		);
	}

	public function patchWithPayload(string $uri, array $payload): ApiResponse
	{
		$request = Request::create(
			$uri,
			'PATCH',
			[],
			[],
			[],
			['CONTENT_TYPE' => 'application/json'],
			json_encode($payload, JSON_THROW_ON_ERROR)
		);

		$response = $this->kernel->handle($request);

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getContent()
		);
	}
}
