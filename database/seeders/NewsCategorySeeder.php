<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class NewsCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            'Politics', 'Crime', 'Sports', 'Business', 'Entertainment',
            'Technology', 'Health', 'Education', 'Lifestyle', 'World'
        ];

        foreach ($categories as $name) {
            \App\Models\NewsCategory::firstOrCreate([
                'slug' => \Illuminate\Support\Str::slug($name),
            ], [
                'name' => $name,
            ]);
        }
    }
}
