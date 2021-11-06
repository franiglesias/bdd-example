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
        $payload = [
            'task' => $taskDescription
        ];
        $response = $this->apiPostWithPayload('/api/todo', $payload);

        Assert::eq($response->getStatusCode(), Response::HTTP_CREATED);
    }

    /**
     * @Then I see a list containing:
     */
    public function iSeeAListContaining(TableNode $table)
    {
        $payload = $this->obtainPayloadFromResponse();

        $expected = $table->getHash();

        Assert::eq($payload, $expected);
    }

    /**
     * @Given I have tasks in my list
     */
    public function iHaveTasksInMyList()
    {
        throw new PendingException();
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
