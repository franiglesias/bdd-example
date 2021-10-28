<?php

namespace Spec\App\Infrastructure\EntryPoint\Api;

use App\Infrastructure\EntryPoint\Api\AddTaskController;
use PhpSpec\ObjectBehavior;
use PhpSpec\Wrapper\Subject;
use PhpSpec\Wrapper\Subject\WrappedObject;
use Symfony\Component\HttpFoundation\Response;

/**
 * @mixin AddTaskController
 */
class GetTasksControllerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AddTaskController::class);
    }

    public function it_should_respond_with_OK(): void
    {
        $response = $this->__invoke();

        $response->getStatusCode()->shouldBe(200);
    }
}
