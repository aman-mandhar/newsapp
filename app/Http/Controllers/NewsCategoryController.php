<?php

namespace App\Http\Controllers;

use App\Models\NewsCategory;
use Illuminate\Http\Request;

class NewsCategoryController extends Controller
{
    public function index()
    {
        $categories = NewsCategory::all();
        return view('categories.index', compact('categories'));
    }

    public function create()
    {
        $categories = NewsCategory::all();
        return view('categories.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:news_categories,slug',
        ]);

        NewsCategory::create($validated);

        return redirect()->route('admin.categories.create')->with('success', 'Category created.');
    }

    public function show(NewsCategory $category)
    {
        return view('categories.show', compact('category'));
    }

    public function edit(NewsCategory $category)
    {
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, NewsCategory $category)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:news_categories,slug,' . $category->id,
        ]);

        $category->update($validated);

        return redirect()->route('admin.categories.create')->with('success', 'Category updated.');
    }

    public function destroy(NewsCategory $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.create')->with('success', 'Category deleted.');
    }

    public function CatPost(NewsCategory $category)
    {
        $posts = $category->posts()->latest()->paginate(10);
        return view('categories.posts', compact('category', 'posts'));
    }
}
