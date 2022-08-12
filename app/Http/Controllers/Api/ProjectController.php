<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\BaseResource;
use App\Http\Resources\IndexProjectResource;
use App\Http\Resources\ShowProjectResource;
use App\Http\Resources\StoreProjectResource;
use App\Http\Resources\UpdateProjectResource;
use App\Models\Project;
use App\Services\ProjectService;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    protected $projectService;

    public function __construct(ProjectService $projectService)
    {
        $this->projectService = $projectService;
    }

    /**
     * Display a listing of the resource.
     *
     */
    public function index()
    {
        $user = auth()->user();

        return new IndexProjectResource([
            'projects' => $user->projects
        ]);
    }

    /**
     *  Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return StoreProjectResource
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string'
        ]);

        $project = $this->projectService->saveProject([
            'project' => $request->all()
        ]);

        return new StoreProjectResource([
            'project' => $project
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param Project $project
     *
     * @return ShowProjectResource
     */
    public function show(Project $project)
    {
        return new ShowProjectResource([
            'project' => $project
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Models\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param Project $project
     *
     * @return UpdateProjectResource
     */
    public function update(Request $request, Project $project)
    {
        $request->validate([
            'title' => 'required|string',
        ]);

        $project = $this->projectService->saveProject([
            'id'      => $project->id,
            'project' => [
                'title' => $request->title
            ]
        ]);

        return new UpdateProjectResource([
            'project' => $project
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Models\Project $project
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $project->delete();

        return null;
    }
}
