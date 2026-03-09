<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\NewsCategory;
use App\Models\Tag;

// for request handling
use Illuminate\Http\Request;

class HomeController extends Controller
{

    public function index()
    {
        // Top headlines ticker (latest 10 published)
        $topHeadlines = Post::where('status', 'published')
            ->latest('published_at')
            ->limit(10)
            ->get(['id', 'title', 'slug']);

        // Featured post (main hero)
        $featuredPost = Post::with(['categories:id,name'])
            ->where('status', 'published')
            ->latest('published_at')
            ->first();

        // Trending bottom (next 3 posts)
        $trendingPosts = Post::with(['categories:id,name'])
            ->where('status', 'published')
            ->latest('published_at')
            ->skip(1)
            ->take(3)
            ->get();

        // Right sidebar posts (5 recent)
        $sidebarPosts = Post::with(['categories:id,name'])
            ->where('status', 'published')
            ->latest('published_at')
            ->skip(4)
            ->take(4)
            ->get();

        // Weekly news carousel posts (10 posts)
        $weeklyPosts = Post::with(['categories:id,name'])
            ->where('status', 'published')
            ->latest('published_at')
            ->skip(10)
            ->take(10)
            ->get();

        // All categories with their posts (for category-wise sections)
        $categories = NewsCategory::orderBy('name')->get();
        $categorySections = [];
        $whatsNewCategories = [];

        foreach ($categories as $category) {
            $catPosts = Post::with(['categories:id,name', 'user'])
                ->where('posts.status', 'published')
                ->whereHas('categories', function ($q) use ($category) {
                    $q->where('news_categories.id', $category->id);
                })
                ->latest('posts.published_at')
                ->take(8)
                ->get();

            if ($catPosts->isNotEmpty()) {
                $categorySections[] = [
                    'category' => $category,
                    'posts' => $catPosts,
                ];

                // For Whats New section: get 4 posts per category
                $whatsNewCategories[] = [
                    'category' => $category,
                    'posts' => $catPosts->take(4),
                ];
            }
        }

        return view('home', compact(
            'topHeadlines',
            'featuredPost',
            'trendingPosts',
            'sidebarPosts',
            'weeklyPosts',
            'categorySections',
            'whatsNewCategories'
        ));
    }

    public function home()
    {
        return $this->index();
    }

    public function searchPost(Request $request)
    {
        $q = $request->input('q');

        $posts = Post::with(['categories:id,name', 'tags:id,name'])
            ->where('status', 'published')
            ->where(function ($query) use ($q) {
                $query->where('title', 'like', "%{$q}%")
                    ->orWhere('content', 'like', "%{$q}%")
                    ->orWhereHas('categories', function ($catQuery) use ($q) {
                        $catQuery->where('name', 'like', "%{$q}%");
                    })
                    ->orWhereHas('tags', function ($tagQuery) use ($q) {
                        $tagQuery->where('name', 'like', "%{$q}%");
                    });
            })
            ->orderByDesc('published_at')
            ->orderByDesc('id')
            ->paginate(10);

        return view('search-post', compact('posts'));
    }

    public function search()
    {
        // This method is intentionally left empty.
        // It can be used to handle search logic in the future.
        return view('search');
    }

    public function about()
    {
        return view('about');
    }
}
