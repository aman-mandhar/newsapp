@extends('layouts.dashboard.admin.layout')

@section('title', 'Media Manager')

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h4 class="mb-0">Media Manager</h4>
    </div>

    @if(session('error'))
        <div class="alert alert-warning">
            {{ session('error') }}
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped align-middle">
                    <thead>
                        <tr>
                            <th style="width: 70px;">ID</th>
                            <th>Post</th>
                            <th style="width: 180px;">Published</th>
                            <th style="width: 220px;">Media</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($posts as $post)
                            <tr>
                                <td>{{ $post->id }}</td>
                                <td>{{ \Illuminate\Support\Str::limit($post->title, 80) }}</td>
                                <td>
                                    {{ $post->published_at ? $post->published_at->format('Y-m-d') : 'Draft' }}
                                </td>
                                <td>
                                    <a href="{{ route('media.images.create', ['type' => 'post', 'id' => $post->id]) }}" class="btn btn-sm btn-outline-primary">
                                        <i class="fa fa-image"></i> Images
                                    </a>
                                    <a href="{{ route('media.videos.create', ['type' => 'post', 'id' => $post->id]) }}" class="btn btn-sm btn-outline-secondary">
                                        <i class="fa fa-video"></i> Videos
                                    </a>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-muted text-center">No posts found.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection
