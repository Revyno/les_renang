<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Tirta Nirwana</title>
    <!-- CSS Libraries -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
            --primary-color: #0099cc;
            --secondary-color: #f8f9fa;
        }
        
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #f5f6fa;
        }
        
        #sidebar {
            position: fixed;
            width: var(--sidebar-width);
            height: 100vh;
            background-color: #343a40;
            color: white;
            transition: all 0.3s;
            z-index: 999;
        }
        
        #sidebar .sidebar-header {
            padding: 20px;
            background-color: #2c3035;
        }
        
        #sidebar ul li {
            padding: 10px 0;
        }
        
        #sidebar ul li a {
            padding: 10px 20px;
            color: rgba(255, 255, 255, 0.8);
            display: block;
            text-decoration: none;
            transition: all 0.3s;
        }
        
        #sidebar ul li a:hover, 
        #sidebar ul li a.active {
            color: white;
            background-color: rgba(255, 255, 255, 0.1);
        }
        
        #sidebar ul li a i {
            margin-right: 10px;
        }
        
        #content {
            margin-left: var(--sidebar-width);
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        
        .top-navbar {
            height: var(--topbar-height);
            background-color: white;
            box-shadow: 0 2px 5px rgba(0,0,0,0.05);
            padding: 0 20px;
            display: flex;
            align-items: center;
            position: sticky;
            top: 0;
            z-index: 99;
        }
        
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 20px;
        }
        
        .card-header {
            background-color: white;
            border-bottom: 1px solid #eee;
            padding: 15px 20px;
            font-weight: 600;
        }
        
        .btn-primary {
            background-color: var(--primary-color);
            border-color: var(--primary-color);
        }
        
        .btn-primary:hover {
            background-color: #007ba3;
            border-color: #007ba3;
        }
        
        .stat-card {
            padding: 20px;
            text-align: center;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s ease;
        }
        
        .stat-card:hover {
            transform: translateY(-5px);
        }
        
        .stat-card i {
            font-size: 30px;
            margin-bottom: 10px;
        }
        
        .stat-card .stat-count {
            font-size: 24px;
            font-weight: 600;
        }
        
        .stat-card .stat-label {
            font-size: 14px;
            color: #6c757d;
        }
        
        .bg-info {
            background-color: var(--primary-color) !important;
            color: white;
        }
    </style>
</head>
<body>
    <div class="wrapper">
        <!-- Sidebar -->
        <nav id="sidebar">
            <div class="sidebar-header">
                <h5>Tirta Nirwana</h5>
                <p class="mb-0">Admin Dashboard</p>
            </div>
            <ul class="list-unstyled">
                <li>
                    <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                        <i class="fas fa-tachometer-alt"></i> Dashboard
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.registrations.index') }}" class="{{ request()->routeIs('admin.registrations*') ? 'active' : '' }}">
                        <i class="fas fa-user-plus"></i> Pendaftaran
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.programs.index') }}" class="{{ request()->routeIs('admin.programs*') ? 'active' : '' }}">
                        <i class="fas fa-book"></i> Program
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.schedules.index') }}" class="{{ request()->routeIs('admin.schedules*') ? 'active' : '' }}">
                        <i class="fas fa-calendar-alt"></i> Jadwal
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.instructors.index') }}" class="{{ request()->routeIs('admin.instructors*') ? 'active' : '' }}">
                        <i class="fas fa-user-tie"></i> Instruktur
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.reports.index') }}" class="{{ request()->routeIs('admin.reports*') ? 'active' : '' }}">
                        <i class="fas fa-chart-bar"></i> Laporan
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                        <i class="fas fa-cog"></i> Pengaturan
                    </a>
                </li>
                <li>
                    <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt"></i> Keluar
                    </a>
                    <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                        @csrf
                    </form>
                </li>
            </ul>
        </nav>

        <!-- Content -->
        <div id="content">
            <nav class="top-navbar">
                <div class="container-fluid">
                    <div class="d-flex justify-content-between w-100">
                        <div>
                            <h5 class="mb-0">@yield('title', 'Dashboard')</h5>
                        </div>
                        <div class="dropdown">
                            <a class="dropdown-toggle text-decoration-none text-dark" href="#" role="button" id="userDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                <img src="https://via.placeholder.com/30" alt="User" class="rounded-circle me-2" width="30">
                                {{ Auth::user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="userDropdown">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user-circle me-2"></i> Profil</a></li>
                                <li><a class="dropdown-item" href="#"><i class="fas fa-cog me-2"></i> Pengaturan</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i> Keluar
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <div class="container-fluid py-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/chart.js/3.7.0/chart.min.js"></script>
    @yield('scripts')
</body>
</html>
