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

        User::create([
            'name' => 'Nancy Anderson 1',
            'username' => 'nancyan1',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 2',
            'username' => 'nancyan2',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 3',
            'username' => 'nancyan3',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 4',
            'username' => 'nancyan4',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 5',
            'username' => 'nancyan5',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 6',
            'username' => 'nancyan6',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 7',
            'username' => 'nancyan7',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 8',
            'username' => 'nancyan8',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 9',
            'username' => 'nancyan9',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 10',
            'username' => 'nancyan10',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 11',
            'username' => 'nancyan11',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 12',
            'username' => 'nancyan12',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 13',
            'username' => 'nancyan13',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 14',
            'username' => 'nancyan14',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 15',
            'username' => 'nancyan15',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 16',
            'username' => 'nancyan16',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 17',
            'username' => 'nancyan17',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 18',
            'username' => 'nancyan18',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 19',
            'username' => 'nancyan19',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 20',
            'username' => 'nancyan20',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 21',
            'username' => 'nancyan21',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 22',
            'username' => 'nancyan22',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 23',
            'username' => 'nancyan23',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 24',
            'username' => 'nancyan24',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 25',
            'username' => 'nancyan25',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 26',
            'username' => 'nancyan26',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 27',
            'username' => 'nancyan27',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 28',
            'username' => 'nancyan28',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 29',
            'username' => 'nancyan29',
            'password' => Hash::make('123456'),
            'group' => 2,
            'hourly_rate' => 30.00,
            'dob' => '1990-12-15',
            'address' => '5678 Oak Avenue',
            'phone' => '555-5678',
            'language' => 'en',
            'status' => 1,
        ]);

        User::create([
            'name' => 'Nancy Anderson 30',
            'username' => 'nancyan30',
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
