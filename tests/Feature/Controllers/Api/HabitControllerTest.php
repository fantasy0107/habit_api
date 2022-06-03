<?php

namespace Tests\Feature\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Habit;
use App\Models\User;

class HabitControllerTest extends TestCase
{
    use WithFaker;

    public function test_index()
    {
        $habit = Habit::factory()->create();

        $this->withHeaders([
            'Authorization' =>  $habit->user->bearerToken
        ])->get('api/habits')->assertStatus(200)->assertSeeText([
            'habits'
        ]);
    }

    public function test_store()
    {
        $name = $this->faker->word();
        $paragraph = $this->faker->paragraph();
        $user = User::first();
        $startDate = date('Y-m-d');

        $this->withHeaders([
            'Authorization' =>  $user->bearerToken
        ])->post('api/habits', [
            'title' => $name,
            'description' => $paragraph,
            'start_date' => $startDate,
            'completion' => 0,
            'repeat_type' => 'daily',
        ])->assertStatus(201)->assertJsonFragment([
            'user_id' =>  $user->id,
            'title' => $name,
            'start_date' => $startDate,
            'description' => $paragraph,
            'repeat_type' => 'daily',
        ]);
    }

    public function test_show()
    {
        $habit = Habit::factory()->create();

        $this->withHeaders([
            'Authorization' =>  $habit->user->bearerToken
        ])->get('api/habits/' . $habit->id)->assertStatus(200)->assertJsonFragment([
            'user_id' =>  $habit->user->id,
            'title' => $habit->title,
            'description' => $habit->description,
            'start_date' => $habit->start_date->toDateString(),
            'repeat_type' => $habit->repeat_type,
        ]);
    }

    public function test_update()
    {
        $habit = Habit::factory()->create();

        $title = $this->faker->word();
        $paragraph = $this->faker->paragraph();

        $this->withHeaders([
            'Authorization' =>  $habit->user->bearerToken
        ])->patch('api/habits/' . $habit->id, [
            'title' => $title,
            'description' => $paragraph
        ])->assertStatus(200)->assertJsonFragment([
            'title' => $title,
            'description' => $paragraph
        ]);
    }

    public function test_destroy()
    {
        $habit = Habit::factory()->create();

        $this->withHeaders([
            'Authorization' =>  $habit->user->bearerToken
        ])->delete('api/habits/' . $habit->id)->assertStatus(204);
    }
}
