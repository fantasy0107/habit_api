<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\HabitResource;
use App\Models\Habit;
use App\Models\HabitWeeklyDay;
use App\Models\Record;
use App\Services\HabitService;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

/**
 * 習慣相關
 */
class HabitController extends Controller
{
    protected $habitService;

    public function __construct(HabitService $habitService)
    {
        $this->habitService = $habitService;
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();

        return $this->ok([
            'habits' =>  HabitResource::collection($user->habits)
        ]);
    }

    /**
     * 新增習慣
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

        $habit = $this->habitService->createHabit($request->all());

        return $this->created([
            'habit' => new HabitResource($habit)
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Habit $habit)
    {
        $user = auth()->user();

        if ($user->id != $habit->user_id) {
            abort(400, '你不是創建的人無法觀看');
        }

        return $this->ok([
            'habit' => new HabitResource($habit)
        ]);
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


        return $this->ok([
            'habit' => new HabitResource($habit)
        ]);
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

        return response()->json(null, 204);
    }

    public function updateHabitRecords(Request $request, Habit $habit)
    {
        $user = auth()->user();
        if ($user->id != $habit->user_id) {
            abort(400, '你不是創建的人無法刪除');
        }

        $record = Record::where('habit_id', $habit->id)->where('user_id', $user->id)->where('finish_date', $request->finish_date)->first();
        if (!$record) {
            $record = new Record;
            $record->user_id = $user->id;
            $record->habit_id = $habit->id;
        }
        $record->done = (int)$request->done;
        $record->finish_date = $request->finish_date;
        $record->save();

        return $this->ok([
            'record' => $record
        ]);
    }
}
