@extends('layouts.front.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">📰 Blog</h1>

    @foreach($posts as $post)
        <div class="mb-4">
            <h3><a href="{{ route('blog.show', $post->slug) }}">{{ $post->title }}</a></h3>
            <p>{!! Str::limit(strip_tags($post->content), 150) !!}</p>
            <div>
                <strong>Categories:</strong>
                @foreach($post->categories as $category)
                    <span class="badge bg-primary">{{ $category->name }}</span>
                @endforeach
            </div>
            <div>
                <strong>Tags:</strong>
                @foreach($post->tags as $tag)
                    <span class="badge bg-success">{{ $tag->name }}</span>
                @endforeach
            </div>
        </div>
    @endforeach

    {{ $posts->links() }}
</div>
@endsection
