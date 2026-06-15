<?php

namespace Tests\Feature;

use App\Models\Job;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class JobControllerTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_user_can_create_update_show_and_delete_job(): void
    {
        $admin = $this->adminUser();
        $headers = $this->authHeaders($admin);

        $response = $this->postJson('/api/jobs', [
            'name' => 'Kitchen Renovation',
            'detail' => 'Install cabinets',
            'revenue' => 1200,
            'material_cost' => 300,
            'status' => 1,
        ], $headers);

        $response->assertCreated()
            ->assertJsonPath('message', 'Job created successfully')
            ->assertJsonPath('job.name', 'Kitchen Renovation');

        $jobId = $response->json('job.id');

        $this->putJson("/api/jobs/{$jobId}", [
            'name' => 'Updated Kitchen Renovation',
            'detail' => 'Install cabinets and benchtop',
            'revenue' => 1500,
            'material_cost' => 450,
            'status' => 1,
        ], $headers)
            ->assertOk()
            ->assertJsonPath('job.name', 'Updated Kitchen Renovation');

        $this->getJson("/api/jobs/{$jobId}", $headers)
            ->assertOk()
            ->assertJsonPath('name', 'Updated Kitchen Renovation')
            ->assertJsonPath('revenue', 1500);

        $this->deleteJson("/api/jobs/{$jobId}", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Job deleted successfully');
        $this->assertDatabaseMissing('jobs', ['id' => $jobId]);
    }

    public function test_job_revenue_and_material_cost_are_hidden_from_members(): void
    {
        $member = $this->memberUser();
        $job = Job::factory()->create([
            'revenue' => 2000,
            'material_cost' => 700,
        ]);

        $this->getJson("/api/jobs/{$job->id}", $this->authHeaders($member))
            ->assertOk()
            ->assertJsonMissingPath('revenue')
            ->assertJsonMissingPath('material_cost');
    }

    public function test_admin_can_activate_and_deactivate_job(): void
    {
        $admin = $this->adminUser();
        $job = Job::factory()->inactive()->create();
        $headers = $this->authHeaders($admin);

        $this->postJson("/api/jobs/{$job->id}/activate", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Job activated successfully');
        $this->assertDatabaseHas('jobs', ['id' => $job->id, 'status' => 1]);

        $this->postJson("/api/jobs/{$job->id}/deactivate", [], $headers)
            ->assertOk()
            ->assertJsonPath('message', 'Job deactivated successfully');
        $this->assertDatabaseHas('jobs', ['id' => $job->id, 'status' => 2]);
    }

    public function test_job_store_validates_required_name(): void
    {
        $admin = $this->adminUser();

        $this->postJson('/api/jobs', [
            'revenue' => 1200,
            'material_cost' => 300,
        ], $this->authHeaders($admin))
            ->assertUnprocessable()
            ->assertJsonValidationErrors('name');
    }
}
