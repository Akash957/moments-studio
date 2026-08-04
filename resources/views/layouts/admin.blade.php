<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') | Moments Studio Admin</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">
    <!-- AdminLTE 3 Theme style -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/css/adminlte.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.6/css/dataTables.bootstrap4.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/responsive/2.5.0/css/responsive.bootstrap4.min.css">
    <!-- SweetAlert2 -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">

    <style>
        .brand-link { background-color: #050507 !important; border-bottom: 1px solid rgba(201, 169, 110, 0.25) !important; }
        .main-sidebar { 
            background-color: #0c0c0e !important; 
            background-image: linear-gradient(rgba(10, 10, 12, 0.88), rgba(10, 10, 12, 0.94)), url("{{ asset('assets/images/admin-bg.jpg') }}") !important;
            background-size: cover !important;
            background-position: center !important;
        }
        .sidebar-dark-primary .nav-sidebar>.nav-item>.nav-link.active { background-color: #c9a96e !important; color: #000 !important; }
        .text-gold { color: #c9a96e !important; }
        .bg-gold { background-color: #c9a96e !important; color: #000 !important; }
        .btn-gold { background-color: #c9a96e; color: #000; font-weight: 600; }
        .btn-gold:hover { background-color: #e8c98a; color: #000; }
    </style>
    @stack('css')
</head>
<body class="hold-transition sidebar-mini layout-fixed layout-navbar-fixed">
<div class="wrapper">

    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-dark navbar-black">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="{{ url('/') }}" target="_blank" class="nav-link"><i class="fas fa-globe me-1"></i> View Website</a>
            </li>
        </ul>

        <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-user me-1"></i> {{ auth()->user()->name ?? 'Admin' }}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <a href="{{ route('admin.profile.index') }}" class="dropdown-item">
                        <i class="fas fa-user-cog mr-2"></i> My Profile
                    </a>
                    <a href="{{ route('admin.settings.index') }}" class="dropdown-item">
                        <i class="fas fa-cogs mr-2"></i> Studio Settings
                    </a>
                    <div class="dropdown-divider"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="dropdown-item text-danger">
                            <i class="fas fa-sign-out-alt mr-2"></i> Logout
                        </button>
                    </form>
                </div>
            </li>
        </ul>
    </nav>

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="{{ route('admin.dashboard') }}" class="brand-link d-flex align-items-center">
            <img src="{{ \App\Models\Setting::get('site_logo', asset('assets/images/logo.png')) }}" alt="{{ \App\Models\Setting::get('site_name', 'Moments Studio') }}" class="brand-image img-circle elevation-3" style="opacity:.9;height:38px;width:38px;object-fit:cover;border:1px solid #c9a96e;" onerror="this.style.display='none'">
            <span class="brand-text font-weight-light text-gold ml-2" style="font-family:serif;font-size:1.2rem;">
                <strong>{{ \App\Models\Setting::get('site_name', 'Moments Studio') }}</strong> Admin
            </span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
            <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    
                    <li class="nav-item">
                        <a href="{{ route('admin.dashboard') }}" class="nav-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>Dashboard</p>
                        </a>
                    </li>

                    <li class="nav-header">BOOKINGS & ENQUIRIES</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.bookings.index') }}" class="nav-link {{ request()->routeIs('admin.bookings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-calendar-check"></i>
                            <p>Bookings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.enquiries.index') }}" class="nav-link {{ request()->routeIs('admin.enquiries*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope"></i>
                            <p>Enquiries</p>
                        </a>
                    </li>

                    <li class="nav-header">CONTENT MANAGEMENT</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.sliders.index') }}" class="nav-link {{ request()->routeIs('admin.sliders*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Hero Sliders</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.about.index') }}" class="nav-link {{ request()->routeIs('admin.about*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-address-card"></i>
                            <p>About Us Section</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.services.index') }}" class="nav-link {{ request()->routeIs('admin.services*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-camera"></i>
                            <p>Services</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.service-categories.index') }}" class="nav-link {{ request()->routeIs('admin.service-categories*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tags"></i>
                            <p>Service Categories</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.gallery.index') }}" class="nav-link {{ request()->routeIs('admin.gallery*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-images"></i>
                            <p>Gallery Portfolio</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.albums.index') }}" class="nav-link {{ request()->routeIs('admin.albums*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-book-open"></i>
                            <p>Albums</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.packages.index') }}" class="nav-link {{ request()->routeIs('admin.packages*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-box"></i>
                            <p>Packages</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.blogs.index') }}" class="nav-link {{ request()->routeIs('admin.blogs*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-newspaper"></i>
                            <p>Blog Posts</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.testimonials.index') }}" class="nav-link {{ request()->routeIs('admin.testimonials*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-star"></i>
                            <p>Testimonials</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.awards.index') }}" class="nav-link {{ request()->routeIs('admin.awards*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-award"></i>
                            <p>Awards & Honors</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.team.index') }}" class="nav-link {{ request()->routeIs('admin.team*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-users"></i>
                            <p>Our Team Members</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.videos.index') }}" class="nav-link {{ request()->routeIs('admin.videos*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-video"></i>
                            <p>Cinematic Videos</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.instagram-feeds.index') }}" class="nav-link {{ request()->routeIs('admin.instagram-feeds*') ? 'active' : '' }}">
                            <i class="nav-icon fab fa-instagram"></i>
                            <p>Instagram Feed</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.faqs.index') }}" class="nav-link {{ request()->routeIs('admin.faqs*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-question-circle"></i>
                            <p>FAQ Management</p>
                        </a>
                    </li>

                    <li class="nav-header">SYSTEM & SETTINGS</li>
                    <li class="nav-item">
                        <a href="{{ route('admin.settings.index') }}" class="nav-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-sliders-h"></i>
                            <p>Studio Settings</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.seo.index') }}" class="nav-link {{ request()->routeIs('admin.seo*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-search"></i>
                            <p>SEO Meta Data</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.media.index') }}" class="nav-link {{ request()->routeIs('admin.media*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-folder-open"></i>
                            <p>Media Manager</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.newsletter.index') }}" class="nav-link {{ request()->routeIs('admin.newsletter*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-envelope-open-text"></i>
                            <p>Newsletter List</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.users.index') }}" class="nav-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-shield"></i>
                            <p>Admin Users</p>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a href="{{ route('admin.roles.index') }}" class="nav-link {{ request()->routeIs('admin.roles*') ? 'active' : '' }}">
                            <i class="nav-icon fas fa-user-lock"></i>
                            <p>Roles & Permissions</p>
                        </a>
                    </li>

                </ul>
            </nav>
        </div>
    </aside>

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <div class="content-header">
            <div class="container-fluid">
                <div class="row mb-2">
                    <div class="col-sm-6">
                        <h1 class="m-0">@yield('page_title', 'Dashboard')</h1>
                    </div>
                </div>
            </div>
        </div>

        <!-- Main content -->
        <section class="content">
            <div class="container-fluid">
                @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle mr-2"></i> {{ session('success') }}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                @endif

                @yield('content')
            </div>
        </section>
    </div>

    <!-- Main Footer -->
    <footer class="main-footer">
        <div class="float-right d-none d-sm-inline">
            Version 1.0.0
        </div>
        <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/') }}" class="text-gold">{{ \App\Models\Setting::get('site_name', 'Moments Studio') }}</a>.</strong> All rights reserved.
    </footer>
</div>

<!-- REQUIRED SCRIPTS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/admin-lte@3.2/dist/js/adminlte.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.13.6/js/dataTables.bootstrap4.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function () {
        // Intercept all delete forms across Admin Panel with luxury SweetAlert2 Modal
        $(document).on('submit', 'form.delete-form, form[action*="destroy"]', function (e) {
            var form = this;
            if ($(form).data('confirmed')) {
                return true;
            }
            e.preventDefault();

            Swal.fire({
                title: 'Are you sure?',
                text: 'Do you really want to delete this item? This action cannot be undone.',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#dc3545',
                cancelButtonColor: '#4a4a4a',
                confirmButtonText: '<i class="fas fa-trash-alt mr-1"></i> Yes, Delete',
                cancelButtonText: 'Cancel',
                background: '#1f1f1f',
                color: '#ffffff',
                customClass: {
                    popup: 'border border-warning shadow-lg',
                    title: 'text-warning font-weight-bold'
                }
            }).then((result) => {
                if (result.isConfirmed) {
                    $(form).data('confirmed', true);
                    form.submit();
                }
            });
        });
    });
</script>

@stack('js')
</body>
</html>
