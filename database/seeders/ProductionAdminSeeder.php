<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class ProductionAdminSeeder extends Seeder
{
    /**
     * Seed only the production administrator account.
     */
    public function run(): void
    {
        User::updateOrCreate(
            ['username' => 'admin'],
            [
                'name' => 'Administrator',
                'password' => Hash::make('ChangeThisAdminPassword123!'),
                'group' => 6,
                'hourly_rate' => 25.00,
                'dob' => '1985-01-01',
                'address' => null,
                'phone' => null,
                'language' => 'en',
                'status' => 1,
            ]
        );
    }
}
