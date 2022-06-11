<?php

namespace Tests\Feature\Auth\Token;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class GenerateUserTokenTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_generate_token()
    {
        $user = User::factory()->create();

        $response = $this->postJson('/api/v1/users/token', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'token'
            ]);
    }

    public function test_user_login_invalid()
    {
        $response = $this->postJson('/api/v1/users/token', [
            'email' => 'dummy@gmail.com',
            'password' => 'password',
        ]);

        $response->assertStatus(422);
    }
}
