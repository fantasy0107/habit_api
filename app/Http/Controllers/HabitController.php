<?php

namespace App\Http\Controllers;

use App\Http\Resources\HabitResource;
use App\Models\Habit;
use Illuminate\Http\Request;

class HabitController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $habitPaginator = Habit::latest()->paginate();
        $habitPaginator->getCollection()->transform(function ($value) {
            return new HabitResource($value);
        });
        return $habitPaginator;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $user = auth()->user();

        $habit = new Habit;
        $habit->user_id = $user->id;
        $habit->name = $request->input('name', '預設名稱');
        $habit->content = $request->input('content', '預設內容');
        $habit->save();

        return $this->created([
            'data' => new HabitResource($habit),
            'db' => [
                'habit' => [
                    $habit->id => new HabitResource($habit)
                ]
            ]
        ]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function show(Habit $habit)
    {
        return new HabitResource($habit);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Habit $habit)
    {
        $user = auth()->user();
        if ($habit->user_id !=  $user->id) {
            abort(400, '不具備刪除權限');
        }

        if ($request->name) {
            $habit->name = $request->name;
        }

        if ($request->content) {
            $habit->content = $request->content;
        }

        $habit->save();

        return $this->ok([
            'data' => new HabitResource($habit),
            'db' => [
                'habit' => [
                    $habit->id => new HabitResource($habit)
                ]
            ]
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Habit  $habit
     * @return \Illuminate\Http\Response
     */
    public function destroy(Habit $habit)
    {
        $user = auth()->user();
        if ($habit->user_id !=  $user->id) {
            abort(400, '不具備刪除權限');
        }

        $habit->delete();

        return $this->ok([
            'status' => 'ok'
        ]);
    }

    public function getMyHabits(Request $request)
    {
        $habits = auth()->user()->habits()->latest()->simplePaginate();


        $items =  $habits->getCollection();


        return $this->ok([
            'habit_ids' => $items->pluck('id'),
            'current_page' => $habits->currentPage(),
            'has_more_pages' => $habits->hasMorePages(),
            'db' => [
                'habit' => HabitResource::collection($items->keyBy('id'))
            ]
        ]);
    }
}
