@extends('layouts.dashboard.admin.layout')

@section('content')
<div class="container">
    <h1 class="mb-4">Edit Tag</h1>

    <form action="{{ route('admin.tags.update', $tag) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label>Name</label>
            <input type="text" name="name" class="form-control" value="{{ old('name', $tag->name) }}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="mb-3">
            <label>Slug</label>
            <input type="text" name="slug" class="form-control" value="{{ old('slug', $tag->slug) }}" required>
            @error('slug') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
        <a href="{{ route('admin.tags.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
@endsection
