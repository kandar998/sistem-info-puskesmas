<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - @yield('title', 'Dashboard') | Puskesmas Katoi</title>

    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --sidebar-width: 250px;
            --topbar-height: 60px;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f4f6f9;
            overflow-x: hidden;
        }

        #wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
        }

        #sidebar-wrapper {
            min-width: var(--sidebar-width);
            max-width: var(--sidebar-width);
            background: linear-gradient(135deg, #11998e, #2ecc71);
            color: #fff;
            transition: all 0.3s;
            height: 100vh;
            position: fixed;
            left: 0;
            overflow-y: auto;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        #sidebar-wrapper.toggled {
            margin-left: calc(-1 * var(--sidebar-width));
        }

        #page-content-wrapper {
            width: 100%;
            padding-left: var(--sidebar-width);
            transition: all 0.3s;
            min-height: 100vh;
        }

        #page-content-wrapper.toggled {
            padding-left: 0;
        }

        .sidebar-heading {
            padding: 20px;
            font-size: 1.3rem;
            font-weight: bold;
            border-bottom: 1px solid rgba(255,255,255,0.1);
            background: rgba(0,0,0,0.1);
        }

        .sidebar-heading .logo-img {
            width: 45px;
            height: 45px;
            margin-right: 12px;
            border-radius: 12px;
            object-fit: cover;
            background: white;
            padding: 5px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.15);
        }

        .sidebar-heading i {
            font-size: 2rem;
            margin-right: 10px;
        }

        .sidebar-heading .brand-text {
            line-height: 1.3;
        }

        .sidebar-heading .brand-name {
            font-size: 1rem;
            font-weight: 700;
            letter-spacing: -0.5px;
        }

        .sidebar-heading .brand-sub {
            font-size: 0.7rem;
            opacity: 0.8;
        }

        .list-group-item {
            background: transparent;
            border: none;
            color: rgba(255,255,255,0.85);
            padding: 15px 25px;
            transition: all 0.3s;
            font-size: 0.95rem;
        }

        .list-group-item:hover {
            background: rgba(255,255,255,0.15);
            color: #fff;
            transform: translateX(5px);
        }

        .list-group-item.active {
            background: rgba(255,255,255,0.2);
            color: #fff;
            border-left: 4px solid #fff;
            font-weight: 600;
        }

        .list-group-item i {
            margin-right: 12px;
            width: 22px;
            font-size: 1.1rem;
        }

        .list-group-item .badge {
            margin-top: 2px;
        }

        #menu-toggle {
            cursor: pointer;
            background: transparent;
            border: none;
            font-size: 1.5rem;
            color: #333;
        }

        .navbar {
            background: white;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            height: var(--topbar-height);
            padding: 0 20px;
        }

        .card {
            border: none;
            border-radius: 12px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            transition: transform 0.3s, box-shadow 0.3s;
            margin-bottom: 20px;
        }

        .card:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0,0,0,0.1);
        }

        .stat-card {
            background: linear-gradient(135deg, #667eea, #764ba2);
            color: white;
            padding: 20px;
            border-radius: 12px;
            position: relative;
            overflow: hidden;
        }

        .stat-card i {
            position: absolute;
            right: 20px;
            bottom: 20px;
            font-size: 4rem;
            opacity: 0.3;
        }

        .stat-card .stat-title {
            font-size: 0.9rem;
            opacity: 0.9;
            margin-bottom: 5px;
        }

        .stat-card .stat-value {
            font-size: 2rem;
            font-weight: bold;
        }

        .badge-pending {
            background: #ffc107;
            color: #000;
        }

        .badge-diproses {
            background: #17a2b8;
            color: #fff;
        }

        .badge-selesai {
            background: #28a745;
            color: #fff;
        }

        .badge-ditolak {
            background: #dc3545;
            color: #fff;
        }

        /* Custom Scrollbar */
        #sidebar-wrapper::-webkit-scrollbar {
            width: 5px;
        }

        #sidebar-wrapper::-webkit-scrollbar-track {
            background: rgba(255,255,255,0.1);
        }

        #sidebar-wrapper::-webkit-scrollbar-thumb {
            background: rgba(255,255,255,0.3);
            border-radius: 5px;
        }

        @media (max-width: 768px) {
            #sidebar-wrapper {
                margin-left: calc(-1 * var(--sidebar-width));
            }
            #sidebar-wrapper.toggled {
                margin-left: 0;
            }
            #page-content-wrapper {
                padding-left: 0;
            }
            #page-content-wrapper.toggled {
                padding-left: 0;
            }

            .stat-card .stat-value {
                font-size: 1.5rem;
            }

            .sidebar-heading .logo-img {
                width: 35px;
                height: 35px;
            }

            .sidebar-heading .brand-name {
                font-size: 0.85rem;
            }
        }
    </style>
    @stack('styles')
