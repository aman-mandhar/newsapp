@php
    use Illuminate\Support\Facades\Auth;
    use App\Models\UserRole;
    use App\Models\User;

    $current = User::find(Auth::user()->id);
    $role = UserRole::find($current->user_role_id);
    $picture = $current->profile_image ? asset($current->profile_image) : asset('dashboard/dist/img/my-avatar.png');
@endphp

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard')</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    @livewireStyles

    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
        }
        .navbar-custom {
            background-color: #eef970;
        }
        .main-wrapper {
            display: flex;
        }

        /* Sidebar (left side) */
        .sidebar {
            background-color: #222;
            min-height: 100vh;
            color: #fff;
            width: 220px;   /* fix width for sidebar */
            flex-shrink: 0; /* prevent shrinking */
        }

        /* Content Area (right side) */
        .content {
            flex: 1;         /* take remaining space */
            width: auto;    /* prevent overflow */
            padding: 20px;
        }

        .sidebar a {
            color: #ccc;
            text-decoration: none;
            display: block;
            padding: 10px 15px;
        }
        .sidebar a:hover,
        .sidebar a.active {
            background-color: #ff6600;
            color: #fff;
        }

        /* Mobile sidebar styles */
        @media (max-width: 991px) {
            .sidebar {
                position: fixed;
                top: 0;
                left: -250px;
                width: 250px;
                height: 100vh;
                z-index: 1000;
                transition: left 0.3s ease;
                overflow-y: auto;
            }

            .sidebar.show {
                left: 0;
            }

            .sidebar-backdrop {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.5);
                z-index: 999;
                display: none;
            }

            .sidebar-backdrop.show {
                display: block;
            }
        }
    </style>

    @stack('styles')
</head>
<body>

    @include('layouts.dashboard.admin.nav')
    <div class="container-fluid">
        <div class="row">
            @include('layouts.dashboard.admin.side')
            <main class="col-lg-10 col-md-9 ms-sm-auto px-md-4 py-4">
                @yield('content')
            </main>
        </div>
    </div>


    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @livewireScripts

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const sidebarToggle = document.getElementById('sidebarToggle');
            const sidebar = document.getElementById('sidebarMenu');

            if (sidebarToggle && sidebar) {
                // Create backdrop element
                const backdrop = document.createElement('div');
                backdrop.className = 'sidebar-backdrop';
                backdrop.id = 'sidebarBackdrop';
                document.body.appendChild(backdrop);

                // Toggle sidebar
                sidebarToggle.addEventListener('click', function() {
                    sidebar.classList.toggle('show');
                    backdrop.classList.toggle('show');
                    document.body.style.overflow = sidebar.classList.contains('show') ? 'hidden' : '';
                });

                // Close sidebar when clicking backdrop
                backdrop.addEventListener('click', function() {
                    sidebar.classList.remove('show');
                    backdrop.classList.remove('show');
                    document.body.style.overflow = '';
                });
            }
        });
    </script>

    @stack('scripts')
</body>
</html>
