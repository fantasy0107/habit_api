<?php
namespace App\Repositories;

use App\Models\Task;

class TaskRepository
{
    private $task;

    public function __construct(Task $task)
    {
        $this->task = $task;
    }

    public function getById($id)
    {
        return Task::find($id);
    }

}