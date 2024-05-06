<?php

namespace Database\Seeders;

use App\Models\Timesheet;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TimesheetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Timesheet::create([
            'user_id' => 10,
            'job_id' => 10,
            'note' => '',
            'date' => '2024-05-06',
            'start_time' => '08:00',
            'end_time' => '17:00',
            'break' => true,
            'status' => 1,
        ]);
        Timesheet::create([
            'user_id' => 10,
            'job_id' => 11,
            'note' => '',
            'date' => '2024-05-06',
            'start_time' => '08:00',
            'end_time' => '17:00',
            'break' => true,
            'status' => 1,
        ]);
        Timesheet::create([
            'user_id' => 11,
            'job_id' => 12,
            'note' => '',
            'date' => '2024-05-06',
            'start_time' => '08:00',
            'end_time' => '17:00',
            'break' => true,
            'status' => 1,
        ]);
    }
}
