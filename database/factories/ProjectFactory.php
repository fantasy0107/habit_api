<?php

namespace Database\Factories;

use App\Constant\TaskConstant;
use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class ProjectFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Project::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $user = User::find(45);

        return [
            'user_id' => $user->id,
            'title'   => $this->faker->title,
        ];
    }
}
