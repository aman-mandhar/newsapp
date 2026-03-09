<?php

namespace App\Http\Controllers;

use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index()
    {
        $tags = Tag::latest()->paginate(10);
        return view('tags.index', compact('tags'));
    }

    public function create()
    {
        $tags = Tag::all();
        return view('tags.create', compact('tags'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:tags,slug',
        ]);

        Tag::create($validated);

        return redirect()->route('admin.tags.create')->with('success', 'Tag created.');
    }

    public function show(Tag $tag)
    {
        return view('tags.show', compact('tag'));
    }

    public function edit(Tag $tag)
    {
        return view('tags.edit', compact('tag'));
    }

    public function update(Request $request, Tag $tag)
    {
        $validated = $request->validate([
            'name' => 'required|max:255',
            'slug' => 'required|unique:tags,slug,' . $tag->id,
        ]);

        $tag->update($validated);

        return redirect()->route('admin.tags.create')->with('success', 'Tag updated.');
    }

    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->route('admin.tags.create')->with('success', 'Tag deleted.');
    }
}
