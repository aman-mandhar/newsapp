<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\NewsCategory;
use App\Models\Tag;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class PostController extends Controller
{
    public function allPosts()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $isAdmin = ((int) $user->user_role_id) === 1;

        if ($isAdmin) {
            // only published if you want: ->where('published', 1)
            $posts = Post::with('user')   // eager load user
                        ->latest()
                        ->paginate(config('app.posts_per_page', 10));
            return view('posts.index', compact('posts'));
        } else {
            $posts = Post::with('user')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->paginate(config('app.posts_per_page', 10));
            return view('posts.all', compact('posts'));
        }
    }
    public function index()
    {
        $user = Auth::user();
        if (!$user) {
            abort(403, 'Unauthorized');
        }

        $isAdmin = ((int) $user->user_role_id) === 1;

        if ($isAdmin) {
            // only published if you want: ->where('published', 1)
            $posts = Post::with('user')   // eager load user
                        ->latest()
                        ->paginate(config('app.posts_per_page', 10));
            return view('posts.index', compact('posts'));
        }

        $posts = Post::with('user')
                    ->where('user_id', $user->id)
                    ->latest()
                    ->paginate(config('app.posts_per_page', 10));

        return view('posts.all', compact('posts'));
    }

    public function portalNews()
    {
        $posts = Post::with('user')
                    ->where('status', 'published')
                    ->latest()
                    ->paginate(config('app.posts_per_page', 10));

        return view('posts.portal-news', compact('posts'));
    }

    public function create()
    {
        // Only authenticated users can create posts
        $author = User::find(Auth::id());
            if (!$author) {
                abort(403, 'Unauthorized');
                return redirect()->route('login');
            }
        $categories = NewsCategory::all();
        $tags = Tag::all();
        $statuses = ['draft', 'published', 'archived'];
        return view('posts.create', compact('categories', 'tags', 'statuses', 'author'));
    }

    public function store(Request $request)
    {
        $author = User::find(Auth::id());
            if (!$author) {
                abort(403, 'Unauthorized');
                return redirect()->route('login');
            }
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image',
            'pdf_url' => 'nullable|url|max:500',
            'pdf_title' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
            'categories' => 'array',
            'tags' => 'array',
        ]);


        // Handle image upload
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('posts', 'public');
        }


        $post = Post::create([
            'user_id' => Auth::id(),
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $imagePath,
            'pdf_url' => $validated['pdf_url'] ?? null,
            'pdf_title' => $validated['pdf_title'] ?? null,
            'status' => $validated['status'],
            'published_at' => now(),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
        ]);

        $post->categories()->attach($request->categories);
        $post->tags()->attach($request->tags);
        if($author->user_role_id === 1){
            return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
        } else {
            return redirect()->route('posts.all')->with('success', 'Post created successfully.');
        }
    }

    public function show(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404, 'This post is not published.');
        }

        $post->load(['categories', 'tags']);
        $post->increment('views_count');

        return view('posts.show', compact('post'));
    }

    public function singleLayout(Post $post)
    {
        if ($post->status !== 'published') {
            abort(404, 'This post is not published.');
        }

        $post->load(['categories', 'tags']);
        $post->increment('views_count');

        return view('posts.single-layout', compact('post'));
    }

    public function draftEdit(Post $post)
    {
        $author = User::find(Auth::id());
            if (!$author) {
                abort(403, 'Unauthorized');
                return redirect()->route('login');
            }
        $categories = NewsCategory::all();
        $tags = Tag::all();
        $statuses = ['draft', 'published', 'archived'];

        return view('posts.draft-edit', compact('post', 'categories', 'tags', 'statuses', 'author'));
    }

    public function edit(Post $post)
    {
        $author = User::find(Auth::id());
            if (!$author) {
                abort(403, 'Unauthorized');
                return redirect()->route('login');
            }
        $categories = NewsCategory::all();
        $tags = Tag::all();
        $statuses = ['draft', 'published', 'archived'];

        return view('posts.edit', compact('post', 'categories', 'tags', 'statuses', 'author'));
    }

    public function update(Request $request, Post $post)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'content' => 'required',
            'image' => 'nullable|image',
            'pdf_url' => 'nullable|url|max:500',
            'pdf_title' => 'nullable|max:255',
            'status' => 'required|in:draft,published,archived',
            'published_at' => 'nullable|date',
            'meta_title' => 'nullable|max:255',
            'meta_description' => 'nullable|max:255',
            'meta_keywords' => 'nullable|max:255',
            'categories' => 'array',
            'tags' => 'array',
        ]);

        // Image replace
        if ($request->hasFile('image')) {
            if ($post->image_path) {
                Storage::disk('public')->delete($post->image_path);
            }
            $post->image_path = $request->file('image')->store('posts', 'public');
        }

        $post->update([
            'title' => $validated['title'],
            'content' => $validated['content'],
            'image_path' => $post->image_path,
            'pdf_url' => $validated['pdf_url'] ?? null,
            'pdf_title' => $validated['pdf_title'] ?? null,
            'status' => $validated['status'],
            'published_at' => $validated['published_at'] ?? now(),
            'meta_title' => $validated['meta_title'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
        ]);

        $post->categories()->sync($request->categories);
        $post->tags()->sync($request->tags);

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        // Delete image if exists
        if ($post->image_path) {
            Storage::disk('public')->delete($post->image_path);
        }

        $post->delete();

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
