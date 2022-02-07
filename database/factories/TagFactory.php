<?php

namespace Database\Factories;

use App\Models\Habit;
use App\Models\Tag;
use Illuminate\Database\Eloquent\Factories\Factory;

class TagFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Tag::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $habit = Habit::take(10)->get()->shuffle()->first();

        return [
           'user_id' => $habit->user_id,
           'title' => $this->faker->word()
        ];
    }
}
