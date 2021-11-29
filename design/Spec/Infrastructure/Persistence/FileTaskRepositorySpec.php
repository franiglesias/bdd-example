<?php

namespace Spec\App\Infrastructure\Persistence;

use App\Domain\Task;
use App\Domain\TaskId;
use App\Infrastructure\Persistence\FileTaskRepository;
use App\Lib\FileStorageEngine;
use org\bovigo\vfs\vfsStream;
use PhpSpec\ObjectBehavior;
use Spec\App\Domain\TaskExamples;

/**
 * @mixin FileTaskRepository
 */
class FileTaskRepositorySpec extends ObjectBehavior
{
	private const TASK_ID                  = '1';
	private const TASK_DESCRIPTION         = 'Write a test that fails.';
	private const ANOTHER_TASK_ID          = '2';
	private const ANOTHER_TASK_DESCRIPTION = 'Write code to make test pass';

	public function let(): void
	{
		vfsStream::setup('root', null, ['storage.data']);
		$storageFile = vfsStream::url('root/storage.data');
		$fileEngine  = new FileStorageEngine($storageFile);

		$this->beConstructedWith($fileEngine);
	}

	public function it_is_initializable(): void
	{
		$this->shouldHaveType(FileTaskRepository::class);
	}

	public function it_stores_tasks(): void
	{
		$task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);

		$this->store($task);
		$this->nextId()->shouldBe(2);
	}

	public function it_retrieves_all_tasks(): void
	{
		$task        = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);
		$anotherTask = TaskExamples::withData(self::ANOTHER_TASK_ID, self::ANOTHER_TASK_DESCRIPTION);

		$this->store($task);
		$this->store($anotherTask);
		$this->findAll()->shouldBeLike(['1' => $task, '2' => $anotherTask]);
	}

	public function it_should_retrieve_existing_task_by_id(): void
	{
		$task = TaskExamples::withData(self::TASK_ID, self::TASK_DESCRIPTION);
		$anotherTask = TaskExamples::withData(self::ANOTHER_TASK_ID, self::ANOTHER_TASK_DESCRIPTION);

		$this->store($task);
		$this->store($anotherTask);
		$this->retrieve(new TaskId(self::TASK_ID))->shouldBeLike($task);
	}
}
