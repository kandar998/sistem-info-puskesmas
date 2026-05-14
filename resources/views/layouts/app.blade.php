<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, viewport-fit=cover">
    <title>@yield('title', 'Puskesmas Katoi') - Sistem Informasi Pelayanan Pasien</title>

    <!-- PWA Meta Tags -->
    <meta name="theme-color" content="#2ecc71">
    <meta name="apple-mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="apple-mobile-web-app-title" content="Puskesmas Katoi">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="application-name" content="Puskesmas Katoi">
    <meta name="msapplication-TileColor" content="#2ecc71">
    <meta name="msapplication-config" content="none">

       <!-- PWA Icons untuk berbagai perangkat -->
    <!-- Favicon untuk desktop browser -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo-puskesmas-16.png') }}">
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo-puskesmas-32.png') }}">
    <link rel="icon" type="image/png" sizes="96x96" href="{{ asset('images/logo-puskesmas-96.png') }}">

    <!-- Apple Touch Icons untuk iOS -->
    <link rel="apple-touch-icon" href="{{ asset('images/logo-puskesmas-192.png') }}">
    <link rel="apple-touch-icon" sizes="72x72" href="{{ asset('images/logo-puskesmas-72.png') }}">
    <link rel="apple-touch-icon" sizes="96x96" href="{{ asset('images/logo-puskesmas-96.png') }}">
    <link rel="apple-touch-icon" sizes="128x128" href="{{ asset('images/logo-puskesmas-128.png') }}">
    <link rel="apple-touch-icon" sizes="144x144" href="{{ asset('images/logo-puskesmas-144.png') }}">
    <link rel="apple-touch-icon" sizes="152x152" href="{{ asset('images/logo-puskesmas-152.png') }}">
    <link rel="apple-touch-icon" sizes="192x192" href="{{ asset('images/logo-puskesmas-192.png') }}">
    <link rel="apple-touch-icon" sizes="384x384" href="{{ asset('images/logo-puskesmas-384.png') }}">
    <link rel="apple-touch-icon" sizes="512x512" href="{{ asset('images/logo-puskesmas-512.png') }}">

    <!-- PWA Manifest -->
    <link rel="manifest" href="{{ asset('manifest.json') }}">

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <!-- Swiper CSS untuk Slider -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />

    <!-- Custom CSS -->
    <style>
        :root {
            --primary-color: #0d6efd;
            --secondary-color: #6c757d;
            --success-color: #198754;
            --info-color: #0dcaf0;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            overflow-x: hidden;
        }

        /* Hero Section dengan Slider */
        .hero-section {
            position: relative;
            min-height: 100vh;
            color: white;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        /* Swiper Slider Styles */
        .hero-swiper {
            width: 100%;
            height: 100%;
            position: absolute;
            top: 0;
            left: 0;
            z-index: 1;
        }

        .swiper-slide {
            position: relative;
        }

        .swiper-slide::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: rgba(0, 0, 0, 0.6);
            z-index: 2;
        }

        .slide-bg {
            width: 100%;
            height: 100%;
            background-size: cover;
            background-position: center;
            background-attachment: fixed;
        }

        .hero-content {
            position: relative;
            z-index: 10;
            color: white;
            text-align: center;
            padding: 0 20px;
            max-width: 800px;
            margin: 0 auto;
        }

        .hero-content h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1rem;
            text-shadow: 2px 2px 4px rgba(0,0,0,0.3);
            animation: fadeInDown 1s ease;
        }

        .hero-content p {
            font-size: 1.25rem;
            margin-bottom: 2rem;
            text-shadow: 1px 1px 2px rgba(0,0,0,0.3);
            animation: fadeInUp 1s ease 0.3s both;
        }

        .hero-content .btn {
            animation: fadeInUp 1s ease 0.6s both;
            padding: 12px 30px;
            font-size: 1.1rem;
            border-radius: 50px;
            margin: 0 10px;
        }

        /* Swiper Navigation */
        .swiper-button-next,
        .swiper-button-prev {
            color: white;
            z-index: 20;
            background: rgba(255,255,255,0.2);
            width: 50px;
            height: 50px;
            border-radius: 50%;
            backdrop-filter: blur(5px);
        }

        .swiper-button-next:after,
        .swiper-button-prev:after {
            font-size: 20px;
        }

        .swiper-button-next:hover,
        .swiper-button-prev:hover {
            background: rgba(255,255,255,0.3);
        }

        .swiper-pagination-bullet {
            background: white;
            opacity: 0.7;
            z-index: 20;
            width: 12px;
            height: 12px;
        }

        .swiper-pagination-bullet-active {
            background: var(--primary-color);
            opacity: 1;
        }

        /* Animations */
        @keyframes fadeInDown {
            from {
                opacity: 0;
                transform: translateY(-30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Navbar Styles */
        .navbar {
            transition: all 0.3s ease;
            background: transparent !important;
            padding: 1rem 0;
            z-index: 100;
        }

        .navbar.scrolled {
            background: white !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            padding: 0.5rem 0;
        }

        .navbar.scrolled .nav-link {
            color: #333 !important;
        }

        .navbar.scrolled .navbar-brand span {
            color: #333 !important;
        }

        .nav-link {
            color: white !important;
            font-weight: 500;
            margin: 0 10px;
            transition: all 0.3s ease;
        }

        .nav-link:hover {
            color: var(--primary-color) !important;
        }

        .navbar-brand span {
            color: white;
            transition: color 0.3s ease;
        }

        /* Dropdown menu styling */
        .dropdown-menu {
            background: rgba(255,255,255,0.95);
            backdrop-filter: blur(10px);
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }

        .dropdown-item {
            color: #333;
            transition: all 0.3s;
        }

        .dropdown-item:hover {
            background: var(--primary-color);
            color: white;
            padding-left: 25px;
        }

        /* Card Styles */
        .card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            overflow: hidden;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        /* Section Titles */
        .section-title {
            position: relative;
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 3rem;
            padding-bottom: 1rem;
            text-align: center;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100px;
            height: 4px;
            background: linear-gradient(to right, var(--primary-color), var(--info-color));
            border-radius: 2px;
        }

        /* Gooey Liquid Footer */
        .gooey-footer {
            position: relative;
            background: #0a1f44;
            color: white;
            overflow: hidden;
        }

        .gooey-footer::before {
            content: '';
            position: absolute;
            top: -50px;
            left: 0;
            width: 100%;
            height: 100px;
            background: #0a1f44;
            filter: url(#gooey);
            animation: wave 8s infinite linear;
        }

        @keyframes wave {
            0% { transform: translateX(0); }
            50% { transform: translateX(-25%); }
            100% { transform: translateX(-50%); }
        }

        /* Statistik Cards */
        .stat-card {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 2rem;
            text-align: center;
            border: 1px solid rgba(255,255,255,0.2);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            background: rgba(255,255,255,0.2);
            transform: scale(1.05);
        }

        .stat-icon {
            font-size: 3rem;
            margin-bottom: 1rem;
            color: var(--info-color);
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        /* Stat Mini untuk Footer */
        .stat-mini {
            background: rgba(255,255,255,0.1);
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: all 0.3s ease;
        }

        .stat-mini:hover {
            background: rgba(255,255,255,0.2);
            transform: translateY(-3px);
        }

        .stat-icon-mini {
            font-size: 2rem;
            margin-bottom: 0.5rem;
            color: var(--info-color);
        }

        .stat-info {
            display: flex;
            flex-direction: column;
        }

        .stat-label {
            font-size: 0.8rem;
            opacity: 0.8;
        }

        .stat-value {
            font-size: 1.2rem;
            font-weight: bold;
        }

        /* Timeline untuk Sejarah */
        .timeline {
            position: relative;
            padding: 20px 0;
        }

        .timeline::before {
            content: '';
            position: absolute;
            left: 50%;
            width: 2px;
            height: 100%;
            background: var(--primary-color);
        }

        /* PWA Install Banner */
        .pwa-install-banner {
            position: fixed;
            bottom: 20px;
            left: 20px;
            right: 20px;
            background: linear-gradient(135deg, #11998e, #2ecc71);
            color: white;
            border-radius: 16px;
            padding: 16px 20px;
            display: none;
            align-items: center;
            justify-content: space-between;
            box-shadow: 0 10px 25px rgba(0,0,0,0.2);
            z-index: 1000;
            animation: slideUp 0.5s ease;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(100px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .pwa-install-banner-content {
            display: flex;
            align-items: center;
            gap: 15px;
        }

        .pwa-install-banner-icon {
            background: rgba(255,255,255,0.2);
            border-radius: 12px;
            padding: 10px;
        }

        .pwa-install-banner-icon i {
            font-size: 32px;
        }

        .pwa-install-banner-text h6 {
            margin: 0;
            font-weight: 600;
        }

        .pwa-install-banner-text p {
            margin: 0;
            font-size: 12px;
            opacity: 0.9;
        }

        .pwa-install-banner button {
            background: white;
            border: none;
            color: #2ecc71;
            padding: 10px 20px;
            border-radius: 30px;
            font-weight: 600;
            transition: all 0.3s;
        }

        .pwa-install-banner button:hover {
            transform: scale(1.05);
            box-shadow: 0 4px 10px rgba(0,0,0,0.2);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-content h1 {
                font-size: 2rem;
            }

            .hero-content p {
                font-size: 1rem;
            }

            .hero-content .btn {
                display: block;
                margin: 10px auto;
                width: 80%;
            }

            .section-title {
                font-size: 2rem;
            }

            .stat-number {
                font-size: 2rem;
            }

            .swiper-button-next,
            .swiper-button-prev {
                display: none;
            }

            .pwa-install-banner {
                flex-direction: column;
                text-align: center;
                gap: 15px;
            }

            .pwa-install-banner-content {
                flex-direction: column;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <!-- PWA Install Banner -->
    <div class="pwa-install-banner" id="pwaInstallBanner">
        <div class="pwa-install-banner-content">
            <div class="pwa-install-banner-icon">
                <i class="fas fa-mobile-alt"></i>
            </div>
            <div class="pwa-install-banner-text">
                <h6>Pasang Aplikasi Puskesmas Katoi</h6>
                <p>Instal aplikasi untuk akses lebih cepat dan mudah</p>
            </div>
        </div>
        <button id="installPwaBtn">
            <i class="fas fa-download me-2"></i>Pasang Sekarang
        </button>
    </div>

    <!-- Navbar -->
    <nav class="navbar navbar-expand-lg fixed-top" id="mainNav">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="{{ route('home') }}">
                <!-- Logo Puskesmas -->
                <img src="{{ asset('images/logo-puskesmas.png') }}" alt="Logo Puskesmas Katoi" height="60" class="me-2" onerror="this.src='{{ asset('images/logo-puskesmas.png') }}'">
                <span class="fw-bold">Puskesmas Katoi</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#home">Beranda</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#profil">Profil</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#visi-misi">Visi & Misi</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Informasi
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item" href="{{ route('home') }}#struktur">Struktur Organisasi</a></li>
                            <li><a class="dropdown-item" href="{{ route('home') }}#sejarah">Sejarah</a></li>
                            <li><a class="dropdown-item" href="{{ route('home') }}#jadwal-pemeriksaan">Jadwal Periksa</a></li>
                            <li><a class="dropdown-item" href="{{ route('home') }}#jadwal-posyandu">Jadwal Posyandu</a></li>
                        </ul>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('pelayanan.index') }}">Pelayanan Online</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#berita">Berita</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#galeri">Galeri</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('home') }}#kontak">Kontak</a>
                    </li>
                    @auth
                        @if(auth()->user()->hasRole('admin'))
                            <li class="nav-item">
                                <a class="nav-link btn btn-primary text-white px-4" href="{{ route('admin.dashboard') }}">
                                    <i class="fas fa-tachometer-alt"></i> Dashboard
                                </a>
                            </li>
                        @endif
                    @else
                        <li class="nav-item">
                            <a class="nav-link" href="{{ route('login') }}">Masuk</a>
                        </li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <!-- Content -->
    @yield('content')

    <!-- Gooey Liquid Footer -->
    <footer class="gooey-footer">
        <svg style="position: absolute; width: 0; height: 0;">
            <defs>
                <filter id="gooey">
                    <feGaussianBlur in="SourceGraphic" stdDeviation="10" result="blur" />
                    <feColorMatrix in="blur" mode="matrix" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9" result="gooey" />
                </filter>
            </defs>
        </svg>

        <div class="container position-relative py-5">
            <div class="row">
                <div class="col-md-4 mb-4" data-aos="fade-up">
                    <h5 class="text-white mb-4">Tentang Kami</h5>
                    <p class="text-white-50">
                        {{ $profil->deskripsi ?? 'Puskesmas Katoi melayani masyarakat dengan sepenuh hati untuk kesehatan yang lebih baik.' }}
                    </p>
                    <div class="social-links mt-3">
                        <a href="#" class="text-white me-3"><i class="fab fa-facebook fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-twitter fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-instagram fa-2x"></i></a>
                        <a href="#" class="text-white me-3"><i class="fab fa-youtube fa-2x"></i></a>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="100">
                    <h5 class="text-white mb-4">Statistik</h5>
                    <div class="row g-2">
                        <div class="col-6">
                            <div class="stat-mini">
                                <i class="fas fa-users stat-icon-mini"></i>
                                <div class="stat-info">
                                    <span class="stat-label">Total Pasien</span>
                                    <span class="stat-value">{{ number_format($statistic['total_pasien'] ?? 0) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <i class="fas fa-user-md stat-icon-mini"></i>
                                <div class="stat-info">
                                    <span class="stat-label">Dokter</span>
                                    <span class="stat-value">{{ $statistic['total_dokter'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <i class="fas fa-calendar-check stat-icon-mini"></i>
                                <div class="stat-info">
                                    <span class="stat-label">Kunjungan Hari Ini</span>
                                    <span class="stat-value">{{ $statistic['total_kunjungan_hari'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="stat-mini">
                                <i class="fas fa-child stat-icon-mini"></i>
                                <div class="stat-info">
                                    <span class="stat-label">Posyandu</span>
                                    <span class="stat-value">{{ $statistic['total_posyandu'] ?? 0 }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-md-4 mb-4" data-aos="fade-up" data-aos-delay="200">
                    <h5 class="text-white mb-4">Kontak Kami</h5>
                    <ul class="list-unstyled">
                        <li class="mb-3">
                            <i class="fas fa-map-marker-alt me-2"></i>
                            {{ $profil->alamat ?? 'Jl. Kesehatan No. 123, Katoi' }}
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-phone me-2"></i>
                            {{ $profil->telepon ?? '(0405) 123456' }}
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-envelope me-2"></i>
                            {{ $profil->email ?? 'info@puskesmaskatoi.com' }}
                        </li>
                        <li class="mb-3">
                            <i class="fas fa-clock me-2"></i>
                            Senin - Jumat: 08:00 - 16:00
                        </li>
                    </ul>
                </div>
            </div>

            <div class="row mt-4">
                <div class="col-12 text-center">
                    <hr class="border-white-50">
                    <p class="mb-0 text-white-50">
                        &copy; {{ date('Y') }} Puskesmas Katoi. All rights reserved.
                        Developed with <i class="fas fa-heart text-danger"></i> for Iskandar
                    </p>
                </div>
            </div>
        </div>
    </footer>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <script>
        // Initialize AOS
        AOS.init({
            duration: 1000,
            once: true
        });

        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const nav = document.getElementById('mainNav');
            if (window.scrollY > 50) {
                nav.classList.add('scrolled');
            } else {
                nav.classList.remove('scrolled');
            }
        });

        // Smooth scroll
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Initialize Swiper Slider untuk background
        document.addEventListener('DOMContentLoaded', function() {
            const heroSwiper = document.querySelector('.hero-swiper');
            if (heroSwiper) {
                const swiper = new Swiper('.hero-swiper', {
                    loop: true,
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: '.swiper-pagination',
                        clickable: true,
                    },
                    navigation: {
                        nextEl: '.swiper-button-next',
                        prevEl: '.swiper-button-prev',
                    },
                    effect: 'fade',
                    fadeEffect: {
                        crossFade: true
                    },
                    speed: 1000,
                });
            }
        });

        // Add active class to nav links based on scroll position
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const scrollY = window.pageYOffset;

            sections.forEach(section => {
                const sectionHeight = section.offsetHeight;
                const sectionTop = section.offsetTop - 100;
                const sectionId = section.getAttribute('id');
                const navLink = document.querySelector(`.nav-link[href="#${sectionId}"]`);

                if (navLink) {
                    if (scrollY > sectionTop && scrollY <= sectionTop + sectionHeight) {
                        navLink.classList.add('active');
                    } else {
                        navLink.classList.remove('active');
                    }
                }
            });
        });

       // ========== PWA Installation Code ==========
let deferredPrompt;
const installBanner = document.getElementById('pwaInstallBanner');
const installBtn = document.getElementById('installPwaBtn');

// Pastikan installBanner ada sebelum digunakan
if (installBanner) {
    // Listen for beforeinstallprompt event
    window.addEventListener('beforeinstallprompt', (e) => {
        // Prevent Chrome 67 and earlier from automatically showing the prompt
        e.preventDefault();
        // Stash the event so it can be triggered later
        deferredPrompt = e;
        // Show the install banner
        installBanner.style.display = 'flex';
        console.log('PWA install prompt ready');
    });

    // Handle install button click
    if (installBtn) {
        installBtn.addEventListener('click', async () => {
            // Hide the install banner
            installBanner.style.display = 'none';

            // Show the install prompt
            if (deferredPrompt) {
                deferredPrompt.prompt();
                // Wait for the user to respond to the prompt
                const { outcome } = await deferredPrompt.userChoice;
                console.log(`User response to the install prompt: ${outcome}`);
                // Clear the deferred prompt
                deferredPrompt = null;
            } else {
                console.log('No deferred prompt available');
                // Alternative message for browsers that don't support beforeinstallprompt
                alert('Untuk memasang aplikasi, buka menu browser dan pilih "Install App" atau "Tambahkan ke Layar Utama"');
            }
        });
    }

    // Hide banner if app is already installed
    window.addEventListener('appinstalled', () => {
        installBanner.style.display = 'none';
        deferredPrompt = null;
        console.log('PWA was installed');

        // Optional: Show success message
        const successMsg = document.createElement('div');
        successMsg.className = 'alert alert-success position-fixed bottom-0 start-50 translate-middle-x mb-3';
        successMsg.style.zIndex = '2000';
        successMsg.style.backgroundColor = '#2ecc71';
        successMsg.style.color = 'white';
        successMsg.style.border = 'none';
        successMsg.style.borderRadius = '30px';
        successMsg.style.padding = '12px 24px';
        successMsg.style.fontWeight = 'bold';
        successMsg.innerHTML = '<i class="fas fa-check-circle me-2"></i> Aplikasi berhasil dipasang!';
        document.body.appendChild(successMsg);
        setTimeout(() => successMsg.remove(), 3000);
    });

    // Check if app is running in standalone mode (already installed)
    if (window.matchMedia('(display-mode: standalone)').matches ||
        window.navigator.standalone === true) {
        console.log('App is running in standalone mode');
        installBanner.style.display = 'none';
    }
}

// Register Service Worker
if ('serviceWorker' in navigator) {
    window.addEventListener('load', () => {
        navigator.serviceWorker.register('/sw.js')
            .then(registration => {
                console.log('ServiceWorker registration successful with scope: ', registration.scope);
            })
            .catch(err => {
                console.log('ServiceWorker registration failed: ', err);
            });
    });
}
// ========== End PWA Installation Code ==========

    </script>
    @stack('scripts')
</body>
</html>
