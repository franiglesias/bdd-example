<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;

class MarkTaskContext implements Context
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
		if (file_exists(__DIR__ . '/../../repository.data')) {
			unlink(__DIR__ . '/../../repository.data');
		}
    }

    /**
     * @When /^I mark task (\d+) as completed$/
     */
    public function iMarkTaskAsCompleted(string $taskId): void
    {
        $request = Request::create(
            '/api/todo/'.$taskId,
            'PATCH',
            [],
            [],
            [],
            ['CONTENT_TYPE' => 'application/json'],
            json_encode(['done' => true], JSON_THROW_ON_ERROR)
        );

        $response = $this->kernel->handle($request);

        Assert::eq(200, $response->getStatusCode());
    }
}
