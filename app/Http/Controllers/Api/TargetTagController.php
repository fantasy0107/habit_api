<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Target;
use App\Models\TargetTag;
use Illuminate\Http\Request;
use Auth;

class TargetTagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
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
            'name' => 'required',
        ]);

        $target = Target::find($request->target_id);
        if (!$target) {
            abort(400, '找不到');
        }

        $user = Auth::user();

        $targetTag =  new TargetTag;
        $targetTag->user_id = $user->id;
        $targetTag->target_id = $request->target_id;
        $targetTag->name = $request->name;
        $targetTag->save();

        return $this->created([
            'id' => $targetTag->id,
            'target_tag' => $targetTag,
            'db' => [
                'target_tag' => [
                    $targetTag->id => $targetTag
                ]
            ]
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
    public function update(Request $request, $id)
    {
        //
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
