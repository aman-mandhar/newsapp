<?php

namespace Database\Factories;

use App\Models\EpaperEdition;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EpaperArticle>
 */
class EpaperArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(6);

        return [
            'edition_id' => EpaperEdition::factory(),
            'title' => $title,
            'body' => $this->faker->paragraphs(5, true),
            'section' => $this->faker->randomElement(['National', 'International', 'Sports', 'Business', 'Entertainment']),
            'slug' => Str::slug($title).'-'.uniqid(),
        ];
    }
}
