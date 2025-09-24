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
        Schema::create('documents_period', function (Blueprint $table) {
            $table->id('id_docu_period');
            $table->unsignedBigInteger('id_documents');
            $table->enum('period_type', ['daily', 'weekly', 'yearly']);
            $table->json('period_value');
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
        Schema::dropIfExists('documents_period');
    }
};
