@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1>Category Details</h1>

    <div class="card">
        <div class="card-body">
            <h3>{{ $category->name }}</h3>
            <p><strong>Slug:</strong> {{ $category->slug }}</p>
            <p><strong>Created at:</strong> {{ $category->created_at->format('d M Y') }}</p>
        </div>
    </div>

    <a href="{{ route('categories.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
@endsection
