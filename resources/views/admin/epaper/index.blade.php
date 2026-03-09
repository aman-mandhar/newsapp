@extends('layouts.dashboard.admin.layout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3">ePaper Editions</h1>
                    <a href="{{ route('admin.epaper.editions.create') }}" class="btn btn-primary">
                        <i class="fa fa-plus"></i> Create New Edition
                    </a>
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
            <div class="col-md-12">
                <div class="card">
                    <div class="card-body">
                        @if($editions->count() > 0)
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>Edition Name</th>
                                            <th>Issue Date</th>
                                            <th>Status</th>
                                            <th>Total Pages</th>
                                            <th>Created</th>
                                            <th>Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($editions as $edition)
                                            <tr>
                                                <td>
                                                    <strong>{{ $edition->edition_name }}</strong>
                                                </td>
                                                <td>{{ $edition->issue_date->format('M d, Y') }}</td>
                                                <td>
                                                    @if($edition->status === 'published')
                                                        <span class="badge bg-success">Published</span>
                                                    @else
                                                        <span class="badge bg-warning">Draft</span>
                                                    @endif
                                                </td>
                                                <td>{{ $edition->total_pages ?? 0 }}</td>
                                                <td>{{ $edition->created_at->format('M d, Y') }}</td>
                                                <td>
                                                    <div class="btn-group" role="group">
                                                        <a href="{{ route('admin.epaper.editions.show', $edition) }}"
                                                           class="btn btn-sm btn-info" title="View">
                                                            <i class="fa fa-eye"></i>
                                                        </a>
                                                        <a href="{{ route('admin.epaper.editions.mapper', $edition) }}"
                                                           class="btn btn-sm btn-primary" title="Map Regions">
                                                            <i class="fa fa-map"></i>
                                                        </a>
                                                        <a href="{{ route('admin.epaper.editions.edit', $edition) }}"
                                                           class="btn btn-sm btn-warning" title="Edit">
                                                            <i class="fa fa-edit"></i>
                                                        </a>
                                                        <form action="{{ route('admin.epaper.editions.destroy', $edition) }}"
                                                              method="POST" class="d-inline"
                                                              onsubmit="return confirm('Are you sure you want to delete this edition?');">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-sm btn-danger" title="Delete">
                                                                <i class="fa fa-trash"></i>
                                                            </button>
                                                        </form>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>

                            <div class="mt-3">
                                {{ $editions->links() }}
                            </div>
                        @else
                            <div class="text-center py-5">
                                <i class="fa fa-file-pdf fa-3x text-muted mb-3"></i>
                                <p class="text-muted">No editions found. Create your first edition!</p>
                                <a href="{{ route('admin.epaper.editions.create') }}" class="btn btn-primary">
                                    <i class="fa fa-plus"></i> Create New Edition
                                </a>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
