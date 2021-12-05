<?php

declare(strict_types=1);

namespace Design\App\Contexts;


use GuzzleHttp\Client;
use GuzzleHttp\Exception\GuzzleException;

final class GuzzleApiClient implements ApiClient
{
	private string $baseUrl;

	public function __construct(string $baseUrl)
	{
		$this->client  = new Client;
		$this->baseUrl = $baseUrl;
	}

	public function apiGet(string $uri): ApiResponse
	{
		$response = $this->client->get($this->baseUrl . $uri);

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getBody()->getContents()
		);
	}

	public function apiPostWithPayload(string $uri, array $payload): ApiResponse
	{
		try {
			$response = $this->client->post(
				$this->baseUrl . $uri,
				['json' => $payload]
			);
		} catch (GuzzleException $e) {
			$response = $e->getResponse();
		}

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getBody()->getContents()
		);
	}

	public function apiPatchWithPayload(string $uri, array $payload): ApiResponse
	{
		$response = $this->client->patch(
			$this->baseUrl . $uri,
			['json' => $payload]
		);

		return new ApiResponse(
			$response->getStatusCode(),
			$response->getBody()->getContents()
		);
	}
}
