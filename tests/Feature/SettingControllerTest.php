<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class SettingControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_fetch_own_settings(): void
    {
        $user = $this->memberUser(['username' => 'settings-user']);

        $this->getJson('/api/settings', $this->authHeaders($user))
            ->assertOk()
            ->assertJsonPath('username', 'settings-user')
            ->assertJsonMissingPath('password');
    }

    public function test_authenticated_user_can_update_own_settings_and_password(): void
    {
        $user = $this->memberUser(['username' => 'settings-user']);

        $this->postJson('/api/settings', [
            'name' => 'Updated Settings User',
            'username' => 'updated-settings-user',
            'password' => 'new-secret',
            'dob' => '1990-01-01',
            'address' => '123 Test Street',
            'phone' => '021000000',
            'language' => 'en',
        ], $this->authHeaders($user))
            ->assertOk()
            ->assertJsonPath('message', 'User updated successfully');

        $user->refresh();
        $this->assertSame('updated-settings-user', $user->username);
        $this->assertTrue(Hash::check('new-secret', $user->password));
    }
}
