@extends('layouts.dashboard.admin.layout')

@section('content')
<style>
    /* Pagination fixes (your previous overrides) */
    .pagination {
        display: flex;
        flex-wrap: wrap;
        gap: .25rem;
        align-items: center;
    }

    .pagination .page-item .page-link,
    .pagination .page-item a,
    .pagination .page-item span {
        font-size: 0.875rem; /* normal size */
        padding: .375rem .625rem;
        min-width: auto;
        height: auto;
        line-height: 1.2;
        border-radius: .2rem;
    }

    .pagination .page-link svg,
    .pagination .page-link::before,
    .pagination .page-link::after {
        width: 1em !important;
        height: 1em !important;
        font-size: 1em !important;
        display: inline-block !important;
        vertical-align: baseline !important;
    }

    .pagination .page-link,
    .pagination .page-link * {
        transform: none !important;
        zoom: 1 !important;
    }

    .pagination .page-link {
        background-size: contain !important;
        background-repeat: no-repeat !important;
    }

    /* Mobile card list styles */
    .post-card {
        border: 1px solid #e2e8f0;
        border-radius: 6px;
        padding: 12px;
        margin-bottom: 12px;
        background: #fff;
        box-shadow: 0 1px 2px rgba(0,0,0,.03);
    }
    .post-card .meta {
        font-size: .85rem;
        color: #6b7280;
    }
    .post-card .title {
        font-weight: 600;
        margin-bottom: 6px;
        word-break: break-word;
    }
    .post-card .actions {
        margin-top: 10px;
    }

    /* Small helpers to keep table readable on mobile if rendered */
    @media (max-width: 767.98px) {
        .table td, .table th {
            vertical-align: middle;
        }
    }
</style>

<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-3">
        <h1 class="mb-0">Posts</h1>
        <a href="{{ route('posts.create') }}" class="btn btn-primary">Create New Post</a>
    </div>

    {{-- Desktop / tablet table (md and up) --}}
    <div class="table-responsive d-none d-md-block">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th style="width:60px">#</th>
                    <th>Title</th>
                    <th class="d-none d-lg-table-cell" style="width:200px">Image</th>
                    <th class="d-none d-lg-table-cell">Slug</th>
                    <th style="width:110px">Status</th>
                    <th class="d-none d-lg-table-cell" style="width:120px">Published At</th>
                    <th class="d-none d-xl-table-cell" style="width:150px">Author</th>
                    <th style="width:180px">Actions</th>
                </tr>
            </thead>
            <tbody>
            @foreach($posts as $post)
                <tr>
                    <td>{{ $posts->firstItem() + $loop->index }}</td>
                    <td>{{ \Illuminate\Support\Str::limit($post->title, 80) }}</td>
                    <td class="d-none d-lg-table-cell">
                        @if($post->image_path)
                            <img src="{{ asset('storage/' . $post->image_path) }}"
                                 alt="{{ $post->title }}"
                                 loading="lazy"
                                 class="img-fluid rounded"
                                 style="max-width: 100px; max-height: 60px; object-fit: cover; object-position: center;">
                        @else
                            -
                        @endif
                    </td>
                    <td class="d-none d-lg-table-cell">{{ $post->slug }}</td>
                    <td>{{ ucfirst($post->status ?? '') }}</td>
                    <td class="d-none d-lg-table-cell">{{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}</td>
                    <td class="d-none d-xl-table-cell">{{ $post->user->name ?? 'Unknown' }}</td>
                    <td>
                        <div class="btn-group" role="group" aria-label="actions">
                            <a href="{{ route('posts.show', $post->slug) }}" class="btn btn-sm btn-success">Show</a>
                            <a href="{{ route('admin.posts.edit', $post) }}" class="btn btn-sm btn-warning">Edit</a>
                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger"
                                        onclick="return confirm('Are you sure?')">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>
    </div>

    {{-- Mobile card list (sm and xs) --}}
    <div class="d-block d-md-none">
        @foreach($posts as $post)
            <div class="post-card">
                <div class="d-flex justify-content-between">
                    <div class="row g-2">
                        <div class="col">
                            <div class="feature-img">
                                {{-- Post Image --}}
                                @if($post->image_path)
                                    <img src="{{ asset('storage/' . $post->image_path) }}"
                                        alt="{{ $post->title }}"
                                        loading="lazy"
                                        class="img-fluid mb-4 rounded"
                                        style="width: 100%;
                                                height: auto;
                                                max-height: 150px;
                                                object-fit: cover;
                                                object-position: center;
                                    ">
                                @endif
                            </div>
                        </div>
                        <div class="col">
                            <div class="title"
                                style="max-width:100%;
                                        text-wrap: wrap;
                                        ellipsis;
                                        overflow: hidden;
                                        font-size: 1.1rem;
                                        ">
                                {{ \Illuminate\Support\Str::limit($post->title, 70) }}
                            </div>
                            <div class="meta">
                                <span>#{{ $posts->firstItem() + $loop->index }}</span>
                                &nbsp;•&nbsp;
                                <span style="text-transform: capitalize;
                                    font-weight: 600;
                                    color: {{ $post->status === 'published' ? '#16a34a' : ($post->status === 'draft' ? '#a30000' : '#f59e0b') }};
                                    ">
                                    {{ ucfirst($post->status ?? '-') }}
                                </span>
                                &nbsp;•&nbsp;
                                <span style="font-family: monospace;
                                    background: #fdfcfc;
                                    padding: 2px 6px;
                                    border-radius: 4px;
                                    font-size: 0.85rem;
                                    ">
                                    {{ $post->published_at ? $post->published_at->format('d M Y') : '-' }}
                                </span>
                            </div>
                            <div class="meta mt-1"
                                style="max-width:100%;
                                        text-overflow:
                                        ellipsis;
                                        overflow: hidden;
                                        font-size: 0.9rem;
                                        font-style: bold;
                                        color: #e73905;"

                                >
                                By: {{ $post->user->name ?? 'Unknown' }}
                            </div>
                            {{-- compact actions dropdown --}}
                            <div class="ms-2 align-self-start">
                                <div class="dropdown">
                                    <button class="btn btn-outline-secondary btn-sm" type="button" id="actions-{{ $post->id }}" data-bs-toggle="dropdown" aria-expanded="false">
                                        Actions
                                    </button>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="actions-{{ $post->id }}">
                                        <li><a class="dropdown-item" href="{{ route('posts.show', $post->slug) }}">Show</a></li>
                                        <li><a class="dropdown-item" href="{{ route('admin.posts.edit', $post) }}">Edit</a></li>
                                        <li>
                                            <form action="{{ route('admin.posts.destroy', $post) }}" method="POST" class="d-inline-block w-100" onsubmit="return confirm('Are you sure?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="dropdown-item text-danger">Delete</button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    {{-- Pagination (works for both layouts) --}}
    <div class="d-flex justify-content-between align-items-center mt-3 flex-wrap">
        <div class="text-muted mb-2 mb-md-0">Showing {{ $posts->firstItem() ?? 0 }} to {{ $posts->lastItem() ?? 0 }} of {{ $posts->total() }} results</div>
        <div>
            {{ $posts->withQueryString()->links('pagination::bootstrap-4') }}
        </div>
    </div>
</div>
@endsection
