<?php

namespace Tests\Feature;

use App\Models\Payroll;
use App\Models\Timesheet;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PayrollControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_payroll_creation_marks_approved_timesheets_as_paid(): void
    {
        $admin = $this->adminUser();
        $member = $this->memberUser();
        $approved = Timesheet::factory()->approved()->create(['user_id' => $member->id]);
        $unapproved = Timesheet::factory()->create(['user_id' => $member->id, 'status' => 1]);

        $response = $this->postJson('/api/payrolls', [
            'user_id' => $member->id,
            'amount' => 240,
            'time_worked' => 8,
        ], $this->authHeaders($admin));

        $response->assertCreated()
            ->assertJsonPath('message', 'Payroll created successfully')
            ->assertJsonPath('payroll.user_id', $member->id);

        $payrollId = $response->json('payroll.id');
        $this->assertDatabaseHas('timesheets', [
            'id' => $approved->id,
            'payroll_id' => $payrollId,
            'status' => 3,
        ]);
        $this->assertDatabaseHas('timesheets', [
            'id' => $unapproved->id,
            'payroll_id' => null,
            'status' => 1,
        ]);
    }

    public function test_member_only_lists_own_payrolls(): void
    {
        $member = $this->memberUser();
        $otherMember = $this->memberUser();
        $ownPayroll = Payroll::factory()->create(['user_id' => $member->id]);
        $otherPayroll = Payroll::factory()->create(['user_id' => $otherMember->id]);

        $this->getJson('/api/payrolls?limit=-1', $this->authHeaders($member))
            ->assertOk()
            ->assertJsonPath('total', 1)
            ->assertJsonFragment(['id' => $ownPayroll->id])
            ->assertJsonMissing(['id' => $otherPayroll->id]);
    }

    public function test_payroll_store_validates_required_fields(): void
    {
        $admin = $this->adminUser();

        $this->postJson('/api/payrolls', [], $this->authHeaders($admin))
            ->assertUnprocessable()
            ->assertJsonValidationErrors(['user_id', 'amount', 'time_worked']);
    }
}
