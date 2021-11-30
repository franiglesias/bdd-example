<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use Behat\Behat\Context\Context;
use Behat\Gherkin\Node\TableNode;
use PHPUnit\Framework\Assert as PHPUnitAssert;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

class AddTasksContext implements Context
{
	private KernelInterface $kernel;
	private ApiResponse $apiResponse;

	public function __construct(KernelInterface $kernel)
	{
		$this->kernel = $kernel;
		if (file_exists(__DIR__ . '/../../repository.data')) {
			unlink(__DIR__ . '/../../repository.data');
		}
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

	private function apiPostWithPayload(string $uri, array $payload): ApiResponse
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

	private function obtainPayloadFromResponse()
	{
		return $this->apiResponse->payload();
	}
}
