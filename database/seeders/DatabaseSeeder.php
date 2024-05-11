<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Subject;
use App\Models\User;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name'     => 'Admin',
            'email'    => 'admin@example.com',
            'is_admin' => 1
        ]);

        User::factory()->create([
            'name'  => 'Tester',
            'email' => 'test@example.com',
        ]);

        Subject::factory()->count(10)->create();
        Question::factory()->count(20)->create();
        Answer::factory()->count(35)->create();
    }
}
