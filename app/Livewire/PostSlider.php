<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Post;

class PostSlider extends Component
{
    public function render()
    {
        $featuredPosts = Post::where('status', 'published')->latest()->take(5)->get();
        $latestPosts = Post::where('status', 'published')->latest()->skip(5)->take(5)->get();

        return view('livewire.post-slider', [
            'featuredPosts' => $featuredPosts,
            'latestPosts' => $latestPosts
        ]);
    }
}
