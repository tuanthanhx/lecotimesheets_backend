<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_member_user(): void
    {
        $admin = $this->adminUser();

        $response = $this->postJson('/api/users', [
            'username' => 'new-worker',
            'password' => 'secret123',
            'name' => 'New Worker',
            'hourly_rate' => 32.50,
            'language' => 'en',
            'status' => 1,
        ], $this->authHeaders($admin));

        $response->assertCreated()
            ->assertJsonPath('message', 'User created successfully')
            ->assertJsonPath('user.username', 'new-worker')
            ->assertJsonPath('user.group', 2);

        $user = User::where('username', 'new-worker')->firstOrFail();
        $this->assertTrue(Hash::check('secret123', $user->password));
    }

    public function test_user_creation_validates_unique_username(): void
    {
        $admin = $this->adminUser();
        $this->memberUser(['username' => 'existing-worker']);

        $this->postJson('/api/users', [
            'username' => 'existing-worker',
            'password' => 'secret123',
            'name' => 'Duplicate Worker',
            'hourly_rate' => 30,
        ], $this->authHeaders($admin))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('username');
    }

    public function test_authenticated_user_can_update_member_user(): void
    {
        $admin = $this->adminUser();
        $user = $this->memberUser(['username' => 'old-worker']);

        $this->putJson("/api/users/{$user->id}", [
            'username' => 'updated-worker',
            'password' => 'new-secret',
            'name' => 'Updated Worker',
            'hourly_rate' => 35,
            'language' => 'en',
            'status' => 1,
        ], $this->authHeaders($admin))
            ->assertOk()
            ->assertJsonPath('message', 'User updated successfully')
            ->assertJsonPath('user.username', 'updated-worker');

        $user->refresh();
        $this->assertTrue(Hash::check('new-secret', $user->password));
    }

    public function test_authenticated_user_can_activate_deactivate_and_delete_member_user(): void
    {
        $admin = $this->adminUser();
        $user = $this->memberUser(['status' => 1]);
        $headers = $this->authHeaders($admin);

        $this->postJson("/api/users/{$user->id}/deactivate", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'User deactivated successfully');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 2]);

        $this->postJson("/api/users/{$user->id}/activate", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'User activated successfully');
        $this->assertDatabaseHas('users', ['id' => $user->id, 'status' => 1]);

        $this->deleteJson("/api/users/{$user->id}", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'User deleted successfully');
        $this->assertDatabaseMissing('users', ['id' => $user->id]);
    }

    public function test_user_index_lists_members_but_not_admins(): void
    {
        $admin = $this->adminUser(['name' => 'Admin User']);
        $member = $this->memberUser(['name' => 'Member User']);

        $this->getJson('/api/users?limit=-1', $this->authHeaders($admin))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonFragment(['id' => $member->id, 'name' => 'Member User'])
            ->assertJsonMissing(['id' => $admin->id, 'name' => 'Admin User']);
    }
}
