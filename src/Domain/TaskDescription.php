<?php
declare (strict_types=1);

namespace App\Domain;

class TaskDescription
{

    private string $description;

    public function __construct(string $description)
    {
        if ($description === '') {
            throw new InvalidTaskDescription();
        }

        $this->description = $description;
    }

    public function toString(): string
    {
        return $this->description;
    }
}
