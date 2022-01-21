<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use App\Models\HabitWeeklyDay;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\Rule;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = Auth::user();

        return response()->json([
            'habits' =>  HabitResource::collection($user->habits)
        ], 200);
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
            'title' => ['required', 'string'],
            'description' => ['string'],
            'start_date' => ['string', 'date'],
            'end_date' => ['string', 'date'],
            'completion' => ['numeric'],
            'repeat_type' => [Rule::in(['daily', 'weekly'])],
            'repeat_weekly_days' => ['required_if:repeat_type,weekly']
        ]);

        $user = auth()->user();

        $habit = new Habit;
        $habit->user_id = $user->id;
        $habit->title = $request->title;
        $habit->description =  $request->description;
        $habit->start_date = $request->start_date;
        $habit->end_date = $request->end_date;
        $habit->completion = $request->completion;
        $habit->repeat_type = $request->repeat_type;
        $habit->save();

        if ($request->repeat_type == 'weekly') {
            $newRecords = [];

            foreach ($request->repeat_weekly_days as $key => $day) {

                if (in_array($day, ['monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday'])) {
                    $newRecords[] = [
                        'habit_id' => $habit->id,
                        'day' => $day
                    ];
                }

                if (count($newRecords)) {
                    HabitWeeklyDay::insert($newRecords);
                }
            }
        }

        return response()->json([
            'habit' => new HabitResource($habit)
        ], 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Habit $habit)
    {
        $user = Auth::user();

        if ($user->id != $habit->user_id) {
            abort(400, '你不是創建的人無法觀看');
        }

        return response()->json([
            'habit' => new HabitResource($habit)
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habit $habit)
    {
        $request->validate([
            'title' => ['required', 'string'],
            'description' => ['string'],
            'start_date' => ['string', 'date'],
            'end_date' => ['string', 'date'],
            'completion' => ['number'],
            'repeat_type' => [Rule::in(['daily', 'weekly'])],
            'repeat_weekly_days' => ['required_if:repeat_type,weekly']
        ]);

        $user = auth()->user();
        if ($user->id != $habit->user_id) {
            abort(400, '你不是創建的人無法更新');
        }

        $inputs = $request->all();
        $needUpdates = [];
        foreach ($inputs as $key => $value) {
            if ($value && $value != $habit->{$key}) {
                $needUpdates[$key] = $value;
            }
        }

        if (count($needUpdates)) {
            $habit->update($request->only([
                'title',
                'description',
                'start_date',
                'end_date',
                'completion'
            ]));
        }


        return response()->json([
            'habit' => new HabitResource($habit)
        ], 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habit $habit)
    {
        $user = auth()->user();
        if ($user->id != $habit->user_id) {
            abort(400, '你不是創建的人無法刪除');
        }

        $habit->delete();

        return response()->json([], 204);
    }
}
