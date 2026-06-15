<?php

namespace Tests\Feature;

use App\Models\User;
use Database\Seeders\ProductionAdminSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class ProductionAdminSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_production_admin_seeder_creates_only_one_admin_user(): void
    {
        $this->seed(ProductionAdminSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'username' => 'admin',
            'name' => 'Administrator',
            'group' => 6,
            'status' => 1,
        ]);

        $admin = User::where('username', 'admin')->firstOrFail();
        $this->assertTrue(Hash::check('ChangeThisAdminPassword123!', $admin->password));
    }

    public function test_production_admin_seeder_updates_existing_admin_without_duplicates(): void
    {
        User::factory()->admin()->create([
            'username' => 'admin',
            'name' => 'Old Admin',
            'status' => 2,
        ]);

        $this->seed(ProductionAdminSeeder::class);

        $this->assertDatabaseCount('users', 1);
        $this->assertDatabaseHas('users', [
            'username' => 'admin',
            'name' => 'Administrator',
            'status' => 1,
        ]);
    }
}
