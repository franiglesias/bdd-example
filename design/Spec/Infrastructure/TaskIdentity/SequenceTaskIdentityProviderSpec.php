<?php

namespace Spec\App\Infrastructure\TaskIdentity;

use App\Domain\TaskId;
use App\Domain\TaskRepository;
use App\Infrastructure\TaskIdentity\SequenceTaskIdentityProvider;
use PhpSpec\ObjectBehavior;

/**
 * @mixin SequenceTaskIdentityProvider
 */
class SequenceTaskIdentityProviderSpec extends ObjectBehavior
{
    public function it_provides_an_identity(TaskRepository $taskRepository)
    {
        $taskRepository->nextId()->willReturn(1);
        $this->beConstructedWith($taskRepository);

        $this->nextId()->shouldBeLike(new TaskId('1'));
    }
}
