<header>
        <!-- Header Start -->
       <div class="header-area">
            <div class="main-header ">
                <div class="header-top black-bg d-none d-md-block">
                   <div class="container">
                       <div class="col-xl-12">
                            <div class="row d-flex justify-content-between align-items-center">
                                <div class="header-info-left">
                                    <ul>
                                        <li>{{ \Carbon\Carbon::now()->format('l, j F Y') }}</li>
                                    </ul>
                                </div>
                                <div class="header-info-right">
                                    <ul class="header-social">
                                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                                        <li><a href="#"><i class="fab fa-instagram"></i></a></li>
                                       <li> <a href="#"><i class="fab fa-pinterest-p"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                       </div>
                   </div>
                </div>
                <div class="header-mid d-none d-md-flex align-items-center"
                     style="background-color: #ffffff;">
                    <div class="container d-flex align-items-center justify-content-between">
                        <!-- Logo slider -->
                        <div class="logo-slider">
                            <img class="logo-slide" src="{{ asset('images/logo-hindi.png') }}" height="90" width="350" alt="Logo">
                            <img class="logo-slide" src="{{ asset('images/logo-hindi.png') }}" height="90" width="350" alt="Logo">
                        </div>
                        <!-- Advertisement banner -->
                        <div class="header-ad">
                            <img src="{{ asset('images/whatsapp.png') }}" alt="Advertisement" style="max-height:90px; width:auto;">
                        </div>
                    </div>
                </div>
                <style>
                    .logo-slider {
                        position: relative;
                        display: inline-block;
                        height: 90px;
                    }
                    .logo-slide {
                        position: absolute;
                        top: 0;
                        left: 0;
                        animation: fadeInOut 6s infinite;
                        opacity: 0;
                    }
                    .logo-slide:nth-child(1) {
                        animation-delay: 0s;
                    }
                    .logo-slide:nth-child(2) {
                        animation-delay: 3s;
                    }
                    @keyframes fadeInOut {
                        0% { opacity: 0; }
                        5% { opacity: 1; }
                        45% { opacity: 1; }
                        50% { opacity: 0; }
                        100% { opacity: 0; }
                    }
                </style>
                <div class="header-bottom header-sticky" style="background-color: #ffffff;">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-xl-10 col-lg-10 col-md-12 header-flex">
                                <!-- sticky -->
                                <div class="sticky-logo">
                                    <a href="{{ route('welcome') }}"><img src="{{ asset('images/logo-hindi.png') }}" height="50" alt="KV badge"></a>
                                </div>
                                <!-- Main-menu -->
                                <div class="main-menu d-none d-md-block">
                                    <nav>
                                        <ul id="navigation">
                                            <li><a href="{{ route('welcome') }}">Home</a></li>
                                            <li><a href="#">News Categories</a>
                                                @php
                                                    // Fetch categories from the database
                                                    $categories = \App\Models\NewsCategory::orderBy('name')->get();
                                                @endphp
                                                <ul class="submenu">
                                                    @foreach($categories as $category)
                                                        <li><a href="{{ route('news-category.show', $category->slug) }}">{{ $category->name }}</a></li>
                                                    @endforeach
                                                </ul>
                                            </li>
                                            <li><a href="{{ route('about') }}">About</a></li>
                                            @auth
                                                @php
                                                    switch(Auth::user()->user_role_id){
                                                        case 1: $route = route('admin.dashboard'); break;
                                                        case 2: $route = route('promoter.dashboard'); break;
                                                        case 3: $route = route('pro.dashboard'); break;
                                                        case 4: $route = route('guest.dashboard'); break;
                                                    }
                                                @endphp
                                                <li><a href="{{ route('dashboard') }}">Dashboard</a></li>
                                                <li><form method="POST" action="{{ route('logout') }}">
                                                        @csrf
                                                        <button type="submit" class="dropdown-item">Logout</button>
                                                    </form>
                                                </li>
                                            @else
                                                <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                                                <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Signup</a></li>
                                            @endauth
                                        </ul>
                                    </nav>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-4">
                                <div class="header-right-btn f-right d-none d-lg-block">
                                    <i class="fas fa-search special-tag"></i>
                                    <div class="search-box">
                                        <form action="#">
                                            <input type="text" placeholder="Search">

                                        </form>
                                    </div>
                                </div>
                            </div>
                            <!-- Mobile Menu -->
                            <div class="col-12">
                                <div class="mobile_menu d-block d-md-none"></div>
                                <div class="row d-md-none mt-2">
                                    <div class="col-3">
                                        <a href="{{route('welcome')}}" style="color:black; font-size:12px;" target="_blank" rel="noopener noreferrer">
                                            <i class="fas fa-home me-1"></i> Home
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="https://lokbani.com/epaper/today" style="color:black; font-size:12px;" target="_blank" rel="noopener noreferrer">
                                            <i class="fas fa-newspaper me-1"></i> E-Paper
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="https://www.youtube.com/@lokbanitv" style="color:black; font-size:12px;" target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-youtube me-1"></i> Videos
                                        </a>
                                    </div>
                                    <div class="col-3">
                                        <a href="https://www.facebook.com/DailyLokBanipunjabiNewsPaper/" style="color:black; font-size:12px;" target="_blank" rel="noopener noreferrer">
                                            <i class="fab fa-facebook me-1"></i> Facebook
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
               </div>
            </div>
       </div>
        <!-- Header End -->
    </header>