</head>
<body>
    <div id="wrapper">
        <!-- Sidebar -->
        <div id="sidebar-wrapper">
            <div class="sidebar-heading d-flex align-items-center">
                <img src="{{ asset('images/logo-puskesmas.png') }}" alt="Logo Puskesmas Katoi" class="logo-img">
                <div class="brand-text">
                    <div class="brand-name">Puskesmas Katoi</div>
                    <div class="brand-sub">Admin Panel</div>
                </div>
            </div>

            <div class="list-group list-group-flush mt-3">
                <a href="{{ route('admin.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                    <i class="fas fa-tachometer-alt"></i> Dashboard
                </a>

                <a href="{{ route('admin.pelayanan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.pelayanan.*') ? 'active' : '' }}">
                    <i class="fas fa-users"></i> Pelayanan Online
                    @php
                        $pendingCount = \App\Models\Pelayanan::where('status', 'pending')->count();
                    @endphp
                    @if($pendingCount > 0)
                        <span class="badge bg-danger float-end">{{ $pendingCount }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.berita.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.berita.*') ? 'active' : '' }}">
                    <i class="fas fa-newspaper"></i> Berita
                </a>

                <a href="{{ route('admin.visi-misi.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.visi-misi.*') ? 'active' : '' }}">
                    <i class="fas fa-eye"></i> Visi & Misi
                </a>

                <a href="{{ route('admin.struktur.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.struktur.*') ? 'active' : '' }}">
                    <i class="fas fa-sitemap"></i> Struktur Organisasi
                </a>

                <a href="{{ route('admin.galeri.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.galeri.*') ? 'active' : '' }}">
                    <i class="fas fa-images"></i> Galeri
                </a>

                <!-- Menu Pesan Masuk -->
                <a href="{{ route('admin.kontak.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.kontak.*') ? 'active' : '' }}">
                    <i class="fas fa-envelope"></i> Pesan Masuk
                    @php
                        $pesanBelumDibaca = \App\Models\Kontak::where('status', 'belum_dibaca')->count();
                    @endphp
                    @if($pesanBelumDibaca > 0)
                        <span class="badge bg-danger float-end">{{ $pesanBelumDibaca }}</span>
                    @endif
                </a>

                <a href="{{ route('admin.sejarah.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.sejarah.*') ? 'active' : '' }}">
                    <i class="fas fa-history"></i> Sejarah
                </a>

                <a href="{{ route('admin.profil.edit') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.profil.*') ? 'active' : '' }}">
                    <i class="fas fa-building"></i> Profil
                </a>

                <a href="{{ route('admin.jadwal-posyandu.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.jadwal-posyandu.*') ? 'active' : '' }}">
                    <i class="fas fa-child"></i> Jadwal Posyandu
                </a>

                <a href="{{ route('admin.jadwal-pemeriksaan.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.jadwal-pemeriksaan.*') ? 'active' : '' }}">
                    <i class="fas fa-calendar-check"></i> Jadwal Periksa
                </a>

                <a href="{{ route('admin.setting.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('admin.setting.*') ? 'active' : '' }}">
                    <i class="fas fa-cog"></i> Pengaturan
                </a>

                <div class="list-group-item">
                    <hr class="border-white opacity-25">
                </div>

                <a href="{{ route('home') }}" target="_blank" class="list-group-item list-group-item-action">
                    <i class="fas fa-globe"></i> Lihat Website
                </a>

                <form method="POST" action="{{ route('logout') }}" id="logout-form">
                    @csrf
                    <button type="submit" class="list-group-item list-group-item-action text-danger">
                        <i class="fas fa-sign-out-alt"></i> Logout
                    </button>
                </form>
            </div>
        </div>

        <!-- Page Content -->
        <div id="page-content-wrapper">
            <!-- Top Navigation -->
            <nav class="navbar navbar-expand-lg navbar-light">
                <div class="container-fluid">
                    <button class="btn" id="menu-toggle">
                        <i class="fas fa-bars"></i>
                    </button>

                    <div class="ms-auto d-flex align-items-center">
                        <!-- Notification Bell (Optional) -->
                        <div class="dropdown me-3">
                            <button class="btn btn-link text-dark position-relative dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-bell fa-lg"></i>
                                @if($pesanBelumDibaca > 0)
                                <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger">
                                    {{ $pesanBelumDibaca }}
                                </span>
                                @endif
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('admin.kontak.index') }}">
                                    <i class="fas fa-envelope me-2"></i> {{ $pesanBelumDibaca }} Pesan Baru
                                </a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><a class="dropdown-item" href="#">Semua notifikasi</a></li>
                            </ul>
                        </div>

                        <div class="dropdown">
                            <button class="btn btn-link dropdown-toggle text-decoration-none text-dark" type="button" data-bs-toggle="dropdown">
                                <i class="fas fa-user-circle fa-2x me-2"></i>
                                <span>{{ Auth::user()->name }}</span>
                            </button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="#"><i class="fas fa-user me-2"></i> Profile</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit" class="dropdown-item text-danger">
                                            <i class="fas fa-sign-out-alt me-2"></i> Logout
                                        </button>
                                    </form>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </nav>

            <!-- Main Content -->
            <div class="container-fluid p-4">
                @if(session('success'))
                    <div class="alert alert-success alert-dismissible fade show" role="alert">
                        <i class="fas fa-check-circle me-2"></i> {{ session('success') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @if(session('error'))
                    <div class="alert alert-danger alert-dismissible fade show" role="alert">
                        <i class="fas fa-exclamation-circle me-2"></i> {{ session('error') }}
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                @endif

                @yield('content')
            </div>
        </div>
    </div>

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <script>
        // Toggle sidebar
        $("#menu-toggle").click(function(e) {
            e.preventDefault();
            $("#sidebar-wrapper").toggleClass("toggled");
            $("#page-content-wrapper").toggleClass("toggled");
        });

        // Auto hide alert after 5 seconds
        setTimeout(function() {
            $('.alert').fadeOut('slow');
        }, 5000);

        // Konfirmasi hapus
        window.confirmDelete = function(event, formId) {
            event.preventDefault();
            if (confirm('Apakah Anda yakin ingin menghapus data ini?')) {
                document.getElementById(formId).submit();
            }
        };
    </script>
    @stack('scripts')
</body>
</html>
