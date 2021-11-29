<?php
declare (strict_types = 1);

namespace App\Infrastructure\Persistence;

use App\Domain\Task;
use App\Domain\TaskId;
use App\Domain\TaskRepository;
use App\Lib\FileStorageEngine;

final class FileTaskRepository implements TaskRepository
{
	private FileStorageEngine $fileStorageEngine;

	public function __construct(FileStorageEngine $fileStorageEngine)
	{
		$this->fileStorageEngine = $fileStorageEngine;
	}

	public function store(Task $task): void
	{
		$tasks = $this->findAll();
		$tasks[$task->id()->toString()] = $task;
		$this->fileStorageEngine->persistObjects($tasks);
	}

	public function nextId(): int
	{
		return count($this->findAll()) + 1;
	}

	public function findAll(): array
	{
		return $this->fileStorageEngine->loadObjects();
	}

	public function retrieve(TaskId $taskId): Task
	{
		$tasks = $this->findAll();

		return $tasks[$taskId->toString()];
	}
}
