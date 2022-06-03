<?php

namespace Tests\Feature\Controllers\Api;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginControllerTest extends TestCase
{
    public function test_register_for_email()
    {
        $name =  'test123' . time();
        $email = "test123" . time() . "@test.com";

        $data = [
            'name' =>  $name,
            'email' => $email,
            'password' => 'test123',
            'password_confirmation' => 'test123'
        ];

        $response = $this->postJson('/api/register', $data);

        $response->assertStatus(201)
            ->assertJson([
                'user' => [
                    'name' => $name,
                    'email' => $email,
                ]
            ]);
    }
}
