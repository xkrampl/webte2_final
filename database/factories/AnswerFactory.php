<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Answer>
 */
class AnswerFactory extends Factory
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
            'question_id' => \App\Models\Question::all()->random(1)->first()->id,
            'text' => $this->faker->sentence(),
            'is_correct' => $this->faker->boolean(),
        ];
    }
}
