@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Tags</h1>

    <a href="{{ route('admin.tags.create') }}" class="btn btn-primary mb-3">Create New Tag</a>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Slug</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        @foreach($tags as $tag)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $tag->name }}</td>
                <td>{{ $tag->slug }}</td>
                <td>
                    <a href="{{ route('admin.tags.show', $tag) }}" class="btn btn-sm btn-success">Show</a>
                    <a href="{{ route('admin.tags.edit', $tag) }}" class="btn btn-sm btn-warning">Edit</a>
                    <form action="{{ route('admin.tags.destroy', $tag) }}" method="POST" style="display:inline;">
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

    {{ $tags->links() }}
</div>
@endsection
