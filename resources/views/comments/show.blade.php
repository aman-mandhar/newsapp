@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Comment Details</h1>

    <div class="card">
        <div class="card-body">
            <p><strong>Post:</strong> {{ $comment->post->title ?? 'N/A' }}</p>
            <p><strong>User:</strong> {{ $comment->user->name ?? 'Guest' }}</p>
            <p><strong>Comment:</strong></p>
            <p>{{ $comment->comment_text }}</p>
            <p><strong>Status:</strong> {{ ucfirst($comment->status) }}</p>
            <p><strong>Created at:</strong> {{ $comment->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <a href="{{ route('comments.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
