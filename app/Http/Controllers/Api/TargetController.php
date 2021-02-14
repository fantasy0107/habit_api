<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TargetResource;
use App\Models\Target;
use Illuminate\Http\Request;
use Auth;

class TargetController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        $targets = $user->targets;

        $response = [
            'targets' => $targets->sortByDesc('updated_at')->pluck('id'),
        ];

        if ($user->targets->count()) {
            $response['db']['target'] = TargetResource::collection($targets->keyBy('id'));
        }

        return $this->ok($response);
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
            'name' => 'required|string'
        ]);

        $user = Auth::user();

        $target = new Target;
        $target->user_id = $user->id;
        $target->name = $request->input('name', '預設');
        $target->save();

        return $this->created([
            'target' => new TargetResource($target)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Target $target)
    {
        $request->validate([
            'step' => 'number'
        ]);
        $user = Auth::user();

        if ($target->user_id != $user->id) {
            abort(400, '不是你的');
        }

        $needUpdate = false;

        if ($request->step) {
            $target->step = $request->step;

            $needUpdate = true;
        }

        if ($request->name) {
            $target->name = $request->name;

            $needUpdate = true;
        }

        if ($needUpdate) {
            $target->save();
        }

        return $this->ok([
            'target' => $target
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
