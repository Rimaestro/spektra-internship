<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'SPEKTRA') }} - @yield('title', 'Sistem PKL Terintegrasi Akademia')</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Styles -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #f8f9fa;
        }
        
        .sidebar {
            min-height: calc(100vh - 56px);
            background-color: #343a40;
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
        }
        
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.75);
            padding: 0.5rem 1rem;
            border-radius: 0.25rem;
            margin-bottom: 0.25rem;
        }
        
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background-color: rgba(255, 255, 255, 0.1);
            color: #fff;
        }
        
        .sidebar .nav-link i {
            margin-right: 0.5rem;
        }
        
        .sidebar-heading {
            font-size: 0.75rem;
            text-transform: uppercase;
            color: rgba(255, 255, 255, 0.5);
            padding: 0.5rem 1rem;
            font-weight: 600;
            margin-top: 1rem;
        }
        
        .main-content {
            padding: 1.5rem;
        }
        
        .navbar-brand {
            font-weight: 700;
        }
        
        .navbar-dark {
            background-color: #212529;
        }
        
        .dropdown-item i {
            margin-right: 0.5rem;
            width: 1rem;
            display: inline-block;
            text-align: center;
        }
        
        .card {
            box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            margin-bottom: 1.5rem;
        }
        
        .card-header {
            background-color: #f8f9fa;
            border-bottom: 1px solid rgba(0, 0, 0, 0.125);
            font-weight: 600;
        }
        
        .alert {
            margin-bottom: 1rem;
        }
        
        .footer {
            padding: 1rem 0;
            border-top: 1px solid #e9ecef;
            background-color: #fff;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>
    <div id="app">
        <!-- Header Navbar -->
        @include('layouts.partials.navbar')
        
        <div class="container-fluid">
            <div class="row">
                <!-- Sidebar -->
                @auth
                    <div class="col-md-3 col-lg-2 d-md-block sidebar collapse">
                        @include('layouts.partials.sidebar')
                    </div>
                    
                    <!-- Main Content -->
                    <main class="col-md-9 ms-sm-auto col-lg-10 px-md-4 main-content">
                        <!-- Flash Messages -->
                        @include('layouts.partials.flash-messages')
                        
                        <!-- Page Header -->
                        <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pb-2 mb-3 border-bottom">
                            <h1 class="h2">@yield('header', 'Dashboard')</h1>
                            <div class="btn-toolbar mb-2 mb-md-0">
                                @yield('header_buttons')
                            </div>
                        </div>
                        
                        <!-- Content -->
                        @yield('content')
                    </main>
                @else
                    <main class="col-md-12 ms-sm-auto px-md-4 main-content">
                        <!-- Flash Messages -->
                        @include('layouts.partials.flash-messages')
                        
                        <!-- Content -->
                        @yield('content')
                    </main>
                @endauth
            </div>
        </div>
        
        <!-- Footer -->
        @include('layouts.partials.footer')
    </div>
    
    <!-- Bootstrap 5 JS Bundle with Popper.js -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Scripts -->
    <script src="{{ asset('js/app.js') }}" defer></script>
    
    <!-- Custom Scripts -->
    @stack('scripts')
    
    <script>
        // Enable Bootstrap tooltips
        document.addEventListener('DOMContentLoaded', function() {
            var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
            var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl)
            });
            
            // Enable Bootstrap popovers
            var popoverTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="popover"]'))
            var popoverList = popoverTriggerList.map(function (popoverTriggerEl) {
                return new bootstrap.Popover(popoverTriggerEl)
            });
            
            // Auto-close alerts after 5 seconds
            setTimeout(function() {
                document.querySelectorAll('.alert-dismissible').forEach(function(alert) {
                    var bsAlert = new bootstrap.Alert(alert);
                    bsAlert.close();
                });
            }, 5000);
        });
    </script>
</body>
</html>