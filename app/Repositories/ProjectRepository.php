<?php

namespace App\Repositories;

use App\Models\Project;

class ProjectRepository
{
    protected $project;

    public function __construct(Project $project)
    {
        $this->$project = $project;
    }


    public function getByFilter($filter)
    {
        $query = $this->project->newQuery();

        return $query->get();
    }

    public function save($data)
    {
        $post = new Project();
        if (isset($data['id'])) {
            $post = Project::findOrFail($data['id']);
        }

        $post->fill($data['project']);
        $post->save();

        return $post;
    }
}
