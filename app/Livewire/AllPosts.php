<?php

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Post;

class AllPosts extends Component
{
    use WithPagination;

    protected $paginationTheme = 'bootstrap';   // ✅ needed for your UI

    public function render()
    {
        $posts = Post::with(['categories:id,name', 'tags:id,name'])
            ->where('status', 'published')
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(9);

        return view('livewire.all-posts', compact('posts'));
    }
}