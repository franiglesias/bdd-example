<?php

declare(strict_types=1);

namespace Design\App\Contexts;


final class ApiResponse
{

	private int $statusCode;
	private array $payload;

	public function __construct(int $statusCode, array $payload)
	{
		$this->statusCode = $statusCode;
		$this->payload    = $payload;
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
