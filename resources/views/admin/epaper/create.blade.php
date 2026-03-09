@extends('layouts.dashboard.admin.layout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3">Create New ePaper Edition</h1>
                    <a href="{{ route('admin.epaper.editions.index') }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back to List
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.epaper.editions.store') }}" method="POST" enctype="multipart/form-data">
                            @csrf

                            <!-- Edition Name -->
                            <div class="mb-3">
                                <label for="edition_name" class="form-label">Edition Name *</label>
                                <input type="text"
                                       class="form-control @error('edition_name') is-invalid @enderror"
                                       id="edition_name"
                                       name="edition_name"
                                       value="{{ old('edition_name') }}"
                                       placeholder="e.g., Daily Times - Morning Edition"
                                       required>
                                @error('edition_name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Issue Date -->
                            <div class="mb-3">
                                <label for="issue_date" class="form-label">Issue Date *</label>
                                <input type="date"
                                       class="form-control @error('issue_date') is-invalid @enderror"
                                       id="issue_date"
                                       name="issue_date"
                                       value="{{ old('issue_date', date('Y-m-d')) }}"
                                       required>
                                @error('issue_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PDF Upload -->
                            <div class="mb-3">
                                <label for="pdf" class="form-label">PDF File *</label>
                                <input type="file"
                                       class="form-control @error('pdf') is-invalid @enderror"
                                       id="pdf"
                                       name="pdf"
                                       accept="application/pdf"
                                       required>
                                <div class="form-text">Upload a PDF file (max 50MB). Pages will be generated automatically.</div>
                                @error('pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Info Alert -->
                            <div class="alert alert-info">
                                <i class="fa fa-info-circle"></i>
                                <strong>Next Steps:</strong> After upload, you'll be redirected to the mapping screen where you can define hotspots and attach articles to each region.
                            </div>

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.epaper.editions.index') }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-upload"></i> Create & Continue to Mapping
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
