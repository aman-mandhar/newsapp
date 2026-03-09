@extends('layouts.portal.view')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-6 col-lg-4">
            <div class="card shadow-lg rounded-lg border-0">
                <div class="card-header text-center bg-gradient-primary text-white py-4">
                    <h4>{{ __('Login') }}</h4>
                </div>

                <div class="card-body p-4">
                    <form method="POST" action="{{ route('login.submit') }}">
                        @csrf

                        <!-- Mobile Input -->
                        <div class="mb-3">
                            <label for="mobile" class="form-label">{{ __('Mobile') }}</label>
                            <input id="mobile" type="text" class="form-control rounded-pill @error('mobile') is-invalid @enderror" name="mobile" value="{{ old('mobile') }}" required autocomplete="mobile" autofocus>
                            @error('mobile')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Password Input -->
                        <div class="mb-3 position-centered">
                            <label for="password" class="form-label">{{ __('Password') }}</label>
                            <input id="password" type="password" class="form-control rounded-pill @error('password') is-invalid @enderror" name="password" required autocomplete="current-password">
                            <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password" style="position: absolute; top: 50%; right: 15px; transform: translateY(-50%); cursor: pointer;"></span>
                            @error('password')
                                <div class="invalid-feedback">
                                    <strong>{{ $message }}</strong>
                                </div>
                            @enderror
                        </div>

                        <!-- Login Button & Forgot Password Link -->
                        <div class="mb-3 d-flex justify-content-between align-items-center">
                            <button type="submit" class="btn-login">
                                {{ __('Login') }}
                            </button>
                        </div>
                    </form>
                    <div class="row">
                        <div class="col-6">
                            <!-- Forgot Password Link -->
                                @if (Route::has('password.request'))
                                    <div class="d-flex justify-content-center">
                                        <a class="btn-request" href="{{ route('password.request') }}">
                                            {{ __('Forgot Your Password?') }}
                                        </a>
                                    </div>
                                @endif
                        </div>
                        <div class="col-6">
                        <!-- Create Account Link -->
                            <div class="mt-3 text-center">
                                <a href="{{ route('register') }}" class="btn-reg">{{ __('JOIN NOW') }}</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Custom CSS for styling -->
<style>
    /* Card Gradient and Shadows */
    .card {
        border-radius: 15px;
        overflow: hidden;
        background: #f8f9fa;
    }

    .bg-gradient-primary {
        background: linear-gradient(to right, #ec9e0e, #e2b665);
    }

    /* Button Container */
    /* --- Theme tokens (tweak these to match your brand) --- */
    :root{
    --primary-500:#f8d6a4;   /* Bootstrap-ish primary */
    --primary-600:#d7850b;
    --primary-700:#0a58ca;
    --slate-700:#334155;
    --slate-500:#64748b;
    --ring:#93c5fd;          /* focus ring */
    --text:#0f172a;          /* main text */
    --white:#fff;
    --login:#001540;         /* page background */
    }

    /* Shared button feel for all three */
    .btn-login,
    .btn-reg,
    .btn-request{
    display:inline-flex;
    align-items:center;
    justify-content:center;
    gap:.5rem;
    font-weight:600;
    line-height:1.2;
    border-radius:9999px;              /* pill */
    transition:transform .15s ease, box-shadow .15s ease, background-color .2s ease, color .2s ease, border-color .2s ease;
    text-decoration:none !important;   /* keep links looking like buttons */
    cursor:pointer;
    }

    /* 1) Primary action: Login (solid, subtle gradient) */
    .btn-login{
    padding:.7rem 1.15rem;
    color:var(--login);
    border:0;
    background:linear-gradient(#01450f, var(--primary-600), var(--primary-500));
    box-shadow:0 6px 16px rgba(13,110,253,.25);
    }
    .btn-login:hover{
    transform:translateY(-1px);
    box-shadow:0 10px 22px rgba(13,110,253,.28);
    background:linear-gradient(135deg, var(--primary-700), var(--primary-600));
    }
    .btn-login:active{
    transform:translateY(0);
    box-shadow:0 4px 12px rgba(13,110,253,.22);
    }
    .btn-login:focus-visible{
    outline:2px solid var(--ring);
    outline-offset:2px;
    }

    /* 2) Secondary: Register (outline that fills on hover) */
    .btn-reg{
    padding:.65rem 1.1rem;
    background:transparent;
    color:var(--primary-600);
    border:2px solid var(--primary-600);
    }
    .btn-reg:hover{
    color:var(--white);
    background:linear-gradient(135deg, var(--primary-600), var(--primary-500));
    border-color:transparent;
    transform:translateY(-1px);
    box-shadow:0 8px 18px rgba(13,110,253,.22);
    }
    .btn-reg:active{
    transform:translateY(0);
    }
    .btn-reg:focus-visible{
    outline:2px solid var(--ring);
    outline-offset:2px;
    }

    /* 3) Tertiary: Forgot Password (link-style button) */
    .btn-request{
    padding:.25rem .25rem;   /* keep it compact */
    background:transparent;
    border:0;
    color:var(--slate-700);
    font-weight:600;
    }
    .btn-request:hover{
    color:var(--primary-700);
    text-decoration:underline;
    }
    .btn-request:focus-visible{
    outline:2px solid var(--ring);
    outline-offset:2px;
    border-radius:.5rem;
    }

    /* Disabled state (works if you add disabled attribute or .disabled class) */
    .btn-login:disabled,
    .btn-reg:disabled,
    .btn-request:disabled,
    .btn-login.disabled,
    .btn-reg.disabled,
    .btn-request.disabled{
    opacity:.6;
    pointer-events:none;
    box-shadow:none;
    transform:none;
    }

    /* Motion sensitivity */
    @media (prefers-reduced-motion: reduce){
    .btn-login,
    .btn-reg,
    .btn-request{
        transition:none;
    }
    }

    /* Optional: dark mode (works with Bootstrap's data-bs-theme="dark") */
    [data-bs-theme="dark"] .btn-request{
    color:#cbd5e1;
    }
    [data-bs-theme="dark"] .btn-request:hover{
    color:#e2e8f0;
    }


    /* Button Styling */
    .btn-primary {
        background-color: #0062E6;
        border: none;
        border-radius: 30px;
        font-weight: bold;
        transition: background-color 0.3s ease;
    }

    .btn-primary:hover {
        background-color: #0050b3;
    }

    /* Input Fields */
    .form-control {
        border-radius: 30px;
        padding: 15px;
        font-size: 1rem;
    }

    .form-control:focus {
        border-color: #0050b3;
        box-shadow: 0 0 0 0.2rem rgba(0, 123, 255, 0.25);
    }

    .field-icon {
        z-index: 2;
    }

    /* Error Messages */
    .invalid-feedback {
        font-size: 0.875rem;
        color: #e74a3b;
    }

    /* Text links */
    .btn-link {
        font-size: 0.9rem;
    }

    /* Responsive Styling */
    @media (max-width: 768px) {
        .card {
            margin-top: 20px;
        }
    }
</style>

<!-- Script to toggle password visibility -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        const togglePassword = document.querySelector('.toggle-password');
        const passwordInput = document.querySelector('#password');

        togglePassword.addEventListener('click', function () {
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    });
</script>

@endsection
