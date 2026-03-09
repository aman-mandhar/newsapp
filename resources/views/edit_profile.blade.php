@extends('layouts.front.layout')

@section('content')
<div class="container py-5">
    <h2 class="mb-4 text-center">✍️ Edit Your Profile</h2>

    <form method="POST" action="{{ route('update.profile') }}" enctype="multipart/form-data">
        @csrf

        <div class="row g-3">
            {{-- Name --}}
            <div class="col-md-12">
                <label class="form-label">Name *</label>
                <input type="text" name="name" value="{{ old('name', $user->name) }}" class="form-control @error('name') is-invalid @enderror">
                @error('name') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            {{-- Mobile --}}
            <div class="col-md-6">
                <label class="form-label">Mobile *</label>
                <input type="text" name="mobile" value="{{ old('mobile', $user->mobile) }}" class="form-control @error('mobile') is-invalid @enderror">
                @error('mobile') <div class="invalid-feedback">{{ $message }}</div> @enderror
            </div>

            <div class="col-md-12 text-center mt-4">
                <button type="submit" class="btn btn-primary px-5 py-2">Save Changes</button>
            </div>
        </div>
    </form>
</div>
@endsection
