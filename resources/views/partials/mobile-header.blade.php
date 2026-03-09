<header class="m-header">
    {{-- Logo (left) --}}
    <div class="col-3">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo_main.png') }}" alt="Main Logo" style="height: 40px;">
        </a>
    </div>

    {{-- Title / Secondary Logo (center) --}}
    <div class="logo col-7">
        <a href="{{ route('welcome') }}">
            <img src="{{ asset('images/logo.png') }}" alt="Site Logo" style="height: 40px;">
        </a>
    </div>

</header>

{{-- Two equal CTA buttons under header --}}

    
@auth
    <div class="cta-row cta-row-3">
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="cta-btn logout-btn" style="background:#ff6f00; color:#fff;">Logout</button>
        </form>
        <a class="cta-btn profile-btn" href="{{ route('dashboard') }}" style="background:#0007dd; color:#fff;">Dashboard</a>
        <a class="cta-btn search-btn" href="{{ route('search') }}" style="background:#005504; color:#fff;">Search</a>
    </div>
@else
    <div class="cta-row cta-row-3">
        <a class="cta-btn join-btn" href="{{ route('register') }}" style="background:#ff6f00; color:#fff;">Join</a>
        <a class="cta-btn search-btn" href="{{ route('search') }}" style="background:#0007dd; color:#fff;">Search</a>
        <a class="cta-btn login-btn" href="{{ route('login') }}" style="background:#0e5500; color:#fff;">Login</a>
    </div>
@endauth


{{-- Scrollable main content area --}}
<div class="mobile-post-scroll">
    @yield('content')
</div>
