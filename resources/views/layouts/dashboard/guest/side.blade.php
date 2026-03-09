@php
        $current = App\Models\User::find(Auth::user()->id);
        $role = App\Models\UserRole::find($current->user_role_id);
        $picture = $current->profile_image
            ? asset('storage/' . $current->profile_image)
            : asset('dashboard1/dist/img/my-avatar.png');

@endphp
<nav class="col-lg-2 col-md-3 sidebar" id="sidebarMenu">
    <a href="{{ route('guest.dashboard') }}" class="navbar-brand mx-4 mb-3">
        <i class="fa fa-tachometer-alt"></i> Dashboard
    </a>

    <div class="d-flex align-items-center ms-4 mb-4">
        <div class="position-relative">
            <img class="rounded-circle" src="{{ $picture }}" alt="{{ Auth::user()->name }} profile image" style="width: 40px; height: 40px;">
            <div class="bg-success rounded-circle border border-2 border-white position-absolute end-0 bottom-0 p-1"></div>
        </div>
        <div class="ms-3">
            <h6 class="mb-0">{{ Auth::user()->name }}</h6>
            <span>{{ $role->name }}</span>
        </div>
    </div>

    <div class="navbar-nav w-100">
        <a href="{{ route('welcome') }}"><i class="fa fa-home"></i> Home</a>
        <a href="{{ route('guest.dashboard') }}" class="active"><i class="fa fa-tachometer-alt"></i> Dashboard</a>
    </div>
</nav>

