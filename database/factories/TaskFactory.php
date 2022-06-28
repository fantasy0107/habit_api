<?php

namespace Database\Factories;

use App\Constant\TaskConstant;
use App\Models\Task;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class TaskFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Task::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::find(45);

        $status = [
            TaskConstant::TASK_STATUS_DEFAULT,
            TaskConstant::TASK_STATUS_DELÍETE, 
            TaskConstant::TASK_STATUS_PUBLISH
        ];

        return [
           'user_id' => $user->id,
           'title' => $this->faker->title,
           'description' => $this->faker->paragraph(),
           'status' => Arr::random($status)
        ];
    }
}
