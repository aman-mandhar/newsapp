<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class EpaperController extends Controller
{
    /**
     * Display today's or latest e-paper PDF
     *
     * @return \Illuminate\View\View
     */
    public function today()
    {
        // Get the latest published post that has a PDF
        $post = Post::where('status', 'published')
            ->whereNotNull('pdf_url')
            ->where('pdf_url', '!=', '')
            ->latest('published_at')
            ->first();

        return view('epaper.today.index', compact('post'));
    }
}
