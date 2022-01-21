<?php

namespace Database\Factories;

use App\Models\Habit;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class HabitFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Habit::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::take(10)->get()->shuffle()->first();

        return [
            'user_id' => $user->id,
            'title' => $this->faker->word(),
            'description' => $this->faker->paragraph(),
            'start_date' => date('Y-m-d'),
            'completion' => 0,
            'repeat_type' => 'daily'
        ];
    }
}
