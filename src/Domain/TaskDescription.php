<?php
declare (strict_types=1);

namespace App\Domain;

class TaskDescription
{

    private string $description;

    public function __construct(string $description)
    {
        $this->description = $description;
    }

    public function toString(): string
    {
        return $this->description;
    }
}
