<?php

namespace Database\Factories;

use App\Models\EpaperArticle;
use App\Models\EpaperPage;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EpaperRegion>
 */
class EpaperRegionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'page_id' => EpaperPage::factory(),
            'article_id' => null,
            'x' => $this->faker->randomFloat(6, 0, 0.8),
            'y' => $this->faker->randomFloat(6, 0, 0.8),
            'w' => $this->faker->randomFloat(6, 0.1, 0.3),
            'h' => $this->faker->randomFloat(6, 0.1, 0.3),
            'label' => $this->faker->optional()->word(),
            'type' => $this->faker->randomElement(['article', 'ad', 'notice']),
            'is_active' => true,
        ];
    }

    /**
     * Indicate that the region is attached to an article.
     */
    public function withArticle(): static
    {
        return $this->state(fn (array $attributes) => [
            'article_id' => EpaperArticle::factory(),
        ]);
    }
}
