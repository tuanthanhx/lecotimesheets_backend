<?php

namespace Tests\Feature;

use App\Models\Job;
use App\Models\Timesheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TimesheetControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_member_creates_timesheet_for_self_and_amount_is_calculated(): void
    {
        $member = $this->memberUser(['hourly_rate' => 40.00]);
        $job = Job::factory()->create();

        $response = $this->postJson('/api/timesheets', [
            'job_id' => $job->id,
            'date' => '2026-06-14',
            'start_time' => '09:00:00',
            'end_time' => '17:00:00',
            'break' => true,
            'note' => 'Worked full day',
        ], $this->authHeaders($member));

        $response->assertCreated()
            ->assertJsonPath('message', 'Timesheet created successfully')
            ->assertJsonPath('timesheet.user_id', $member->id)
            ->assertJsonPath('timesheet.status', 1)
            ->assertJsonPath('timesheet.time_worked', 7.5)
            ->assertJsonPath('timesheet.amount', 300);
    }

    public function test_admin_can_create_timesheet_for_selected_user_with_status(): void
    {
        $admin = $this->adminUser();
        $member = $this->memberUser(['hourly_rate' => 35.00]);
        $job = Job::factory()->create();

        $this->postJson('/api/timesheets', [
            'user_id' => $member->id,
            'job_id' => $job->id,
            'status' => 2,
            'date' => '2026-06-14',
            'start_time' => '08:00:00',
            'end_time' => '12:00:00',
            'break' => false,
        ], $this->authHeaders($admin))
            ->assertCreated()
            ->assertJsonPath('timesheet.user_id', $member->id)
            ->assertJsonPath('timesheet.status', 2)
            ->assertJsonPath('timesheet.time_worked', 4)
            ->assertJsonPath('timesheet.amount', 140);
    }

    public function test_member_can_only_list_own_timesheets(): void
    {
        $member = $this->memberUser();
        $otherMember = $this->memberUser();
        $ownTimesheet = Timesheet::factory()->create(['user_id' => $member->id]);
        $otherTimesheet = Timesheet::factory()->create(['user_id' => $otherMember->id]);

        $this->getJson('/api/timesheets?limit=-1', $this->authHeaders($member))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonFragment(['id' => $ownTimesheet->id])
            ->assertJsonMissing(['id' => $otherTimesheet->id]);
    }

    public function test_amount_endpoint_sums_total_unpaid_and_paid_amounts(): void
    {
        $admin = $this->adminUser();
        $member = $this->memberUser();
        Timesheet::factory()->create(['user_id' => $member->id, 'status' => 1, 'amount' => 100]);
        Timesheet::factory()->approved()->create(['user_id' => $member->id, 'amount' => 200]);
        Timesheet::factory()->paid()->create(['user_id' => $member->id, 'amount' => 300]);

        $this->getJson("/api/timesheets/amount?user={$member->id}", $this->authHeaders($admin))
            ->assertOk()
            ->assertJsonPath('totalAmount', 600)
            ->assertJsonPath('unpaidAmount', 300)
            ->assertJsonPath('paidAmount', 300);
    }

    public function test_admin_can_approve_unapprove_and_delete_timesheet(): void
    {
        $admin = $this->adminUser();
        $timesheet = Timesheet::factory()->create(['status' => 1]);
        $headers = $this->authHeaders($admin);

        $this->postJson("/api/timesheets/{$timesheet->id}/approve", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Timesheet approved successfully');
        $this->assertDatabaseHas('timesheets', ['id' => $timesheet->id, 'status' => 2]);

        $this->postJson("/api/timesheets/{$timesheet->id}/unapprove", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Timesheet unapproved successfully');
        $this->assertDatabaseHas('timesheets', ['id' => $timesheet->id, 'status' => 1]);

        $this->deleteJson("/api/timesheets/{$timesheet->id}", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Timesheet deleted successfully');
        $this->assertSoftDeleted('timesheets', ['id' => $timesheet->id]);
    }

    public function test_timesheet_store_validates_required_fields(): void
    {
        $member = $this->memberUser();

        $this->postJson('/api/timesheets', [], $this->authHeaders($member))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['job_id', 'date', 'start_time', 'end_time']);
    }
}
