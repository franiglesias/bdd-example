<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use App\Lib\FileStorageEngine;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Webmozart\Assert\Assert;
use const true;

class MarkTaskContext implements Context
{
	private GuzzleApiClient $apiClient;

	public function __construct()
	{
		$this->apiClient = new GuzzleApiClient('http://bdd-webserver');
	}

	/**
	 * @BeforeScenario
	 */
	public function resetDatabase(BeforeScenarioScope $scope): void
	{
		$file = new FileStorageEngine(__DIR__ . '/../../var/repository.data');
		$file->reset();
	}

	/**
	 * @When /^I mark task (\d+) as completed$/
	 */
	public function iMarkTaskAsCompleted(string $taskId): void
	{
		$apiResponse = $this->apiPatchWithPayload($taskId, ['done' => true]);

		Assert::eq(200, $apiResponse->statusCode());
	}

	private function apiPatchWithPayload(string $taskId, array $payload): ApiResponse
	{
		return $this->apiClient->apiPatchWithPayload('/api/todo/' . $taskId, $payload);
	}
}
