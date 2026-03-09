@extends('layouts.front.layout')

@section('content')

<div class="container">
    <h1 class="mb-3">{{ $post->title }}</h1>
    <div class="mb-3">
        @foreach($post->categories as $category)
            <span class="badge bg-primary">{{ $category->name }}</span>
        @endforeach
        @foreach($post->tags as $tag)
            <span class="badge bg-success">{{ $tag->name }}</span>
        @endforeach
    </div>
    <div>
        {!! $post->content !!}
    </div>
</div>
@endsection