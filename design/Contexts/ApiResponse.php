<?php

declare(strict_types=1);

namespace Design\App\Contexts;


final class ApiResponse
{

	private int $statusCode;
	private array $payload;

	public function __construct(int $statusCode, string $body)
	{
		$this->statusCode = $statusCode;
		$this->payload    = json_decode($body, true, 512, JSON_THROW_ON_ERROR);
	}

	public function statusCode(): int
	{
		return $this->statusCode;
	}

	public function payload(): array
	{
		return $this->payload;
	}
}
