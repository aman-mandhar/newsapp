@php
    try {
        if(Auth::check()) {
            switch(Auth::user()->user_role_id){
                case 1:
                    $route = route('admin.dashboard');
                    break;
                case 2:
                    $route = route('promoter.dashboard');
                    break;
                case 3:
                    $route = route('pro.dashboard');
                    break;
                case 4:
                    $route = route('guest.dashboard');
                    break;
                default:
                    Auth::logout();
                    session()->flash('error', 'Invalid role! You have been logged out.');
                    $route = route('login');
                    break;
            }
        } else {
            $route = route('login');
        }
    } catch (\Exception $e) {
        $route = route('login');
    }
@endphp

<div id="main-navbar" class="container-fluid nav-bar bg-transparent col-md-12">
    {{-- LARGE SCREEN NAVBAR --}}
    <nav id="desktop-navbar" class="navbar navbar-expand-lg shadow-sm d-none d-lg-flex justify-content-between px-0 py-0 align-items-center">
        <div class="d-flex align-items-center" style="background-color: #ff7925; padding: 5px 10px; border-radius: 5px;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo_main.png') }}" style="height: 40px;" alt="Logo">
            </a>
        </div>
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" style="height: 40px;" alt="Logo">
        </a>

        <ul class="navbar-nav ms-auto text-uppercase">
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}">Home</a></li>
            <li class="nav-item"><a class="nav-link" href="#">About Us</a></li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#"id="directories" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    Directories
                </a>
                <div class="dropdown-menu bg-orange" aria-labelledby="directories">
                    <a class="dropdown-item text-white" href="{{ url('/sikh/search') }}">Panthak</a>
                    <a class="dropdown-item text-white" href="{{ url('/business-directories') }}">Business</a>
                    <a class="dropdown-item text-white" href="{{ url('/job-directories') }}">Candidates need a Job</a>
                    <a class="dropdown-item text-white" href="{{ url('/matrimonial') }}">Matrimonial Listing</a>
                </div>
            </li>
            <li class="nav-item"></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('posts.all') }}">News</a></li>
            <li class="nav-item"><a class="nav-link" href="#">Contact Us</a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}">Search</a></li>

            {{-- User Authentication Links --}}
            @auth
                @php
                    switch(Auth::user()->user_role_id){
                        case 1: $route = route('admin.dashboard'); break;
                        case 2: $route = route('promoter.dashboard'); break;
                        case 3: $route = route('pro.dashboard'); break;
                        case 4: $route = route('guest.dashboard'); break;
                    }
                @endphp
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" id="desktopUserDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Welcome, {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu bg-orange" aria-labelledby="desktopUserDropdown">
                        <a class="dropdown-item text-white" href="{{ $route }}">Dashboard</a>
                        <a class="dropdown-item text-white" href="{{ route('profile') }}">Profile</a>
                        <a class="dropdown-item text-white" href="{{ route('edit.profile') }}">Edit Profile</a>
                        <a class="dropdown-item text-white" href="{{ route('change.password.form') }}">Change Password</a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-white">Logout</button>
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Signup</a></li>
            @endauth
        </ul>
    </nav>
</div>
