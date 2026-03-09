<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TinyMCEController extends Controller
{
    public function upload(Request $request)
{
    $request->validate([
        'file' => 'required|image|max:2048',
    ]);

    $path = $request->file('file')->store('tinymce', 'public');

    return response()->json(['location' => asset('storage/' . $path)]);
}
}
