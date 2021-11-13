<?php

namespace Spec\App\Domain;

use App\Domain\InvalidTaskDescription;
use App\Domain\TaskDescription;
use PhpSpec\ObjectBehavior;

/**
 * @mixin TaskDescription
 */
class TaskDescriptionSpec extends ObjectBehavior
{
    public function let(): void
    {
        $this->beConstructedWith('Some description');
    }

    public function it_is_initializable(): void
    {
        $this->shouldHaveType(TaskDescription::class);
    }

    public function it_should_not_be_empty()
    {
        $this->beConstructedWith('');
        $this->shouldThrow(InvalidTaskDescription::class)->duringInstantiation();
    }
}
