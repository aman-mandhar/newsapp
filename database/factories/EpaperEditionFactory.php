<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EpaperEdition>
 */
class EpaperEditionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'edition_name' => $this->faker->randomElement(['Ludhiana', 'Delhi', 'Mumbai', 'Chandigarh']),
            'issue_date' => $this->faker->dateTimeBetween('-30 days', 'now'),
            'status' => 'draft',
            'pdf_path' => 'epaper/editions/1/source.pdf',
            'total_pages' => $this->faker->numberBetween(8, 32),
            'generated_at' => null,
        ];
    }

    /**
     * Indicate that the edition is published.
     */
    public function published(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 'published',
            'generated_at' => now(),
        ]);
    }
}
