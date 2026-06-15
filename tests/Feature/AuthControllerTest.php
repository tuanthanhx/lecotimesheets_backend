<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_can_login_with_valid_credentials(): void
    {
        $user = $this->memberUser([
            'username' => 'worker',
            'password' => Hash::make('secret123'),
            'language' => 'en',
        ]);

        $response = $this->postJson('/api/auth/login', [
            'username' => 'worker',
            'password' => 'secret123',
        ]);

        $response->assertOk()
            ->assertJsonPath('token_type', 'bearer')
            ->assertJsonPath('username', $user->username)
            ->assertJsonPath('group', 2)
            ->assertJsonStructure(['access_token', 'expires_in']);
    }

    public function test_login_fails_with_invalid_password(): void
    {
        $this->memberUser([
            'username' => 'worker',
            'password' => Hash::make('secret123'),
        ]);

        $this->postJson('/api/auth/login', [
            'username' => 'worker',
            'password' => 'wrong-password',
        ])->assertUnauthorized()
            ->assertJsonPath('error', 'Unauthorized');
    }

    public function test_deactivated_user_cannot_login(): void
    {
        $this->memberUser([
            'username' => 'inactive-worker',
            'password' => Hash::make('secret123'),
            'status' => 2,
        ]);

        $this->postJson('/api/auth/login', [
            'username' => 'inactive-worker',
            'password' => 'secret123',
        ])->assertUnauthorized()
            ->assertJsonPath('error', 'Deactivated');
    }

    public function test_protected_routes_require_a_token(): void
    {
        $this->getJson('/api/users')->assertUnauthorized();
    }

    public function test_authenticated_user_can_fetch_me(): void
    {
        $user = $this->memberUser(['username' => 'worker']);

        $this->postJson('/api/auth/me', [], $this->authHeaders($user))
            ->assertOk()
            ->assertJsonPath('username', 'worker')
            ->assertJsonMissingPath('password');
    }
}
