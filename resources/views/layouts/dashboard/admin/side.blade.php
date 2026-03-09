@php
        $current = App\Models\User::find(Auth::user()->id);
        $role = App\Models\UserRole::find($current->user_role_id);
        $picture = $current->profile_image
            ? asset('storage/' . $current->profile_image)
            : asset('dashboard1/dist/img/my-avatar.png');

@endphp
<nav class="col-lg-2 col-md-3 sidebar" id="sidebarMenu">
    <a href="{{ route('admin.dashboard') }}" class="navbar-brand mx-4 mb-3">
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

        <!-- News Management -->
        <a class="nav-link" data-bs-toggle="collapse" href="#newsMenu" role="button">
            <i class="fa fa-newspaper"></i> News
        </a>
        <div class="collapse" id="newsMenu">
            <a href="{{ route('admin.posts.index') }}" class="dropdown-item"><i class="fa fa-newspaper-o"></i> All Posts</a>
            <a href="{{ route('posts.create') }}" class="dropdown-item"><i class="fa fa-plus"></i> Add New Post</a>
        </div>

        <!-- Categories -->
        <a class="nav-link" data-bs-toggle="collapse" href="#categoryMenu" role="button">
            <i class="fa fa-folder"></i> Categories
        </a>
        <div class="collapse" id="categoryMenu">
            <a href="{{ route('admin.categories.index') }}" class="dropdown-item"><i class="fa fa-list"></i> All Categories</a>
            <a href="{{ route('admin.categories.create') }}" class="dropdown-item"><i class="fa fa-plus"></i> Add New Category</a>
        </div>

        <!-- Tags -->
        <a class="nav-link" data-bs-toggle="collapse" href="#tagMenu" role="button">
            <i class="fa fa-tags"></i> Tags
        </a>
        <div class="collapse" id="tagMenu">
            <a href="{{ route('admin.tags.index') }}" class="dropdown-item"><i class="fa fa-list"></i> All Tags</a>
            <a href="{{ route('admin.tags.create') }}" class="dropdown-item"><i class="fa fa-plus"></i> Add New Tag</a>
        </div>

        <!-- Comments -->
        <a href="{{ route('admin.comments.index') }}" class="nav-link">
            <i class="fa fa-comments"></i> Comments
        </a>

        <!-- ePaper -->
        <a class="nav-link" data-bs-toggle="collapse" href="#epaperMenu" role="button">
            <i class="fa fa-file-pdf"></i> ePaper
        </a>
        <div class="collapse" id="epaperMenu">
            <a href="{{ route('admin.epaper.editions.index') }}" class="dropdown-item"><i class="fa fa-list"></i> All Editions</a>
            <a href="{{ route('admin.epaper.editions.create') }}" class="dropdown-item"><i class="fa fa-plus"></i> Create Edition</a>
        </div>

        <!-- Media -->
        <a class="nav-link" data-bs-toggle="collapse" href="#mediaMenu" role="button">
            <i class="fa fa-images"></i> Media
        </a>
        <div class="collapse" id="mediaMenu">
            <a href="{{ route('media.index') }}" class="dropdown-item"><i class="fa fa-photo-film"></i> Select Post</a>
        </div>

        <!-- User Management -->
        <a href="{{ route('role.change') }}" class="nav-link">
            <i class="fa fa-users"></i> Change User Role
        </a>

        <!-- Profile -->
        <a class="nav-link" data-bs-toggle="collapse" href="#profileMenu" role="button">
            <i class="fa fa-user"></i> Profile
        </a>
        <div class="collapse" id="profileMenu">
            <a href="{{ route('profile.show') }}" class="dropdown-item"><i class="fa fa-id-card"></i> View Profile</a>
            <a href="{{ route('auth.profile.edit') }}" class="dropdown-item"><i class="fa fa-edit"></i> Edit Profile</a>
            <a href="{{ route('password.change') }}" class="dropdown-item"><i class="fa fa-key"></i> Change Password</a>
        </div>

        <!-- Logout -->
        <form method="POST" action="{{ route('logout') }}" class="d-inline">
            @csrf
            <button type="submit" class="nav-link btn btn-link text-start w-100">
                <i class="fa fa-sign-out"></i> Logout
            </button>
        </form>
    </div>
</nav>

