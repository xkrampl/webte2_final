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
        Schema::create('answer_archive', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(\App\Models\Answer::class);
            $table->foreignIdFor(\App\Models\Archive::class);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('answer_archive');
    }
};
