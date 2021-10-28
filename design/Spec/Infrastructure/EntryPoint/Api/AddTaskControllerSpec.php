<?php

namespace Spec\App\Infrastructure\EntryPoint\Api;

use App\Infrastructure\EntryPoint\Api\AddTaskController;
use PhpSpec\ObjectBehavior;
use Prophecy\Argument;

/**
 * @mixin AddTaskController
 */
class AddTaskControllerSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(AddTaskController::class);
    }
}
