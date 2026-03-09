@extends('layouts.dashboard.admin.layout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3">{{ $edition->edition_name }}</h1>
                    <div class="btn-group">
                        <a href="{{ route('admin.epaper.editions.mapper', $edition) }}" class="btn btn-primary">
                            <i class="fa fa-map"></i> Map Regions
                        </a>
                        <a href="{{ route('admin.epaper.editions.edit', $edition) }}" class="btn btn-warning">
                            <i class="fa fa-edit"></i> Edit
                        </a>
                        <a href="{{ route('admin.epaper.editions.index') }}" class="btn btn-secondary">
                            <i class="fa fa-arrow-left"></i> Back
                        </a>
                    </div>
                </div>
            </div>
        </div>

        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="row">
            <!-- Edition Details -->
            <div class="col-md-4">
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Edition Details</h5>
                    </div>
                    <div class="card-body">
                        <table class="table table-sm">
                            <tr>
                                <th>Issue Date:</th>
                                <td>{{ $edition->issue_date->format('M d, Y') }}</td>
                            </tr>
                            <tr>
                                <th>Status:</th>
                                <td>
                                    @if($edition->status === 'published')
                                        <span class="badge bg-success">Published</span>
                                    @else
                                        <span class="badge bg-warning">Draft</span>
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <th>Total Pages:</th>
                                <td>{{ $edition->total_pages ?? 0 }}</td>
                            </tr>
                            <tr>
                                <th>Created:</th>
                                <td>{{ $edition->created_at->format('M d, Y H:i') }}</td>
                            </tr>
                            <tr>
                                <th>Generated:</th>
                                <td>{{ $edition->generated_at?->format('M d, Y H:i') ?? 'N/A' }}</td>
                            </tr>
                        </table>

                        @if($edition->pdf_path)
                            <a href="{{ Storage::url($edition->pdf_path) }}"
                               class="btn btn-outline-primary btn-sm w-100"
                               target="_blank">
                                <i class="fa fa-file-pdf"></i> View PDF
                            </a>
                        @endif
                    </div>
                </div>

                <!-- Statistics -->
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Statistics</h5>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Articles:</span>
                                <strong>{{ $edition->articles->count() }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Total Regions:</span>
                                <strong>{{ $edition->pages->sum(fn($p) => $p->regions->count()) }}</strong>
                            </div>
                        </div>
                        <div class="mb-3">
                            <div class="d-flex justify-content-between">
                                <span>Mapped Regions:</span>
                                <strong>{{ $edition->pages->sum(fn($p) => $p->regions->where('article_id', '!=', null)->count()) }}</strong>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Pages List -->
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Pages</h5>
                    </div>
                    <div class="card-body">
                        @if($edition->pages->count() > 0)
                            <div class="row">
                                @foreach($edition->pages as $page)
                                    <div class="col-md-3 mb-3">
                                        <div class="card">
                                            @if($page->thumb_path || $page->image_path)
                                                <img src="{{ Storage::url($page->thumb_path ?? $page->image_path) }}"
                                                     class="card-img-top"
                                                     alt="Page {{ $page->page_no }}">
                                            @else
                                                <div class="card-img-top bg-light d-flex align-items-center justify-content-center" style="height: 200px;">
                                                    <i class="fa fa-file-image fa-3x text-muted"></i>
                                                </div>
                                            @endif
                                            <div class="card-body p-2">
                                                <h6 class="card-title mb-1">Page {{ $page->page_no }}</h6>
                                                <small class="text-muted">
                                                    {{ $page->regions->count() }} region(s)
                                                    @if($page->regions->where('article_id', '!=', null)->count() > 0)
                                                        <span class="text-success">
                                                            ({{ $page->regions->where('article_id', '!=', null)->count() }} mapped)
                                                        </span>
                                                    @endif
                                                </small>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-files fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No pages generated yet. Please wait for processing to complete.</p>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Articles List -->
                <div class="card mt-4">
                    <div class="card-header">
                        <h5 class="card-title mb-0">Articles</h5>
                    </div>
                    <div class="card-body">
                        @if($edition->articles->count() > 0)
                            <div class="list-group">
                                @foreach($edition->articles as $article)
                                    <div class="list-group-item">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <h6 class="mb-1">{{ $article->title }}</h6>
                                                @if($article->section)
                                                    <small class="text-muted">{{ $article->section }}</small>
                                                @endif
                                            </div>
                                            <span class="badge bg-info">
                                                {{ $article->regions->count() }} region(s)
                                            </span>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        @else
                            <div class="text-center py-4">
                                <i class="fa fa-newspaper fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No articles added yet.</p>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
