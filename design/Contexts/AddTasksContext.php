<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use Behat\Behat\Context\Context;
use Behat\Behat\Tester\Exception\PendingException;
use Behat\Gherkin\Node\TableNode;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

class AddTasksContext implements Context
{
    private KernelInterface $kernel;
    private Response $response;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
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
        $this->response = $this->apiGet('/api/todo');

        Assert::eq(Response::HTTP_OK, $this->response->getStatusCode());
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

        Assert::eq($payload, $expected);
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
        $payload = [
            'task' => ''
        ];
        $this->response = $this->apiPostWithPayload('/api/todo', $payload);
    }

    /**
     * @Then /^I get a bad request error$/
     */
    public function iGetABadRequestError(): void
    {
        Assert::eq( $this->response->getStatusCode(), 400);
    }


    /**
     * @Then /^I get an error message that says "([^"]*)"$/
     */
    public function iGetAnErrorMessageThatSays($expectedMessage): void
    {
        $payload = json_decode($this->response->getContent(), true, 512, JSON_THROW_ON_ERROR);

        $errorMessage = $payload['message'];
        Assert::eq($errorMessage, $expectedMessage);
    }

    /**
     * @Then /^The list contains:$/
     */
    public function theListContains(TableNode $table): void
    {
        $this->response = $this->apiGet('/api/todo');
        $payload = $this->obtainPayloadFromResponse();

        $expected = $table->getHash();

        Assert::eq($payload, $expected);
    }

    public function addTaskToList($description): void
    {
        $payload = [
            'task' => $description
        ];
        $response = $this->apiPostWithPayload('/api/todo', $payload);
        Assert::eq($response->getStatusCode(), Response::HTTP_CREATED);
    }

    private function apiGet(string $uri): Response
    {
        $request = Request::create(
            $uri,
            'GET'
        );

        return $this->kernel->handle($request);
    }

    private function apiPostWithPayload(string $uri, array $payload): Response
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

        return $this->kernel->handle($request);
    }
    private function obtainPayloadFromResponse()
    {
        return json_decode($this->response->getContent(), true, 512, JSON_THROW_ON_ERROR);
    }
}
