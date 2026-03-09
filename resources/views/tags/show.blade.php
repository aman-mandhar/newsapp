@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Tag Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $tag->name }}</h3>
            <p><strong>Slug:</strong> {{ $tag->slug }}</p>
            <p><strong>Created at:</strong> {{ $tag->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
