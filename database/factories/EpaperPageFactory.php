<?php

namespace Database\Factories;

use App\Models\EpaperEdition;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\EpaperPage>
 */
class EpaperPageFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'edition_id' => EpaperEdition::factory(),
            'page_no' => $this->faker->numberBetween(1, 32),
            'image_path' => 'epaper/editions/1/pages/01.png',
            'thumb_path' => 'epaper/editions/1/thumbs/01.jpg',
            'width' => $this->faker->numberBetween(1200, 2400),
            'height' => $this->faker->numberBetween(1600, 3200),
        ];
    }
}
