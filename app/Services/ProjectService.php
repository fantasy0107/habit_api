<?php

namespace App\Services;

use App\Repositories\ProjectRepository;

class ProjectService
{
    protected $projectRepository;

    public function __construct(ProjectRepository $projectRepository)
    {
        $this->$projectRepository = $projectRepository;
    }

    public function saveProject($input)
    {
        $projectData = [
            'project' => $input['project']
        ];

        if (isset($input['id'])) {
            $projectData['id'] = $input['id'];
        }

        $project = $this->projectRepository->save($projectData);

        return [
            'project' => $project
        ];
    }
}
