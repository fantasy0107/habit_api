<?php

namespace App\Http\Controllers\Api;

use App\Constant\TaskConstant;
use App\Http\Controllers\Controller;
use App\Http\Resources\DeleteTaskResource;
use App\Http\Resources\ShowTaskResource;
use App\Http\Resources\StoreTaskResource;
use App\Http\Resources\UpdateTaskResource;
use App\Models\Task;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Auth;

class TaskController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return ShowTaskResource::collection($user->tasks);
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'string',
            'description' => 'string',
            'status' => Rule::in(
                TaskConstant::TASK_STATUS_DEFAULT,
                TaskConstant::TASK_STATUS_DELÍETE,
                TaskConstant::TASK_STATUS_PUBLISH
            ),
            'order' => 'number',
        ]);

        $user = Auth::user();

        $inputData = $request->all();
        $inputData['user_id'] = $user->id;
        $inputData['status'] = TaskConstant::TASK_STATUS_DEFAULT;
        $inputData['order'] = TaskConstant::TASK_ORDER_DEFAULT;

        $task = new Task();
        $task->fill($inputData);
        $task->save();
       
        return new StoreTaskResource($task);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function show(Task $task)
    {
        return new ShowTaskResource($task);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function edit(Task $task)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Task $task)
    {
        $task->fill($request->all());
        $task->save();

        return new UpdateTaskResource($task);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Task  $task
     * @return \Illuminate\Http\Response
     */
    public function destroy(Task $task)
    {
        $task->status = TaskConstant::TASK_STATUS_DELÍETE;
        $task->delete();

        return new DeleteTaskResource(null);
    }
}
