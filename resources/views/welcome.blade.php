<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>SPEKTRA - Sistem PKL Terintegrasi Akademia</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Bootstrap 5 -->
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
        <!-- Bootstrap Icons -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
        
        <!-- Styles -->
        <style>
            body {
                font-family: 'Inter', sans-serif;
                background-color: #f8f9fa;
            }
            
            .bg-hero {
                background: linear-gradient(135deg, #0d6efd 0%, #0a58ca 100%);
                color: white;
                padding: 6rem 0;
            }
            
            .hero-image {
                max-width: 90%;
                height: auto;
            }
            
            .icon-box {
                text-align: center;
                padding: 2rem;
                border-radius: 0.5rem;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                transition: transform 0.3s ease;
                background-color: white;
                height: 100%;
            }
            
            .icon-box:hover {
                transform: translateY(-5px);
            }
            
            .icon-box i {
                font-size: 3rem;
                margin-bottom: 1.5rem;
                color: #0d6efd;
            }
            
            .navbar {
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
            }
            
            .features {
                padding: 5rem 0;
            }
            
            .footer {
                background-color: #343a40;
                color: white;
                padding: 3rem 0;
            }
            
            .footer a {
                color: rgba(255, 255, 255, 0.8);
                text-decoration: none;
            }
            
            .footer a:hover {
                color: white;
            }
            
            .stats-box {
                text-align: center;
                padding: 2rem;
                background-color: #fff;
                box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
                border-radius: 0.5rem;
                margin-bottom: 1rem;
            }
            
            .stats-box h2 {
                font-size: 3rem;
                font-weight: 700;
                color: #0d6efd;
            }
            
            .stats-box p {
                font-size: 1rem;
                color: #6c757d;
            }
            
            .cta-section {
                background-color: #e9ecef;
                padding: 5rem 0;
            }
        </style>
    </head>
    <body>
        <!-- Navbar -->
        <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
            <div class="container">
                <a class="navbar-brand fw-bold" href="#">
                    <img src="{{ asset('images/logo.png') }}" alt="SPEKTRA Logo" width="30" height="30" class="d-inline-block align-text-top me-2">
                    SPEKTRA
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
                                    <a href="{{ url('/dashboard') }}" class="btn btn-outline-light me-2">Dashboard</a>
                                @else
                                    <a href="{{ route('login') }}" class="btn btn-outline-light me-2">Login</a>
                                    @if (Route::has('register'))
                                        <a href="{{ route('register') }}" class="btn btn-light">Register</a>
                                    @endif
                                @endauth
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        </nav>

        <!-- Hero Section -->
        <section class="bg-hero">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-lg-6">
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
                    <div class="col-lg-6">
                        <img src="{{ asset('images/hero-image.svg') }}" alt="SPEKTRA Hero" class="hero-image d-block mx-auto mt-5 mt-lg-0">
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats Section -->
        <section class="py-5">
            <div class="container">
                <div class="row">
                    <div class="col-md-3 col-6">
                        <div class="stats-box">
                            <h2>20+</h2>
                            <p>Perusahaan Mitra</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-box">
                            <h2>100+</h2>
                            <p>Mahasiswa</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-box">
                            <h2>15+</h2>
                            <p>Bidang PKL</p>
                        </div>
                    </div>
                    <div class="col-md-3 col-6">
                        <div class="stats-box">
                            <h2>50+</h2>
                            <p>PKL Aktif</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Features Section -->
        <section class="features" id="features">
            <div class="container">
                <div class="text-center mb-5">
                    <h2 class="fw-bold">Fitur Utama SPEKTRA</h2>
                    <p class="lead text-muted">Pengalaman praktik kerja lapangan yang terintegrasi dan efisien</p>
                </div>
                <div class="row g-4">
                    <div class="col-md-4">
                        <div class="icon-box">
                            <i class="bi bi-send-check"></i>
                            <h4 class="mb-3">Pengajuan PKL Online</h4>
                            <p class="text-muted">Mahasiswa dapat mengajukan PKL secara online dengan mudah dan melacak status pengajuan mereka secara real-time.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box">
                            <i class="bi bi-journal-text"></i>
                            <h4 class="mb-3">Laporan Harian Digital</h4>
                            <p class="text-muted">Pencatatan aktivitas harian yang mudah dengan fitur verifikasi dari pembimbing dan dokumentasi foto.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box">
                            <i class="bi bi-chat-dots"></i>
                            <h4 class="mb-3">Komunikasi Terintegrasi</h4>
                            <p class="text-muted">Komunikasi antara mahasiswa, dosen pembimbing, dan pembimbing lapangan dalam satu platform.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box">
                            <i class="bi bi-graph-up"></i>
                            <h4 class="mb-3">Monitoring & Evaluasi</h4>
                            <p class="text-muted">Pemantauan progres PKL dengan dashboard komprehensif dan sistem evaluasi berbasis kompetensi.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="icon-box">
                            <i class="bi bi-file-earmark-pdf"></i>
                            <h4 class="mb-3">Pengelolaan Dokumen</h4>
                            <p class="text-muted">Pengelolaan surat pengantar, laporan, dan dokumen PKL lainnya secara digital.</p>
                        </div>
                    </div>
                    <div class="col-md-4">
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
                    <div class="col-lg-6 mb-4 mb-lg-0">
                        <img src="{{ asset('images/about-image.svg') }}" alt="Tentang SPEKTRA" class="img-fluid rounded">
                    </div>
                    <div class="col-lg-6">
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
        </section>

        <!-- Contact Section -->
        <section class="py-5" id="contact">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 mx-auto text-center">
                        <h2 class="fw-bold mb-4">Hubungi Kami</h2>
                        <p class="mb-4">Jika Anda memiliki pertanyaan atau kendala dalam menggunakan SPEKTRA, jangan ragu untuk menghubungi tim kami.</p>
                        <div class="d-flex justify-content-center gap-3 mb-4">
                            <a href="#" class="btn btn-outline-dark rounded-circle p-2">
                                <i class="bi bi-facebook"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark rounded-circle p-2">
                                <i class="bi bi-twitter"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark rounded-circle p-2">
                                <i class="bi bi-instagram"></i>
                            </a>
                            <a href="#" class="btn btn-outline-dark rounded-circle p-2">
                                <i class="bi bi-linkedin"></i>
                            </a>
                        </div>
                        <div class="d-flex flex-column align-items-center">
                            <p class="mb-2">
                                <i class="bi bi-envelope me-2"></i> support@spektra.ac.id
                            </p>
                            <p class="mb-2">
                                <i class="bi bi-telephone me-2"></i> +62 123 4567 890
                            </p>
                            <p class="mb-0">
                                <i class="bi bi-geo-alt me-2"></i> Jl. Pendidikan No. 123, Kota Akademik, Indonesia
                            </p>
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
                        <h5 class="fw-bold mb-3">SPEKTRA</h5>
                        <p>Sistem PKL Terintegrasi Akademia</p>
                        <p>Memudahkan pengelolaan PKL untuk semua pihak terkait</p>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                        <h5 class="fw-bold mb-3">Tautan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#">Beranda</a></li>
                            <li class="mb-2"><a href="#features">Fitur</a></li>
                            <li class="mb-2"><a href="#about">Tentang</a></li>
                            <li><a href="#contact">Kontak</a></li>
                        </ul>
                    </div>
                    <div class="col-lg-2 col-md-3 mb-4 mb-md-0">
                        <h5 class="fw-bold mb-3">Bantuan</h5>
                        <ul class="list-unstyled">
                            <li class="mb-2"><a href="#">FAQ</a></li>
                            <li class="mb-2"><a href="#">Panduan</a></li>
                            <li class="mb-2"><a href="#">Syarat & Ketentuan</a></li>
                            <li><a href="#">Kebijakan Privasi</a></li>
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
    </body>
</html>