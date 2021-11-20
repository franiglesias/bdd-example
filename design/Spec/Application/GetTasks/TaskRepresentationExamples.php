<?php
declare (strict_types=1);

namespace Spec\App\Application\GetTasks;

class TaskRepresentationExamples
{

    public static function arrayFromData(string $id, string $description): array
    {
        return [
            'id' => $id,
            'description' => $description,
            'done' => 'no'
        ];
    }

    public static function completed(): array
    {
        return [
            'id' => '1',
            'description' => 'Task Description',
            'done' => 'yes'
        ];
    }
}
