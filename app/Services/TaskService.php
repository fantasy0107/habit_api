<?php

namespace App\Services;

use App\Repositories\ProjectRepository;
use App\Repositories\TaskRepository;

class TaskService
{
    private $taskRepositroy;
    private $projectRepositroy;

    public function __construct(TaskRepository $taskRepository, ProjectRepository $projectRepository)
    {
        $this->taskRepository    = $taskRepository;
        $this->projectRepository = $projectRepository;
    }

    public function getById($id)
    {
        return $this->taskRepository->getById($id);
    }

    public function deleteById($id)
    {
        $task = $this->taskRepository->getById($id);

        $task->delete();
    }

    public function getProjectTasks($projectId)
    {
        $project = $this->projectRepository->getById($projectId);

        return $project->tasks;
    }
}