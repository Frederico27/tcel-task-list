<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('pending_task', function (Blueprint $table) {
            $table->id('id_pending_task');
            $table->unsignedBigInteger('id_documents');
            $table->date('periode_date');
            $table->string('upload', 255);
            $table->enum('status', [
                'null',
                'waiting',
                'approved',
                'rejected'
            ])->default('null');
            $table->string('approved_by')->nullable();
            $table->timestamps();

            $table->foreign('id_documents')
                ->references('id_documents')->on('documents')
                ->onDelete('cascade')->onUpdate('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pending_task');
    }
};
