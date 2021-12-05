<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use App\Lib\FileStorageEngine;
use Behat\Behat\Context\Context;
use Behat\Behat\Hook\Scope\BeforeScenarioScope;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Symfony\Component\HttpFoundation\Response;
use Webmozart\Assert\Assert;

class AddTasksContext implements Context
{
	private ApiResponse $apiResponse;
	private ApiClient $apiClient;

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
	 * @Given I have no tasks in my list
	 */
	public function iHaveNoTasksInMyList(): void
	{
		/** Empty for the moment */
	}

	/**
	 * @When I get my tasks
	 */
	public function iGetMyTasks(): void
	{
		$this->apiResponse = $this->apiGet('/api/todo');

		Assert::eq(Response::HTTP_OK, $this->apiResponse->statusCode());
	}

	/**
	 * @Then I see an empty list
	 */
	public function iSeeAnEmptyList(): void
	{
		$payload = $this->obtainPayloadFromResponse();

		Assert::isEmpty($payload);
	}

	/**
	 * @Given I add a task with description :taskDescription
	 */
	public function iAddATaskWithDescription(string $taskDescription): void
	{
		$this->addTaskToList($taskDescription);
	}

	/**
	 * @Then I see a list containing:
	 */
	public function iSeeAListContaining(TableNode $table): void
	{
		$payload = $this->obtainPayloadFromResponse();

		$expected = $table->getHash();

		PHPUnitAssert::assertEqualsCanonicalizing($expected, $payload);
	}

	/**
	 * @Given /^I have this tasks in my list$/
	 */
	public function iHaveThisTasksInMyList(TableNode $table): void
	{
		$rows = $table->getColumnsHash();
		foreach ($rows as $row) {
			$this->addTaskToList($row['description']);
		}
	}


	/**
	 * @When /^I add a task with empty description$/
	 */
	public function iAddATaskWithEmptyDescription(): void
	{
		$payload           = [
			'task' => '',
		];
		$this->apiResponse = $this->apiPostWithPayload('/api/todo', $payload);
	}

	/**
	 * @Then /^I get a bad request error$/
	 */
	public function iGetABadRequestError(): void
	{
		Assert::eq($this->apiResponse->statusCode(), 400);
	}


	/**
	 * @Then /^I get an error message that says "([^"]*)"$/
	 */
	public function iGetAnErrorMessageThatSays($expectedMessage): void
	{
		$payload = $this->apiResponse->payload();

		$errorMessage = $payload['message'];
		Assert::eq($errorMessage, $expectedMessage);
	}

	/**
	 * @Then /^The list contains:$/
	 */
	public function theListContains(TableNode $table): void
	{
		$this->apiResponse = $this->apiGet('/api/todo');
		$payload           = $this->obtainPayloadFromResponse();

		$expected = $table->getHash();

		PHPUnitAssert::assertEqualsCanonicalizing($expected, $payload);
	}

	public function addTaskToList($description): void
	{
		$payload     = [
			'task' => $description,
		];
		$apiResponse = $this->apiPostWithPayload('/api/todo', $payload);

		Assert::eq($apiResponse->statusCode(), Response::HTTP_CREATED);
	}

	private function apiGet(string $uri): ApiResponse
	{
		return $this->apiClient->apiGet($uri);
	}

	private function apiPostWithPayload(string $uri, array $payload): ApiResponse
	{
		return $this->apiClient->apiPostWithPayload($uri, $payload);
	}

	private function obtainPayloadFromResponse()
	{
		return $this->apiResponse->payload();
	}
}
