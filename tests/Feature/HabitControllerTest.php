<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\Habit;

class HabitControllerTest extends TestCase
{
    use WithFaker;

    private $bearerToken = 'Bearer eyJpdiI6Ii9jRk9YeWw1K0VXakRSSlRBMTBtbEE9PSIsInZhbHVlIjoieUtIaldQbTBjc3ZWNG44UnJLSkxFUT09IiwibWFjIjoiNmIyYWQ2OTJkNGI0OWEwNmEwNWJkOGVmNDQ5ZTdjNGM5NWQwNzA0YTc0ZjliYzNlNmY0ZmU3Y2JhOTU2YTMxYiJ9';

    public function test_index()
    {
        $habit = Habit::factory()->create();
        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->get('api/habits')->assertStatus(200)->assertSeeText($habit->name);
    }


    public function test_store()
    {
        $name = $this->faker->word();
        $paragraph = $this->faker->paragraph();

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->post('api/habits', [
            'name' => $name,
            'content' => $paragraph
        ])->assertStatus(201)->assertSeeText($name);
    }
    public function test_show()
    {
        $habit = Habit::factory()->create();

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->get('api/habits/' . $habit->id)->assertStatus(200)->assertSeeText($habit->id);
    }
    public function test_update()
    {
        $habit = Habit::factory()->create();

        $name = $this->faker->word();

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->patch('api/habits/' . $habit->id, [
            'name' => $name
        ])->assertStatus(200)->assertSeeText($name);
    }
    public function test_destroy()
    {
        $habit = Habit::factory()->create();

        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->delete('api/habits/' . $habit->id)->assertStatus(200);
    }
    public function test_getMyHabits()
    {
        $this->withHeaders([
            'Authorization' =>  $this->bearerToken
        ])->get('/api/me/habits/')->assertStatus(200);
    }
}
