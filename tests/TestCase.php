<?php

namespace Tests;

use App\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    protected function authHeaders(?User $user = null): array
    {
        $user ??= User::factory()->create();

        return [
            'Authorization' => 'Bearer ' . auth('api')->login($user),
        ];
    }

    protected function adminUser(array $attributes = []): User
    {
        return User::factory()->admin()->create($attributes);
    }

    protected function memberUser(array $attributes = []): User
    {
        return User::factory()->create($attributes);
    }
}
