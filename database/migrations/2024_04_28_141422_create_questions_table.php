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
        Schema::create('questions', function (Blueprint $table) {
            $table->uuid('id')->primary();

            // Relations
            $table->foreignIdFor(\App\Models\User::class);
            $table->foreignIdFor(\App\Models\Subject::class);

            $table->string('description');
            $table->enum('type', ['answers', 'opened', 'archived']);

            $table->boolean('is_active')->default(true);

            $table->string('archive_note')->nullable();
            $table->dateTime('archived_at')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('questions');
    }
};
