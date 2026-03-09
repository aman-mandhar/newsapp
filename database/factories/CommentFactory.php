<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Comment>
 */
class CommentFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'comment_text' => $this->faker->sentences(3, true),
            'status' => $this->faker->randomElement(['pending','approved','rejected']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
