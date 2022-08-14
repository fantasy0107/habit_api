<?php

namespace App\Http\Controllers\Web;

use App\Constant\ProjectConstant;
use App\Http\Controllers\Controller;
use App\Models\Project;
use App\Models\Task;
use App\Services\TaskService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TaskController extends Controller
{
    private $taskService;

    public function __construct(TaskService $taskService)
    {
        $this->taskService = $taskService;
    }

    /**
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Contracts\View\View
     */
    public function index()
    {
        $user = auth()->user();

        return view('sections.task.main', [
            'projects' => $user->projects,
            'tasks'    => $user->tasks,
        ]);
    }

    public function getProjectTasks(Request $request, $project)
    {
        $user = auth()->user();


        $tasks = [];
        switch ($request->type) {
            case ProjectConstant::PROJECT_TYPE_DEFAULT:
                $project = $user->projects()->where('id', $project)->first();
                if ($project) {
                    $tasks = $project->tasks;
                }
                break;
            case ProjectConstant::PROJECT_TYPE_BOX:
                $project = $user->projects()->where('type', ProjectConstant::PROJECT_TYPE_BOX)->first();
                if ($project) {
                    $tasks = $this->taskService->getProjectTasks($project->id);
                }
                break;
            case ProjectConstant::PROJECT_TYPE_TODAY:
                $toDayStart = Carbon::today()->startOfDay();
                $toDayEnd   = Carbon::today()->endOfDay();

                $tasks = $user->tasks()->whereBetween('created_at', [$toDayStart, $toDayEnd])->get();
                break;
        }


        return view('sections.task.content', [
            'tasks' => $tasks
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int                      $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->taskService->deleteById($id);

        return $this->ok();
    }
}
