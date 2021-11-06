<?php
declare (strict_types=1);

namespace App\Domain;

class TaskId
{

    private string $id;

    public function __construct(string $id)
    {
        $this->id = $id;
    }

    public function toString(): string
    {
        return $this->id;
    }
}
