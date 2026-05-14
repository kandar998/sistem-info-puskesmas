@extends('layouts.app')

@section('title', 'Berita Terkini')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">BERITA TERKINI</h1>
        <p class="lead">Informasi terbaru seputar kegiatan dan layanan Puskesmas Katoi</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Berita</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Berita Section -->
<section class="py-5">
    <div class="container">
        <!-- Search and Filter -->
        <div class="row mb-5" data-aos="fade-up">
            <div class="col-md-8 mx-auto">
                <form action="{{ route('berita.all') }}" method="GET" class="d-flex gap-2">
                    <input type="text" name="search" class="form-control form-control-lg rounded-pill"
                           placeholder="Cari berita..." value="{{ request('search') }}">
                    <button type="submit" class="btn btn-primary rounded-pill px-4">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
        </div>

        <!-- Berita Grid -->
        <div class="row g-4">
            @forelse($beritas as $berita)
            <div class="col-lg-4 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->index * 100 }}">
                <div class="card h-100 border-0 shadow-sm hover-card">
                    <div class="position-relative">
                        @if($berita->gambar)
                            <img src="{{ Storage::url($berita->gambar) }}"
                                 class="card-img-top"
                                 alt="{{ $berita->judul }}"
                                 style="height: 220px; object-fit: cover;">
                        @else
                            <div class="bg-light d-flex align-items-center justify-content-center"
                                 style="height: 220px;">
                                <i class="fas fa-newspaper fa-4x text-muted"></i>
                            </div>
                        @endif
                        <div class="position-absolute top-0 end-0 m-3">
                            <span class="badge bg-primary px-3 py-2">
                                <i class="far fa-calendar-alt me-2"></i>{{ $berita->tanggal->format('d M Y') }}
                            </span>
                        </div>
                    </div>
                    <div class="card-body">
                        <h5 class="card-title mb-3">{{ $berita->judul }}</h5>
                        <p class="card-text text-muted">{{ Str::limit(strip_tags($berita->konten), 120) }}</p>
                        <div class="d-flex justify-content-between align-items-center mt-3">
                            <div class="small text-muted">
                                <i class="far fa-clock me-1"></i> {{ $berita->created_at->diffForHumans() }}
                            </div>
                            <a href="{{ route('berita.detail', $berita->id) }}" class="btn btn-outline-primary btn-sm rounded-pill">
                                Baca Selengkapnya <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @empty
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <div class="empty-state">
                    <i class="fas fa-newspaper fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum Ada Berita</h4>
                    <p class="text-muted">Belum ada berita yang dipublikasikan saat ini.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $beritas->withQueryString()->links() }}
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
    .hero-section {
        position: relative;
        background-attachment: fixed;
        display: flex;
        align-items: center;
        color: white;
    }

    .breadcrumb-item + .breadcrumb-item::before {
        color: rgba(255,255,255,0.5);
    }

    .breadcrumb-item a {
        color: rgba(255,255,255,0.8);
        text-decoration: none;
        transition: color 0.3s;
    }

    .breadcrumb-item a:hover {
        color: white;
    }

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    .card-img-top {
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .card {
        border-radius: 12px;
        overflow: hidden;
    }

    .badge {
        font-size: 0.8rem;
        font-weight: 500;
    }

    .empty-state {
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    /* Pagination styling */
    .pagination {
        gap: 5px;
    }

    .page-link {
        border: none;
        padding: 10px 15px;
        border-radius: 8px;
        color: #333;
        background: #f8f9fa;
        transition: all 0.3s;
    }

    .page-link:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-2px);
    }

    .page-item.active .page-link {
        background: var(--primary-color);
        color: white;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 30vh;
        }

        .display-4 {
            font-size: 2rem;
        }

        .card {
            margin-bottom: 20px;
        }
    }
</style>
@endpush
