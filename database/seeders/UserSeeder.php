<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
            'name' => 'Alice Johnson',
            'username' => 'alicej',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 25.00,
            'dob' => '1985-08-25',
            'address' => '1234 Maple Street',
            'phone' => '555-1234',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Bob Smith',
            'username' => 'bobsmith',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);
    }
}
