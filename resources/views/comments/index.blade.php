@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Comments</h1>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Post</th>
                <th>User</th>
                <th>Comment</th>
                <th>Status</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($comments as $comment)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $comment->post->title ?? 'N/A' }}</td>
                <td>{{ $comment->user->name ?? 'Guest' }}</td>
                <td>{{ Str::limit($comment->comment_text, 50) }}</td>
                <td>{{ ucfirst($comment->status) }}</td>
                <td>{{ $comment->created_at->format('d M Y') }}</td>
                <td>
                    <a href="{{ route('comments.show', $comment) }}" class="btn btn-sm btn-success">Show</a>
                    <form action="{{ route('comments.destroy', $comment) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-sm btn-danger"
                                onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>

    {{ $comments->links() }}
</div>
@endsection
