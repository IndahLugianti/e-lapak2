<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'E-Lapak Konut')</title>

    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('storage/logo-kemenag.png') }}">
    <link rel="shortcut icon" type="image/png" href="{{ asset('storage/logo-kemenag.png') }}">
    <link rel="apple-touch-icon" href="{{ asset('storage/logo-kemenag.png') }}">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        :root {
            --primary-color: #065f46;
            --primary-dark: #064e3b;
            --primary-light: #059669;
            --primary-soft: #d1fae5;
            --primary-transparent: rgba(6, 95, 70, 0.8);
            --primary-transparent-light: rgba(16, 185, 129, 0.6);
            --secondary-color: #64748b;
            --success-color: #10b981;
            --warning-color: #f59e0b;
            --danger-color: #ef4444;
            --dark-color: #1f2937;
        }

        body {
            background-color: #f8fafc;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar-brand {
            font-weight: 700;
            color: var(--primary-color) !important;
        }

        .sidebar {
            min-height: calc(100vh - 56px);
            background: linear-gradient(135deg, 
                var(--primary-transparent) 0%, 
                var(--primary-color) 40%, 
                var(--primary-dark) 100%);
            backdrop-filter: blur(15px);
            box-shadow: 2px 0 15px rgba(6, 95, 70, 0.15);
            border-right: 1px solid rgba(255,255,255,0.15);
        }

        .sidebar .nav-link {
            color: rgba(255,255,255,0.95);
            border-radius: 12px;
            margin: 4px 8px;
            padding: 14px 18px;
            transition: all 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
            position: relative;
            overflow: hidden;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .sidebar .nav-link:before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            height: 100%;
            width: 4px;
            background: rgba(255,255,255,0.9);
            transform: scaleY(0);
            transition: transform 0.3s ease;
            border-radius: 0 4px 4px 0;
        }

        .sidebar .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.2);
            transform: translateX(8px) scale(1.02);
            box-shadow: 0 8px 25px rgba(0,0,0,0.3);
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .sidebar .nav-link:hover:before {
            transform: scaleY(1);
        }

        .sidebar .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.25);
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            font-weight: 700;
            text-shadow: 0 1px 3px rgba(0,0,0,0.3);
        }

        .sidebar .nav-link.active:before {
            transform: scaleY(1);
        }

        .main-content {
            padding: 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.08);
            transition: transform 0.2s ease, box-shadow 0.2s ease;
        }

        .card:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 20px rgba(0,0,0,0.12);
        }

        .card-header {
            background: linear-gradient(135deg, 
                var(--primary-transparent) 0%, 
                var(--primary-color) 50%, 
                var(--primary-dark) 100%);
            color: white;
            border-radius: 12px 12px 0 0 !important;
            font-weight: 600;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
        }

        .btn-primary {
            background: linear-gradient(135deg, 
                var(--primary-transparent) 0%, 
                var(--primary-color) 40%, 
                var(--primary-dark) 100%);
            border: none;
            border-radius: 8px;
            font-weight: 600;
            color: white;
            text-shadow: 0 1px 2px rgba(0,0,0,0.2);
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 15px rgba(6, 95, 70, 0.3);
            background: linear-gradient(135deg, 
                var(--primary-color) 0%, 
                var(--primary-dark) 50%, 
                #064e3b 100%);
            color: white;
        }

        .badge {
            border-radius: 6px;
            font-weight: 500;
        }

        .badge-primary { background-color: var(--primary-color); }
        .badge-success { background-color: var(--success-color); }
        .badge-warning { background-color: var(--warning-color); }
        .badge-danger { background-color: var(--danger-color); }
        .badge-info { background-color: #0ea5e9; }
        .badge-secondary { background-color: var(--secondary-color); }
        .badge-dark { background-color: var(--dark-color); }

        .stats-card {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border-radius: 12px;
        }

        .stats-card .stats-number {
            font-size: 2.5rem;
            font-weight: 700;
        }

        .footer {
            background-color: var(--dark-color);
            color: white;
            padding: 20px 0;
            margin-top: 40px;
        }

        .alert {
            border: none;
            border-radius: 8px;
            border-left: 4px solid;
        }

        .alert-success { border-left-color: var(--success-color); }
        .alert-danger { border-left-color: var(--danger-color); }
        .alert-warning { border-left-color: var(--warning-color); }
        .alert-info { border-left-color: #0ea5e9; }

        .table th {
            background-color: #f1f5f9;
            font-weight: 600;
            color: var(--dark-color);
            border: none;
        }

        .table td {
            border-color: #e2e8f0;
            vertical-align: middle;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 4px 20px rgba(0,0,0,0.1);
            border-radius: 8px;
        }

        .user-avatar {
            width: 32px;
            height: 32px;
            border-radius: 50%;
            background: linear-gradient(135deg, 
                var(--primary-transparent) 0%, 
                var(--primary-color) 50%, 
                var(--primary-dark) 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 700;
            text-shadow: 0 1px 2px rgba(0,0,0,0.3);
        }
    </style>

    @stack('styles')
</head>
<body>
    <!-- Header -->
    @include('layouts.header')

    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            @auth
                @include('layouts.sidebar')
            @endauth

            <!-- Main Content -->
            <main class="@auth col-md-9 ms-sm-auto col-lg-10 @else col-12 @endauth px-md-4 main-content">
                <!-- Alert Messages -->
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i>
                        {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i>
                        {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('warning'))
                    <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        {{ session('warning') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </main>
        </div>
    </div>

    <!-- Footer -->
    @include('layouts.footer')

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

    @stack('scripts')
</body>
</html>
