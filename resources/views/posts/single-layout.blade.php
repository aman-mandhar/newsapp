@extends('layouts.main.layout')

{{-- SEO & OG Tags --}}
@section('title', $post->meta_title ?? $post->title)
@section('description', $post->meta_description ?? Str::limit(strip_tags($post->content), 150))
@section('keywords', $post->meta_keywords)
@section('og_title', $post->title)
@section('og_description', $post->meta_description ?? Str::limit(strip_tags($post->content), 150))
@section('og_image', $post->image_path ? asset('storage/' . $post->image_path) : asset('images/logo.png'))
@section('og_url', url()->current())

@section('content')
    <main class="mobile-post-scroll">
        <h1 style="font-weight: 800; 
                   margin: 6px 0 8px; 
                   color: #000076; 
                   text-align: center;" 
            class="text-center">
                {{ $post->title }}</h1>
        <div style="text-align: center;">
            {{-- Post Image --}}
            @if($post->image_path)
                <img src="{{ asset('storage/' . $post->image_path) }}"
                    style="width: auto; height: 170px;"
                    alt="Logo">
            @endif
        </div>
        <p class="text-muted mb-4">
            <small>
                <i class="bi bi-calendar"></i> {{ $post->created_at->format('d M Y') }} |
                <i class="bi bi-eye"></i> {{ $post->views_count }} Views |
            </small>
        </p>
        <div class="after-image" style="text-align: center; width: 100%; height: 150px; margin-bottom: 20px; background: #ffa754;>
            <h2 style="color: #000c67;">
                Space for Advertisement
            </h2>
        </div>
        {{-- Post Content --}}
        <div class="post-content mb-4">
            {!! $post->content !!}
        </div>
        {{-- Categories & Tags --}}
        <div class="mb-4">
            <p><strong>Categories:</strong>
                @forelse($post->categories as $category)
                    <span class="badge bg-dark text-white">{{ $category->name }}</span>
                @empty
                    <span class="text-muted">None</span>
                @endforelse
            </p>

            <p><strong>Tags:</strong>
                @forelse($post->tags as $tag)
                    <span class="badge bg-secondary text-white">{{ $tag->name }}</span>
                @empty
                    <span class="text-muted">None</span>
                @endforelse
            </p>

            <p class="text-muted mt-2">
                Published on: {{ $post->published_at ? $post->published_at->format('d M Y') : 'N/A' }}
            </p>
        </div>

        {{-- Share Buttons --}}
        <div class="mt-5 text-center">
            <h5 class="mb-3">📣 Share this post:</h5>
            <div class="d-inline-flex gap-2 flex-wrap justify-content-center">
                {{-- WhatsApp --}}
                <a href="https://wa.me/?text={{ urlencode($post->title . ' - ' . url()->current()) }}"
                target="_blank" class="btn btn-success btn-sm">
                    <i class="bi bi-whatsapp"></i> WhatsApp
                </a>

                {{-- Facebook --}}
                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(url()->current()) }}"
                target="_blank" class="btn btn-primary btn-sm">
                    <i class="bi bi-facebook"></i> Facebook
                </a>

                {{-- Email --}}
                <a href="mailto:?subject={{ urlencode('Check out this post: ' . $post->title) }}&body={{ urlencode(url()->current()) }}"
                class="btn btn-danger btn-sm">
                    <i class="bi bi-envelope"></i> Email
                </a>

                {{-- Copy Link --}}
                <button type="button" class="btn btn-secondary btn-sm"
                        onclick="navigator.clipboard.writeText('{{ url()->current() }}'); alert('🔗 Link copied to clipboard!')">
                    <i class="bi bi-clipboard"></i> Copy Link
                </button>
            </div>
        </div>
        @livewire('all-posts')
        @livewire('business-page')
        @livewire('sikh')
   </main>
@endsection