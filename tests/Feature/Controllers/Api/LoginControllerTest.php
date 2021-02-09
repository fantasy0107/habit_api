<?php

namespace Tests\Feature\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Faker;

class LoginControllerTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_example()
    {
        $response = $this->get('/');

        $response->assertStatus(200);
    }

    public function test_logIn()
    {
        $this->postJson('api/login', [
            'email' => 'test@gamil.com            ',
            'password' => 123123
        ])->assertStatus(200)->assertJsonStructure([
            'user' => [
                'id',
                'name',
                'email'
            ]
        ]);
    }

    public function test_register()
    {
        $faker = Faker\Factory::create();

        $this->json('post', '/api/register', [
            'name' =>  $faker->name(),
            'email' => 'test+' . time() . '@gamil.com',
            'password' => '123',
            'password_confirmation' => '123'
        ])->assertStatus(201);
    }
}
