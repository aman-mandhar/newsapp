<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tags = [
            'breaking', 'exclusive', 'featured', 'opinion', 'interview',
            'update', 'analysis', 'local', 'international', 'trending'
        ];

        foreach ($tags as $name) {
            \App\Models\Tag::firstOrCreate([
                'slug' => \Illuminate\Support\Str::slug($name),
            ], [
                'name' => ucfirst($name),
            ]);
        }
    }
}
