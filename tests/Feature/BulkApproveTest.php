<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;
use App\Models\PendingTask;
use App\Models\Documents;

class BulkApproveTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function bulk_approve_updates_tasks_and_returns_json()
    {
        // Create a document so FK constraints are satisfied
        $doc = Documents::create(['type_document' => 'Test Doc', 'pic' => '[]', 'approval' => '[]', 'creating_task' => '1']);

        // Create a couple of pending tasks
        $t1 = PendingTask::create(['id_documents' => $doc->id_documents, 'upload' => '', 'periode_date' => '2025-09-01', 'status' => 'waiting_approval']);
        $t2 = PendingTask::create(['id_documents' => $doc->id_documents, 'upload' => '', 'periode_date' => '2025-09-02', 'status' => 'waiting_approval']);

        $response = $this->postJson(route('admin.bulkApprove'), ['ids' => [$t1->id_pending_task, $t2->id_pending_task]]);

        $response->assertStatus(200)
            ->assertJson(['success' => true]);

        $this->assertDatabaseHas('pending_task', ['id_pending_task' => $t1->id_pending_task, 'status' => 'approved']);
        $this->assertDatabaseHas('pending_task', ['id_pending_task' => $t2->id_pending_task, 'status' => 'approved']);
    }
}
