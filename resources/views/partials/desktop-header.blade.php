<div id="main-navbar" class="container-fluid nav-bar bg-transparent col-md-12">
    {{-- LARGE SCREEN NAVBAR --}}
    <nav id="desktop-navbar" class="navbar navbar-expand-lg shadow-sm d-none d-lg-flex justify-content-between px-0 py-0 align-items-center"
        style="background-color: #ff7925; height: 60px;">
        
        {{-- Logo and Title --}}
        <div class="d-flex align-items-center" style="background-color: #ff7925; padding: 5px 10px; border-radius: 5px;">
            <a class="navbar-brand" href="{{ url('/') }}">
                <img src="{{ asset('images/logo_main.png') }}" style="height: 40px;" alt="Logo">
            </a>
        </div>
        <a class="navbar-brand" href="{{ url('/') }}">
            <img src="{{ asset('images/logo.png') }}" style="height: 40px;" alt="Logo">
        </a>

        <ul class="navbar-nav ms-auto text-uppercase" style="background-color: #000000; padding: 0 20px;">
            {{-- Home Link --}}
            {{-- Navigation Links --}}
            <li class="nav-item"><a class="nav-link" href="{{ url('/') }}"><h4 style="color: rgb(255, 255, 255);">Home</h4></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><h4 style="color: rgb(255, 255, 255);">About Us</h4></a></li>
            <li class="nav-item dropdown">
                <a class="nav-link" href="#"id="directories" role="button"
                    data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                    <h4 style="color: rgb(255, 255, 255);">Directories</h4>
                </a>
                <div class="dropdown-menu bg-orange" aria-labelledby="directories">
                    <a class="dropdown-item text-white" href="{{ url('/sikh/search') }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Panthak</h4></a>
                    <a class="dropdown-item text-white" href="{{ url('/business-directories') }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Business</h4></a>
                    <a class="dropdown-item text-white" href="{{ url('/jobs/search') }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Candidates need a Job</h4></a>
                    <a class="dropdown-item text-white" href="{{ url('/matrimonial') }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Matrimonial Listing</h4></a>
                </div>
            </li>
            <li class="nav-item"></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('posts.all') }}"><h4 style="color: rgb(255, 255, 255);">News</h4></a></li>
            <li class="nav-item"><a class="nav-link" href="#"><h4 style="color: rgb(255, 255, 255);">Contact Us</h4></a></li>
            <li class="nav-item"><a class="nav-link" href="{{ route('welcome') }}"><h4 style="color: rgb(255, 255, 255);">Search</h4></a></li>
            
            {{-- Search Form --}}

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
                    <a class="nav-link" href="#" id="desktopUserDropdown" role="button"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"
                        style="color: rgb(255, 255, 255);">
                        Welcome - {{ auth()->user()->name }}
                    </a>
                    <div class="dropdown-menu bg-orange" aria-labelledby="desktopUserDropdown">
                        <a class="dropdown-item text-white" href="{{ $route }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Dashboard</h4></a>
                        <a class="dropdown-item text-white" href="#"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Profile</h4></a>
                        <a class="dropdown-item text-white" href="#"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Edit Profile</h4></a>
                        <a class="dropdown-item text-white" href="{{ route('change.password.form') }}"><h4 style="color: rgb(31, 0, 171); background-color: #ff7925;">Change Password</h4></a>
                        <div class="dropdown-divider"></div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="dropdown-item text-white">Logout</button>
                        </form>
                    </div>
                </li>
            @else
                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}"><h4 style="color: rgb(255, 255, 255);">Login</h4></a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}"><h4 style="color: rgb(255, 255, 255);">Join</h4></a></li>
            @endauth
        </ul>
    </nav>
</div>
