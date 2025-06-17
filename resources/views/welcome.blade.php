<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SPEKTRA - Sistem PKL Terintegrasi Akademia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Space+Grotesk:wght@300;400;500;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        
        <!-- AOS - Animate On Scroll -->
        <link rel="stylesheet" href="https://unpkg.com/aos@next/dist/aos.css" />
        
        <!-- Styles -->
        <style>
            :root {
                --primary-color: #6A40B5;
                --primary-dark: #5835A0;
                --primary-light: #8C6BC8;
                --accent-color: #4C9CFF;
                --accent-light: #7CB5FF;
                --text-color: #212529;
                --text-light: #6c757d;
                --bg-color: #F2F0FF;
                --card-shadow: 0 10px 30px rgba(106, 64, 181, 0.15);
                --glass-bg: rgba(255, 255, 255, 0.7);
                --glass-border: rgba(255, 255, 255, 0.18);
                --glass-shadow: 0 8px 32px rgba(106, 64, 181, 0.2);
                --transition-fast: all 0.3s ease;
                --transition-medium: all 0.5s ease;
                --transition-slow: all 0.8s ease;
            }
            
            body {
                font-family: 'Inter', sans-serif;
                background-color: var(--bg-color);
                overflow-x: hidden;
            }
            
            h1, h2, h3, h4, h5, h6 {
                font-family: 'Space Grotesk', sans-serif;
                letter-spacing: -0.03em;
            }
            
            .bg-hero {
                background: linear-gradient(135deg, #6A40B5 0%, #4C9CFF 100%);
                color: white;
                padding: 6rem 0;
                position: relative;
                overflow: hidden;
            }
            
            .bg-hero::before {
                content: '';
                position: absolute;
                width: 200%;
                height: 200%;
                top: -50%;
                left: -50%;
                background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, rgba(255,255,255,0) 70%);
                animation: rotate 60s linear infinite;
            }
            
            @keyframes rotate {
                from { transform: rotate(0deg); }
                to { transform: rotate(360deg); }
            }
            
            .hero-image {
                max-width: 90%;
                height: auto;
                filter: drop-shadow(0 15px 25px rgba(0, 0, 0, 0.25));
                transition: var(--transition-medium);
                animation: float 6s ease-in-out infinite;
                transform-origin: center center;
            }
            
            @keyframes float {
                0% {
                    transform: translateY(0px);
                }
                50% {
                    transform: translateY(-15px);
                }
                100% {
                    transform: translateY(0px);
                }
            }
            
            .hero-image:hover {
                transform: translateY(-10px) scale(1.03);
            }
            
            .hero-content {
                background: rgba(255, 255, 255, 0.1);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid rgba(255, 255, 255, 0.18);
                border-radius: 15px;
                padding: 2rem;
                box-shadow: 0 8px 32px rgba(31, 38, 135, 0.2);
                position: relative;
                z-index: 2;
            }
            
            .hero-shape {
                position: absolute;
                border-radius: 50%;
                filter: blur(50px);
                z-index: 0;
            }
            
            .hero-shape-1 {
                width: 300px;
                height: 300px;
                background: rgba(106, 64, 181, 0.4);
                top: -100px;
                right: 10%;
            }
            
            .hero-shape-2 {
                width: 200px;
                height: 200px;
                background: rgba(76, 156, 255, 0.3);
                bottom: -50px;
                left: 15%;
            }
            
            .hero-shape-3 {
                width: 150px;
                height: 150px;
                background: rgba(255, 114, 94, 0.2);
                top: 40%;
                left: 5%;
            }
            
            @media (max-width: 991.98px) {
                .hero-content {
                    margin-bottom: 3rem;
                }
                
                .hero-image {
                    max-width: 80%;
                    margin: 0 auto;
                }
            }
            
            /* Fallback for browsers that don't support backdrop-filter */
            @supports not ((backdrop-filter: blur(10px)) or (-webkit-backdrop-filter: blur(10px))) {
                .hero-content {
                    background: rgba(106, 64, 181, 0.8);
                }
            }
            
            /* Glassmorphism effect */
            .glass-card {
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border-radius: 15px;
                border: 1px solid var(--glass-border);
                box-shadow: var(--glass-shadow);
                transition: var(--transition-fast);
            }
            
            .glass-card:hover {
                transform: translateY(-5px);
                box-shadow: 0 15px 35px rgba(31, 38, 135, 0.3);
            }
            
            .icon-box {
                text-align: center;
                padding: 2.5rem 2rem;
                border-radius: 15px;
                box-shadow: var(--card-shadow);
                transition: var(--transition-fast);
                background-color: white;
                height: 100%;
                position: relative;
                z-index: 1;
                overflow: hidden;
            }
            
            .icon-box::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: linear-gradient(135deg, var(--accent-color) 0%, var(--primary-color) 100%);
                opacity: 0;
                z-index: -1;
                transition: var(--transition-medium);
            }
            
            .icon-box:hover {
                transform: translateY(-10px);
                color: white;
            }
            
            .icon-box:hover::before {
                opacity: 1;
            }
            
            .icon-box:hover i,
            .icon-box:hover h4,
            .icon-box:hover p {
                color: white;
            }
            
            .icon-box i {
                font-size: 3.5rem;
                margin-bottom: 1.5rem;
                color: var(--primary-color);
                transition: var(--transition-fast);
            }
            
            .navbar {
                background: rgba(242, 240, 255, 0.8) !important;
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                box-shadow: 0 4px 30px rgba(106, 64, 181, 0.1);
                border-bottom: 1px solid rgba(106, 64, 181, 0.1);
                transition: var(--transition-fast);
            }
            
            .navbar.scrolled {
                padding-top: 0.5rem;
                padding-bottom: 0.5rem;
                background: rgba(242, 240, 255, 0.95) !important;
            }
            
            .features {
                padding: 5rem 0;
            }
            
            .btn {
                position: relative;
                overflow: hidden;
                transition: var(--transition-fast);
                z-index: 1;
            }
            
            .btn::after {
                content: '';
                position: absolute;
                top: 50%;
                left: 50%;
                width: 0;
                height: 0;
                background: rgba(255, 255, 255, 0.2);
                border-radius: 50%;
                transform: translate(-50%, -50%);
                transition: width 0.5s, height 0.5s;
                z-index: -1;
            }
            
            .btn:active::after {
                width: 300px;
                height: 300px;
            }
            
            .btn:hover {
                transform: translateY(-3px);
                box-shadow: 0 10px 20px rgba(0, 0, 0, 0.1);
            }
            
            .footer {
                background-color: #2D1A4A;
                color: white;
                padding: 3rem 0;
            }
            
            .footer a {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
                transition: var(--transition-fast);
            }
            
            .footer a:hover {
                color: white;
                transform: translateX(5px);
            }
            
            .stats-box {
                text-align: center;
                padding: 2.5rem 2rem;
                border-radius: 15px;
                box-shadow: var(--card-shadow);
                margin-bottom: 1rem;
                position: relative;
                overflow: hidden;
                z-index: 1;
                background: var(--glass-bg);
                backdrop-filter: blur(10px);
                -webkit-backdrop-filter: blur(10px);
                border: 1px solid var(--glass-border);
            }
            
            .stats-box::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
                transform: rotate(45deg);
                z-index: -1;
                transition: var(--transition-slow);
            }
            
            .stats-box:hover::before {
                animation: shine 1.5s;
            }
            
            @keyframes shine {
                0% { left: -50%; }
                100% { left: 150%; }
            }
            
            .stats-box h2 {
                font-size: 3.5rem;
                font-weight: 700;
                color: var(--primary-color);
                margin-bottom: 0.5rem;
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
            }
            
            .stats-box p {
                font-size: 1.1rem;
                color: var(--text-light);
                margin-bottom: 0;
            }
            
            .cta-section {
                background: linear-gradient(135deg, #F2F0FF 0%, #E5E0FF 100%);
                padding: 5rem 0;
                position: relative;
                overflow: hidden;
            }
            
            .cta-section::before {
                content: '';
                position: absolute;
                width: 100%;
                height: 100%;
                top: 0;
                left: 0;
                background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zm60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%236A40B5' fill-opacity='0.05' fill-rule='evenodd'/%3E%3C/svg%3E");
                opacity: 0.5;
            }
            
            /* Custom cursor effect */
            .custom-cursor {
                position: fixed;
                width: 20px;
                height: 20px;
                border-radius: 50%;
                background-color: rgba(106, 64, 181, 0.5);
                pointer-events: none;
                z-index: 9999;
                transform: translate(-50%, -50%);
                transition: width 0.2s, height 0.2s, background-color 0.2s;
                mix-blend-mode: difference;
            }
            
            .custom-cursor.expanded {
                width: 40px;
                height: 40px;
                background-color: rgba(106, 64, 181, 0.3);
            }
            
            /* Scroll animations */
            .scroll-reveal {
                opacity: 0;
                transform: translateY(20px);
                transition: var(--transition-medium);
            }
            
            .scroll-reveal.animate {
                opacity: 1;
                transform: translateY(0);
            }
            
            /* Custom scrollbar */
            ::-webkit-scrollbar {
                width: 10px;
            }
            
            ::-webkit-scrollbar-track {
                background: #F2F0FF;
            }
            
            ::-webkit-scrollbar-thumb {
                background: var(--primary-color);
                border-radius: 5px;
            }
            
            ::-webkit-scrollbar-thumb:hover {
                background: var(--primary-dark);
            }
            
            /* Social buttons */
            .social-btn {
                width: 45px;
                height: 45px;
                display: flex;
                align-items: center;
                justify-content: center;
                transition: var(--transition-fast);
                position: relative;
                overflow: hidden;
                z-index: 1;
            }
            
            .social-btn::before {
                content: '';
                position: absolute;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: var(--primary-color);
                transform: scale(0);
                transition: var(--transition-fast);
                border-radius: 50%;
                z-index: -1;
            }
            
            .social-btn:hover {
                color: white;
                border-color: var(--primary-color);
                transform: translateY(-5px);
            }
            
            .social-btn:hover::before {
                transform: scale(1);
            }
            
            /* Contact info cards */
            .contact-info {
                text-align: center;
                height: 100%;
                transition: var(--transition-fast);
            }
            
            .contact-info:hover {
                transform: translateY(-10px);
            }
            
            /* Footer links */
            .footer-link {
                display: inline-flex;
                align-items: center;
                transition: var(--transition-fast);
            }
            
            .footer-link i {
                opacity: 0;
                transform: translateX(-10px);
                transition: var(--transition-fast);
            }
            
            .footer-link:hover i {
                opacity: 1;
                transform: translateX(0);
            }
            
            /* Features grid */
            .features-grid {
                position: relative;
            }
            
            @media (min-width: 992px) {
                .features-grid .col-lg-4:nth-child(3n+1) .icon-box {
                    transform: translateY(20px);
                }
                
                .features-grid .col-lg-4:nth-child(3n+3) .icon-box {
                    transform: translateY(-20px);
                }
            }
            
            .py-5.bg-light {
                background-color: var(--bg-color) !important;
            }
            
            /* Override Bootstrap button colors */
            .btn-primary {
                background-color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-primary:hover,
            .btn-primary:focus,
            .btn-primary:active {
                background-color: var(--primary-dark) !important;
                border-color: var(--primary-dark) !important;
            }
            
            .btn-outline-primary {
                color: var(--primary-color);
                border-color: var(--primary-color);
            }
            
            .btn-outline-primary:hover,
            .btn-outline-primary:focus,
            .btn-outline-primary:active {
                background-color: var(--primary-color) !important;
                border-color: var(--primary-color) !important;
            }
            
            .btn-light {
                color: var(--primary-color);
            }
            
            .btn-outline-light:hover {
                color: var(--primary-color);
            }
            
            .text-primary {
                color: var(--primary-color) !important;
            }
            
            .contact-info i {
                color: var(--primary-color) !important;
            }
            
            .nav-link.active {
                color: var(--primary-color) !important;
                font-weight: 500;
            }
            
            .nav-link:hover {
                color: var(--primary-color) !important;
            }
            
            /* Logo container */
            .logo-container {
                display: flex;
                align-items: center;
            }
            
            /* Navbar logo styling */
            .navbar-logo {
                display: flex;
                align-items: center;
                justify-content: center;
                margin-right: 0.5rem;
                background: linear-gradient(135deg, rgba(106, 64, 181, 0.1) 0%, rgba(76, 156, 255, 0.1) 100%);
                padding: 6px;
                border-radius: 8px;
                border: 1px solid rgba(106, 64, 181, 0.1);
                box-shadow: 0 2px 8px rgba(106, 64, 181, 0.1);
                transition: var(--transition-fast);
                position: relative;
                overflow: hidden;
            }
            
            .navbar-logo::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(
                    to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0) 100%
                );
                transform: rotate(30deg);
                opacity: 0;
                transition: opacity 0.6s;
            }
            
            .navbar-logo:hover::before {
                opacity: 1;
                animation: shine 1.5s ease-in-out;
            }
            
            @keyframes shine {
                0% {
                    transform: translateX(-100%) rotate(30deg);
                }
                100% {
                    transform: translateX(100%) rotate(30deg);
                }
            }
            
            .navbar-logo:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(106, 64, 181, 0.2);
                background: linear-gradient(135deg, rgba(106, 64, 181, 0.15) 0%, rgba(76, 156, 255, 0.15) 100%);
            }
            
            /* Logo image styling */
            .logo-img {
                height: 40px;
                width: auto;
                object-fit: contain;
                transition: var(--transition-fast);
            }
            
            .navbar-logo:hover .logo-img {
                transform: scale(1.05);
            }
            
            /* Text logo styling */
            .navbar-brand span {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 700;
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
                color: transparent;
                transition: var(--transition-medium);
                position: relative;
            }
            
            .navbar-brand:hover span {
                animation: pulse 1.5s infinite;
            }
            
            @keyframes pulse {
                0% {
                    transform: scale(1);
                }
                50% {
                    transform: scale(1.05);
                }
                100% {
                    transform: scale(1);
                }
            }
            
            /* Text logo styling as fallback */
            .text-logo {
                font-family: 'Space Grotesk', sans-serif;
                font-weight: 700;
                font-size: 1.6rem;
                background: linear-gradient(135deg, var(--primary-color) 0%, var(--accent-color) 100%);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                margin-right: 0.5rem;
                display: none;
            }
            
            /* Show text logo if image fails to load */
            .navbar-logo.error + .text-logo {
                display: block;
            }
            
            /* Footer logo styling */
            .footer-logo {
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.1) 0%, rgba(255, 255, 255, 0.05) 100%);
                border: 1px solid rgba(255, 255, 255, 0.1);
                box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
                display: flex;
                align-items: center;
                justify-content: center;
                padding: 6px;
                border-radius: 8px;
                transition: var(--transition-fast);
                position: relative;
                overflow: hidden;
            }
            
            .footer-logo::before {
                content: '';
                position: absolute;
                top: -50%;
                left: -50%;
                width: 200%;
                height: 200%;
                background: linear-gradient(
                    to right,
                    rgba(255, 255, 255, 0) 0%,
                    rgba(255, 255, 255, 0.3) 50%,
                    rgba(255, 255, 255, 0) 100%
                );
                transform: rotate(30deg);
                opacity: 0;
                transition: opacity 0.6s;
            }
            
            .footer-logo:hover::before {
                opacity: 1;
                animation: shine 1.5s ease-in-out;
            }
            
            .footer-logo:hover {
                transform: translateY(-2px);
                box-shadow: 0 4px 12px rgba(255, 255, 255, 0.2);
                background: linear-gradient(135deg, rgba(255, 255, 255, 0.15) 0%, rgba(255, 255, 255, 0.05) 100%);
            }
            
            .footer-logo .logo-img {
                filter: brightness(0) invert(1);
                height: 40px;
                width: auto;
            }
            
            .footer-logo:hover .logo-img {
                transform: scale(1.05);
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-light fixed-top">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <span>SPEKTRA</span>
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto">
                        <li class="nav-item">
                            <a class="nav-link active" aria-current="page" href="#">Beranda</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#features">Fitur</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#about">Tentang</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="#contact">Kontak</a>
                        </li>
                    </ul>
                    <div class="d-flex">
                        @if (Route::has('login'))
                            <div>
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary me-2">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary me-2">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-primary">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-hero position-relative overflow-hidden">
            <!-- Decorative Shapes -->
            <div class="hero-shape hero-shape-1"></div>
            <div class="hero-shape hero-shape-2"></div>
            <div class="hero-shape hero-shape-3"></div>
            
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6" data-aos="fade-right" data-aos-duration="1000">
                        <div class="hero-content">
                            <h1 class="display-4 fw-bold mb-4">Sistem PKL Terintegrasi Akademia</h1>
                            <p class="lead mb-4">SPEKTRA adalah platform terintegrasi untuk pengelolaan Praktik Kerja Lapangan yang menghubungkan mahasiswa, dosen pembimbing, pembimbing lapangan, dan koordinator PKL dalam satu sistem yang efisien.</p>
                            <div class="d-grid gap-2 d-md-flex">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-light btn-lg px-4 me-md-2">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-light btn-lg px-4 me-md-2">Login</a>
                                    <a href="{{ route('register') }}" class="btn btn-outline-light btn-lg px-4">Register</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <img src="{{ asset('images/hero.png') }}" alt="SPEKTRA Hero" class="hero-image d-block mx-auto mt-5 mt-lg-0">
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="stats-box glass-card">
                            <h2 class="counter" data-target="20">0</h2>
                            <p>Perusahaan Mitra</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="stats-box glass-card">
                            <h2 class="counter" data-target="100">0</h2>
                            <p>Mahasiswa</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="stats-box glass-card">
                            <h2 class="counter" data-target="15">0</h2>
                            <p>Bidang PKL</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="stats-box glass-card">
                            <h2 class="counter" data-target="50">0</h2>
                            <p>PKL Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" id="features">
            <div class="container">
                <div class="text-center mb-5" data-aos="fade-up" data-aos-duration="800">
                    <h2 class="fw-bold">Fitur Utama SPEKTRA</h2>
                    <p class="lead text-muted">Pengalaman praktik kerja lapangan yang terintegrasi dan efisien</p>
                </div>
                <div class="row g-4 features-grid">
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="100">
                        <div class="icon-box">
                            <i class="bi bi-send-check"></i>
                            <h4 class="mb-3">Pengajuan PKL Online</h4>
                            <p class="text-muted">Mahasiswa dapat mengajukan PKL secara online dengan mudah dan melacak status pengajuan mereka secara real-time.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="200">
                        <div class="icon-box">
                            <i class="bi bi-journal-text"></i>
                            <h4 class="mb-3">Laporan Harian Digital</h4>
                            <p class="text-muted">Pencatatan aktivitas harian yang mudah dengan fitur verifikasi dari pembimbing dan dokumentasi foto.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="300">
                        <div class="icon-box">
                            <i class="bi bi-chat-dots"></i>
                            <h4 class="mb-3">Komunikasi Terintegrasi</h4>
                            <p class="text-muted">Komunikasi antara mahasiswa, dosen pembimbing, dan pembimbing lapangan dalam satu platform.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="400">
                        <div class="icon-box">
                            <i class="bi bi-graph-up"></i>
                            <h4 class="mb-3">Monitoring & Evaluasi</h4>
                            <p class="text-muted">Pemantauan progres PKL dengan dashboard komprehensif dan sistem evaluasi berbasis kompetensi.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="500">
                        <div class="icon-box">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <h4 class="mb-3">Pengelolaan Dokumen</h4>
                            <p class="text-muted">Pengelolaan surat pengantar, laporan, dan dokumen PKL lainnya secara digital.</p>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4" data-aos="fade-up" data-aos-duration="800" data-aos-delay="600">
                        <div class="icon-box">
                            <i class="bi bi-shield-check"></i>
                            <h4 class="mb-3">Multi-level Approval</h4>
                            <p class="text-muted">Sistem persetujuan bertingkat untuk pengajuan dan laporan PKL yang transparan.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- About Section -->
        <section class="py-5 bg-light" id="about">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6 mb-4 mb-lg-0" data-aos="fade-right" data-aos-duration="1000">
                        <img src="{{ asset('images/about-image.svg') }}" alt="Tentang SPEKTRA" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-6" data-aos="fade-left" data-aos-duration="1000" data-aos-delay="200">
                        <h2 class="fw-bold mb-4">Tentang SPEKTRA</h2>
                        <p class="mb-4">SPEKTRA (Sistem Praktek Kerja Terintegrasi Akademia) adalah platform inovatif yang dirancang untuk menyederhanakan dan mengoptimalkan proses Praktik Kerja Lapangan (PKL) di institusi pendidikan.</p>
                        <p class="mb-4">Dikembangkan dengan pendekatan modern dan berfokus pada pengalaman pengguna, SPEKTRA menghubungkan semua pemangku kepentingan dalam ekosistem PKL - mahasiswa, dosen pembimbing, pembimbing lapangan, dan koordinator PKL - dalam satu platform terpadu.</p>
                        <p>Dengan SPEKTRA, proses PKL menjadi lebih efisien, transparan, dan mudah dikelola, memungkinkan mahasiswa fokus pada pengalaman belajar mereka dan institusi pendidikan dapat memantau serta mengevaluasi PKL dengan lebih efektif.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Section -->
        <section class="cta-section">
            <div class="container text-center">
                <div class="row justify-content-center">
                    <div class="col-lg-8 col-md-10">
                        <div class="glass-card p-5" data-aos="zoom-in" data-aos-duration="800">
                            <h2 class="fw-bold mb-4">Siap untuk Mulai?</h2>
                            <p class="lead mb-4">Bergabunglah dengan SPEKTRA untuk pengalaman PKL yang terorganisir dan efisien</p>
                            <div class="d-grid gap-2 d-md-flex justify-content-md-center">
                                @auth
                                    <a href="{{ url('/dashboard') }}" class="btn btn-primary btn-lg px-4">Akses Dashboard</a>
                                @else
                                    <a href="{{ route('register') }}" class="btn btn-primary btn-lg px-4">Buat Akun</a>
                                    <a href="{{ route('login') }}" class="btn btn-outline-primary btn-lg px-4">Login</a>
                                @endauth
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Contact Section -->
        <section class="py-5" id="contact">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-lg-8 text-center" data-aos="fade-up" data-aos-duration="800">
                        <h2 class="fw-bold mb-4">Hubungi Kami</h2>
                        <p class="mb-4">Jika Anda memiliki pertanyaan atau kendala dalam menggunakan SPEKTRA, jangan ragu untuk menghubungi tim kami.</p>
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="#" class="btn btn-outline-primary rounded-circle p-2 social-btn">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle p-2 social-btn">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle p-2 social-btn">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-primary rounded-circle p-2 social-btn">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                        <div class="row mt-5">
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="100">
                                <div class="contact-info glass-card p-4">
                                    <i class="bi bi-envelope fs-3 mb-3 text-primary"></i>
                                    <h5 class="mb-2">Email</h5>
                                    <p class="mb-0">support@spektra.ac.id</p>
                                </div>
                            </div>
                            <div class="col-md-4 mb-4 mb-md-0" data-aos="fade-up" data-aos-delay="200">
                                <div class="contact-info glass-card p-4">
                                    <i class="bi bi-telephone fs-3 mb-3 text-primary"></i>
                                    <h5 class="mb-2">Telepon</h5>
                                    <p class="mb-0">+62 123 4567 890</p>
                                </div>
                            </div>
                            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                                <div class="contact-info glass-card p-4">
                                    <i class="bi bi-geo-alt fs-3 mb-3 text-primary"></i>
                                    <h5 class="mb-2">Alamat</h5>
                                    <p class="mb-0">Jl. Pendidikan No. 123, Kota Akademik, Indonesia</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Footer -->
        <footer class="footer">
            <div class="container">
                <div class="row">
                    <div class="col-lg-4 mb-4 mb-lg-0">
                        <div class="d-flex align-items-center mb-3">
                            <div class="footer-logo">
                                <img src="{{ asset('images/logo.svg') }}" alt="SPEKTRA Logo" class="logo-img">
                            </div>
                            <h5 class="fw-bold mb-0 ms-2 text-white">SPEKTRA</h5>
                        </div>
                        <p>Sistem PKL Terintegrasi Akademia</p>
                        <p>Memudahkan pengelolaan PKL untuk semua pihak terkait</p>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                        <h5 class="fw-bold mb-3">Tautan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="footer-link"><i class="bi bi-chevron-right me-1"></i> Beranda</a></li>
                            <li class="mb-2"><a href="#features" class="footer-link"><i class="bi bi-chevron-right me-1"></i> Fitur</a></li>
                            <li class="mb-2"><a href="#about" class="footer-link"><i class="bi bi-chevron-right me-1"></i> Tentang</a></li>
                            <li><a href="#contact" class="footer-link"><i class="bi bi-chevron-right me-1"></i> Kontak</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                        <h5 class="fw-bold mb-3">Bantuan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#" class="footer-link"><i class="bi bi-question-circle me-1"></i> FAQ</a></li>
                            <li class="mb-2"><a href="#" class="footer-link"><i class="bi bi-book me-1"></i> Panduan</a></li>
                            <li class="mb-2"><a href="#" class="footer-link"><i class="bi bi-file-text me-1"></i> Syarat & Ketentuan</a></li>
                            <li><a href="#" class="footer-link"><i class="bi bi-shield-check me-1"></i> Kebijakan Privasi</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-4">
                        <h5 class="fw-bold mb-3">Berlangganan</h5>
                        <p>Dapatkan informasi terbaru tentang SPEKTRA</p>
                        <form>
                            <div class="input-group mb-3">
                                <input type="email" class="form-control" placeholder="Email Anda" aria-label="Email Anda">
                                <button class="btn btn-primary" type="button">Langganan</button>
                            </div>
                        </form>
                    </div>
                </div>
                <hr class="mt-4 mb-3">
                <div class="row">
                    <div class="col text-center">
                        <p class="mb-0">&copy; {{ date('Y') }} SPEKTRA. Hak Cipta Dilindungi.</p>
                    </div>
                </div>
            </div>
        </footer>
        
        <!-- Bootstrap JS Bundle -->
        <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
        
        <!-- AOS - Animate On Scroll -->
        <script src="https://unpkg.com/aos@next/dist/aos.js"></script>
        
        <!-- Custom JS -->
        <script>
            // Initialize AOS
            AOS.init({
                duration: 800,
                easing: 'ease',
                once: true
            });
            
            // Custom cursor effect
            document.addEventListener('DOMContentLoaded', function() {
                // Create custom cursor
                const cursor = document.createElement('div');
                cursor.className = 'custom-cursor';
                document.body.appendChild(cursor);
                
                // Update cursor position
                document.addEventListener('mousemove', (e) => {
                    cursor.style.left = `${e.clientX}px`;
                    cursor.style.top = `${e.clientY}px`;
                });
                
                // Add expanded class on interactive elements
                const interactiveElements = document.querySelectorAll('a, button, .icon-box, .glass-card, input');
                interactiveElements.forEach(el => {
                    el.addEventListener('mouseenter', () => cursor.classList.add('expanded'));
                    el.addEventListener('mouseleave', () => cursor.classList.remove('expanded'));
                });
                
                // Navbar scroll effect
                const navbar = document.querySelector('.navbar');
                window.addEventListener('scroll', () => {
                    if (window.scrollY > 50) {
                        navbar.classList.add('scrolled');
                    } else {
                        navbar.classList.remove('scrolled');
                    }
                });
                
                // Smooth scroll for navigation links
                document.querySelectorAll('a[href^="#"]').forEach(anchor => {
                    anchor.addEventListener('click', function(e) {
                        e.preventDefault();
                        
                        const targetId = this.getAttribute('href');
                        if (targetId === '#') return;
                        
                        const targetElement = document.querySelector(targetId);
                        if (targetElement) {
                            const navbarHeight = document.querySelector('.navbar').offsetHeight;
                            const targetPosition = targetElement.getBoundingClientRect().top + window.pageYOffset - navbarHeight;
                            
                            window.scrollTo({
                                top: targetPosition,
                                behavior: 'smooth'
                            });
                        }
                    });
                });
                
                // Stats counter animation
                const counters = document.querySelectorAll('.counter');
                const speed = 200;
                
                const startCounters = () => {
                    counters.forEach(counter => {
                        const updateCount = () => {
                            const target = parseInt(counter.getAttribute('data-target'));
                            const count = parseInt(counter.innerText);
                            const increment = Math.trunc(target / speed);
                            
                            if (count < target) {
                                counter.innerText = count + increment;
                                setTimeout(updateCount, 10);
                            } else {
                                counter.innerText = target + '+';
                            }
                        };
                        updateCount();
                    });
                };
                
                // Start counters when they come into view
                const statsSection = document.querySelector('.stats-box');
                const observer = new IntersectionObserver((entries) => {
                    entries.forEach(entry => {
                        if (entry.isIntersecting) {
                            startCounters();
                            observer.unobserve(entry.target);
                        }
                    });
                }, { threshold: 0.5 });
                
                if (statsSection) {
                    observer.observe(statsSection);
                }
            });
        </script>
    </body>
</html>