<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => \App\Models\User::all()->random(1)->first()->id,
            'subject_id' => \App\Models\Subject::all()->random(1)->first()->id,
            'description' => $this->faker->sentence(),
            'type' => $type = $this->faker->randomElement(['answers', 'opened', 'archived']),
            'is_active' => $this->faker->boolean,
            'archive_note' => $type === 'archived' ? $this->faker->sentence() : null,
            'archived_at' => $type === 'archived' ? $this->faker->dateTime() : null
        ];
    }
}
