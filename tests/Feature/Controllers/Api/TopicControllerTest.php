<?php

namespace Tests\Feature\Controllers\Api;

use App\Models\User;
use App\Models\UserToken;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class TopicControllerTest extends TestCase
{
    private $bearerToken = 'Bearer eyJpdiI6Ii9jRk9YeWw1K0VXakRSSlRBMTBtbEE9PSIsInZhbHVlIjoieUtIaldQbTBjc3ZWNG44UnJLSkxFUT09IiwibWFjIjoiNmIyYWQ2OTJkNGI0OWEwNmEwNWJkOGVmNDQ5ZTdjNGM5NWQwNzA0YTc0ZjliYzNlNmY0ZmU3Y2JhOTU2YTMxYiJ9';

    private $token = 'eyJpdiI6Ii9jRk9YeWw1K0VXakRSSlRBMTBtbEE9PSIsInZhbHVlIjoieUtIaldQbTBjc3ZWNG44UnJLSkxFUT09IiwibWFjIjoiNmIyYWQ2OTJkNGI0OWEwNmEwNWJkOGVmNDQ5ZTdjNGM5NWQwNzA0YTc0ZjliYzNlNmY0ZmU3Y2JhOTU2YTMxYiJ9';

    public function test_index()
    {
        $this->withHeaders([
            'Authorization' => $this->bearerToken
        ])->json('get', 'api/topics')->assertStatus(200);
    }

    public function test_store()
    {
        $faker = \Faker\Factory::create();

        $title = $faker->name;
        $this->withHeaders([
            'Authorization' => $this->bearerToken
        ])->json('post', 'api/topics', [
            'title' => $title,
            'content' => $faker->paragraph
        ])->assertStatus(201)->assertSeeText($title);
    }

    public function test_update()
    {
        $userToken = UserToken::where('value', $this->token)->first();
        $user = User::find($userToken->user_id);

        $target = $user->topics()->first();
        $faker = \Faker\Factory::create();

        $title = $faker->name;
        $this->withHeaders([
            'Authorization' => $this->bearerToken
        ])->json('patch', 'api/topics/' . $target->id, [
            'title' => $title
        ])->assertStatus(200)->assertSeeText($title);
    }
}
