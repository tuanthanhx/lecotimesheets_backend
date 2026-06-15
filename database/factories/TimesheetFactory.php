<?php

namespace Database\Factories;

use App\Models\Job;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Timesheet>
 */
class TimesheetFactory extends Factory
{
    public function definition(): array
    {
        return [
            'user_id' => User::factory(),
            'job_id' => Job::factory(),
            'payroll_id' => null,
            'status' => 1,
            'hourly_rate' => 30.00,
            'date' => fake()->date(),
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'break' => false,
            'time_worked' => 8.00,
            'amount' => 240.00,
            'note' => fake()->sentence(),
        ];
    }

    public function approved(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 2,
        ]);
    }

    public function paid(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 3,
        ]);
    }
}
