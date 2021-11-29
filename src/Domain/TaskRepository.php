<?php
declare (strict_types=1);

namespace App\Domain;

interface TaskRepository
{

    public function store(Task $task): void;

    public function nextId(): int;

    public function findAll(): array;

    public function retrieve(TaskId $taskId): Task;
}
