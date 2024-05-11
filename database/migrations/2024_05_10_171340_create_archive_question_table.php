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
        Schema::create('archive_question', function (Blueprint $table) {
            $table->id();
            $table->foreignUuid('question_id')->references('id')->on('questions');
            $table->foreignIdFor(\App\Models\Archive::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('archive_question');
    }
};
