@extends('layouts.dashboard.admin.layout')
@section('content')
    <div class="container-fluid py-4">
        <div class="row mb-4">
            <div class="col-md-12">
                <div class="d-flex justify-content-between align-items-center">
                    <h1 class="h3">Edit Edition</h1>
                    <a href="{{ route('admin.epaper.editions.show', $edition) }}" class="btn btn-secondary">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-md-8 mx-auto">
                <div class="card">
                    <div class="card-body">
                        <form action="{{ route('admin.epaper.editions.update', $edition) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Edition Name -->
                            <div class="mb-3">
                                <label for="edition_name" class="form-label">Edition Name *</label>
                                <input type="text"
                                       class="form-control @error('edition_name') is-invalid @enderror"
                                       id="edition_name"
                                       name="edition_name"
                                       value="{{ old('edition_name', $edition->edition_name) }}"
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
                                       value="{{ old('issue_date', $edition->issue_date->format('Y-m-d')) }}"
                                       required>
                                @error('issue_date')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select @error('status') is-invalid @enderror"
                                        id="status"
                                        name="status">
                                    <option value="draft" {{ old('status', $edition->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                                    <option value="published" {{ old('status', $edition->status) === 'published' ? 'selected' : '' }}>Published</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- PDF Upload (Optional) -->
                            <div class="mb-3">
                                <label for="pdf" class="form-label">Replace PDF (Optional)</label>
                                <input type="file"
                                       class="form-control @error('pdf') is-invalid @enderror"
                                       id="pdf"
                                       name="pdf"
                                       accept="application/pdf">
                                <div class="form-text">
                                    Leave empty to keep existing PDF. Uploading a new PDF will regenerate all pages.
                                    @if($edition->pdf_path)
                                        <br>Current: <a href="{{ Storage::url($edition->pdf_path) }}" target="_blank">View PDF</a>
                                    @endif
                                </div>
                                @error('pdf')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Warning Alert -->
                            @if($edition->pages->count() > 0)
                                <div class="alert alert-warning">
                                    <i class="fa fa-exclamation-triangle"></i>
                                    <strong>Warning:</strong> Uploading a new PDF will regenerate all pages and may affect existing region mappings.
                                </div>
                            @endif

                            <!-- Submit Buttons -->
                            <div class="d-flex justify-content-end gap-2">
                                <a href="{{ route('admin.epaper.editions.show', $edition) }}" class="btn btn-secondary">
                                    Cancel
                                </a>
                                <button type="submit" class="btn btn-primary">
                                    <i class="fa fa-save"></i> Update Edition
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
