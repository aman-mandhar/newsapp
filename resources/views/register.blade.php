@extends('layouts.portal.view')
@section('content')

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-10 col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header fw-bold text-center">{{ ('Signing up"') }}</div>

                <div class="card-body">
                    <form method="POST" action="{{ route('register.post') }}">
                        @csrf

                        <div class="row">
                            {{-- Full Name --}}
                            <div class="mb-3">
                                <label for="name" class="form-label">Full Name <span class="text-danger">*</span></label>
                                <input id="name" type="text"
                                    class="form-control @error('name') is-invalid @enderror"
                                    name="name" value="{{ old('name') }}" required autofocus>
                                @error('name')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            {{-- Mobile Number --}}
                            <div class="col-md-6 mb-3">
                                <label for="mobile_number" class="form-label">Mobile Number <span class="text-danger">*</span></label>
                                    <small class="text-muted d-block mb-1">10-digit Whatsapp number.</small>
                                <input id="mobile_number" type="text"
                                    class="form-control @error('mobile_number') is-invalid @enderror"
                                    name="mobile_number" value="{{ old('mobile_number') }}" required maxlength="10" pattern="\d{10}">
                                @error('mobile_number')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Email (optional) --}}
                            <div class="col-md-6 mb-3">
                                <label for="email" class="form-label">Email</label>
                                    <small class="text-muted d-block mb-1">will be use for recover account</small>
                                <input id="email" type="email"
                                    class="form-control @error('email') is-invalid @enderror"
                                    name="email" value="{{ old('email') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row">
                            {{-- Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password <span class="text-danger">*</span></label>
                                <input id="password" type="password"
                                    class="form-control @error('password') is-invalid @enderror"
                                    name="password" required minlength="8">
                                @error('password')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            {{-- Confirm Password --}}
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input id="password_confirmation" type="password"
                                    class="form-control"
                                    name="password_confirmation" required>
                            </div>
                        </div>

                        <div class="row">
                            {{-- 📍 Map Component for Location --}}
                            <lable for="location" class="form-label">Your Current Location ?<span class="text-danger">*</span></label>
                            @include('components.map-location-plain')

                            {{-- Hidden Referral Code --}}
                            <input type="hidden" name="ref_code" value="{{ $ref_code ?? '' }}">
                        </div>

                        {{-- Submit --}}
                        <div class="mb-0 text-center">
                            <button type="submit" class="btn btn-success px-4">
                                {{ 'Register' }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
    $(document).ready(function () {
        if ($.fn.select2 && !$('#city').hasClass("select2-hidden-accessible")) {
            $('#city').select2({
                placeholder: "-- Choose City --",
                allowClear: true,
                width: '100%'
            });
        }
    });
</script>
@endpush
