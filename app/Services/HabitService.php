<?php

namespace App\Services;

use App\Models\Habit;
use App\Models\HabitWeeklyDay;

class HabitService
{
    public function createHabit($inputs = [])
    {
        $user = auth()->user();

        $habit = new Habit();
        $habit->user_id = $user->id;
        $habit->title = $inputs['title'];
        $habit->description =  $inputs['description'];
        $habit->start_date = $inputs['start_date'];
        $habit->end_date = array_key_exists('end_date', $inputs) ? $inputs['end_date'] : null;
        $habit->completion = $inputs['completion'];
        $habit->repeat_type = $inputs['repeat_type'];
        $habit->save();

        if ($inputs['repeat_type'] == 'weekly') {
            $newRecords = [];

            foreach ($inputs['repeat_weekly_days'] as $day) {

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

        return $habit;
    }
}
