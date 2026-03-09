<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\Auth;
use App\Models\VideoLink;

class VideoLinkController extends Controller
{
    public function create(Request $request): View|RedirectResponse
    {
        $type = $request->type; // e.g., "sikh"
        $id = $request->id;

        if (!$type || !$id) {
            return redirect()
                ->route('media.index')
                ->with('error', 'Select a post first to manage videos.');
        }

        $modelClass = match ($type) {
            'post' => \App\Models\Post::class,
            default => abort(404),
        };


        $modelInstance = $modelClass::findOrFail($id);


        return view('media.videos.create', [
            'modelClass' => $modelClass,
            'id' => $id,
            'videos' => $modelInstance->videoLinks, // 🧠 send video links
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'videoable_type' => 'required|string',
            'videoable_id'   => 'required|integer',
            'link'           => ['required', 'url', 'regex:/^(https:\/\/)?(www\.youtube\.com|youtu\.be)\/.+$/'],
            'caption'        => 'nullable|string|max:255',
        ]);

        \App\Models\VideoLink::create([
            'user_id'        => Auth::user()->id,
            'videoable_type' => $request->videoable_type,
            'videoable_id'   => $request->videoable_id,
            'link'           => $request->link,
            'caption'        => $request->caption,
        ]);

        return redirect()->back()->with('success', 'Video link added successfully!');
    }

    public function destroy($id)
    {
        $video = \App\Models\VideoLink::findOrFail($id);

        // Optional: check ownership
        if ($video->user_id !== Auth::user()->id) {
            abort(403); // unauthorized access
        }

        $video->delete();

        return back()->with('success', 'Video deleted successfully!');
    }

}
