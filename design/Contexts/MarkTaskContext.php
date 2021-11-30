<?php
declare (strict_types=1);

namespace Design\App\Contexts;

use Behat\Behat\Context\Context;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpKernel\KernelInterface;
use Webmozart\Assert\Assert;
use const true;

class MarkTaskContext implements Context
{
    private $kernel;

    public function __construct(KernelInterface $kernel)
    {
        $this->kernel = $kernel;
		if (file_exists(__DIR__ . '/../../repository.data')) {
			unlink(__DIR__ . '/../../repository.data');
		}
		$this->apiClient = new SymfonyApiClient($kernel);
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
		return $this->apiClient->apiPatchWithPayload($taskId, $payload);
	}
}
