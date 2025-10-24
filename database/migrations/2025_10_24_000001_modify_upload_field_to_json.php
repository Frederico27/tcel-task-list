<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Step 1: Add a temporary column to store the JSON data
        Schema::table('pending_task', function (Blueprint $table) {
            $table->json('upload_temp')->nullable()->after('upload');
        });

        // Step 2: Migrate existing data to the temporary column
        DB::table('pending_task')->orderBy('id_pending_task')->chunk(100, function ($tasks) {
            foreach ($tasks as $task) {
                $uploadValue = null;

                if (!empty($task->upload)) {
                    // Check if it's already JSON (shouldn't be, but just in case)
                    $decoded = json_decode($task->upload, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
                        $uploadValue = json_encode($decoded);
                    } else {
                        // Convert single file path to array
                        $uploadValue = json_encode([$task->upload]);
                    }
                } else {
                    // Empty or null, set to empty array
                    $uploadValue = json_encode([]);
                }

                DB::table('pending_task')
                    ->where('id_pending_task', $task->id_pending_task)
                    ->update(['upload_temp' => $uploadValue]);
            }
        });

        // Step 3: Drop the old column
        Schema::table('pending_task', function (Blueprint $table) {
            $table->dropColumn('upload');
        });

        // Step 4: Rename temporary column to upload
        Schema::table('pending_task', function (Blueprint $table) {
            $table->renameColumn('upload_temp', 'upload');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Add temporary column
        Schema::table('pending_task', function (Blueprint $table) {
            $table->string('upload_temp')->nullable()->after('upload');
        });

        // Convert JSON arrays back to single strings (take first element)
        DB::table('pending_task')->orderBy('id_pending_task')->chunk(100, function ($tasks) {
            foreach ($tasks as $task) {
                $uploadValue = '';

                if (!empty($task->upload)) {
                    $decoded = json_decode($task->upload, true);
                    if (json_last_error() === JSON_ERROR_NONE && is_array($decoded) && count($decoded) > 0) {
                        // Take the first file if multiple files exist
                        $uploadValue = $decoded[0];
                    }
                }

                DB::table('pending_task')
                    ->where('id_pending_task', $task->id_pending_task)
                    ->update(['upload_temp' => $uploadValue]);
            }
        });

        // Drop JSON column
        Schema::table('pending_task', function (Blueprint $table) {
            $table->dropColumn('upload');
        });

        // Rename back
        Schema::table('pending_task', function (Blueprint $table) {
            $table->renameColumn('upload_temp', 'upload');
        });
    }
};
