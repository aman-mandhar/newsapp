<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = $this->faker->randomElement(['draft','published','archived']);
        $publishedAt = $status === 'published' ? $this->faker->dateTimeBetween('-1 years', 'now') : null;
        $title = $this->faker->sentence(6);
        $slug = \Illuminate\Support\Str::slug($title) . '-' . uniqid();

        return [
            'title' => $title,
            'slug' => $slug,
            'content' => $this->faker->paragraphs(5, true),
            'image_path' => null,
            'status' => $status,
            'published_at' => $publishedAt,
            'meta_title' => $this->faker->sentence(6),
            'meta_description' => $this->faker->sentence(12),
            'meta_keywords' => implode(', ', $this->faker->words(5)),
            'views_count' => $this->faker->numberBetween(0, 2000),
            'likes_count' => $this->faker->numberBetween(0, 500),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
