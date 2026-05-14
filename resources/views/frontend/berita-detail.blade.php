@extends('layouts.app')

@section('title', $berita->judul)

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">DETAIL BERITA</h1>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('berita.all') }}" class="text-white">Berita</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Detail</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Detail Berita -->
<section class="py-5">
    <div class="container">
        <div class="row">
            <!-- Main Content -->
            <div class="col-lg-8">
                <div class="card border-0 shadow-sm" data-aos="fade-up">
                    @if($berita->gambar)
                        <img src="{{ Storage::url($berita->gambar) }}" class="card-img-top" alt="{{ $berita->judul }}" style="max-height: 500px; object-fit: cover;">
                    @endif
                    <div class="card-body p-4 p-lg-5">
                        <!-- Meta Info -->
                        <div class="d-flex flex-wrap gap-3 mb-4">
                            <div class="text-muted">
                                <i class="far fa-calendar-alt me-2"></i>{{ $berita->tanggal->format('d F Y') }}
                            </div>
                            <div class="text-muted">
                                <i class="far fa-clock me-2"></i>{{ $berita->created_at->diffForHumans() }}
                            </div>
                            <div class="text-muted">
                                <i class="far fa-eye me-2"></i>{{ rand(50, 200) }}x dilihat
                            </div>
                        </div>

                        <!-- Title -->
                        <h1 class="display-5 fw-bold mb-4">{{ $berita->judul }}</h1>

                        <!-- Content -->
                        <div class="berita-content">
                            {!! nl2br(e($berita->konten)) !!}
                        </div>

                        <!-- Share Buttons -->
                        <hr class="my-4">
                        <div class="d-flex align-items-center gap-3">
                            <span class="fw-bold">Bagikan:</span>
                            <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(request()->url()) }}" target="_blank" class="btn btn-outline-primary btn-sm rounded-circle">
                                <i class="fab fa-facebook-f"></i>
                            </a>
                            <a href="https://twitter.com/intent/tweet?url={{ urlencode(request()->url()) }}&text={{ urlencode($berita->judul) }}" target="_blank" class="btn btn-outline-info btn-sm rounded-circle">
                                <i class="fab fa-twitter"></i>
                            </a>
                            <a href="https://wa.me/?text={{ urlencode($berita->judul . ' ' . request()->url()) }}" target="_blank" class="btn btn-outline-success btn-sm rounded-circle">
                                <i class="fab fa-whatsapp"></i>
                            </a>
                            <a href="mailto:?subject={{ urlencode($berita->judul) }}&body={{ urlencode('Baca berita ini: ' . request()->url()) }}" class="btn btn-outline-danger btn-sm rounded-circle">
                                <i class="far fa-envelope"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="col-lg-4">
                <!-- Berita Lainnya -->
                <div class="card border-0 shadow-sm mb-4" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-white py-3">
                        <h5 class="mb-0"><i class="fas fa-newspaper me-2 text-primary"></i>Berita Lainnya</h5>
                    </div>
                    <div class="card-body">
                        @forelse($beritaLainnya as $item)
                        <div class="d-flex gap-3 mb-3 pb-3 border-bottom">
                            <div class="flex-shrink-0">
                                @if($item->gambar)
                                    <img src="{{ Storage::url($item->gambar) }}" alt="{{ $item->judul }}" style="width: 70px; height: 70px; object-fit: cover; border-radius: 8px;">
                                @else
                                    <div class="bg-light d-flex align-items-center justify-content-center" style="width: 70px; height: 70px; border-radius: 8px;">
                                        <i class="fas fa-newspaper text-muted"></i>
                                    </div>
                                @endif
                            </div>
                            <div class="flex-grow-1">
                                <h6 class="mb-1">
                                    <a href="{{ route('berita.detail', $item->id) }}" class="text-decoration-none text-dark hover-primary">
                                        {{ Str::limit($item->judul, 50) }}
                                    </a>
                                </h6>
                                <small class="text-muted">
                                    <i class="far fa-calendar-alt me-1"></i>{{ $item->tanggal->format('d M Y') }}
                                </small>
                            </div>
                        </div>
                        @empty
                        <p class="text-muted text-center mb-0">Tidak ada berita lainnya</p>
                        @endforelse

                        <div class="text-center mt-3">
                            <a href="{{ route('berita.all') }}" class="btn btn-outline-primary btn-sm">
                                Lihat Semua Berita <i class="fas fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Info Kontak -->
                <div class="card border-0 shadow-sm bg-primary text-white" data-aos="fade-up" data-aos-delay="200">
                    <div class="card-body p-4">
                        <h5 class="mb-3"><i class="fas fa-phone-alt me-2"></i>Hubungi Kami</h5>
                        <p class="mb-2"><i class="fas fa-map-marker-alt me-2"></i> {{ $profil->alamat ?? 'Jl. Kesehatan No. 123' }}</p>
                        <p class="mb-2"><i class="fas fa-phone me-2"></i> {{ $profil->telepon ?? '(0405) 123456' }}</p>
                        <p class="mb-2"><i class="fas fa-envelope me-2"></i> {{ $profil->email ?? 'info@puskesmaskatoi.com' }}</p>
                        <hr class="border-white opacity-25">
                        <a href="{{ route('pelayanan.index') }}" class="btn btn-light w-100">
                            <i class="fas fa-calendar-check me-2"></i>Daftar Pelayanan Online
                        </a>
                    </div>
                </div>
            </div>
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

    .berita-content {
        font-size: 1.1rem;
        line-height: 1.8;
    }

    .berita-content p {
        margin-bottom: 1.5rem;
    }

    .hover-primary:hover {
        color: var(--primary-color) !important;
    }

    .btn-sm.rounded-circle {
        width: 35px;
        height: 35px;
        padding: 0;
        display: inline-flex;
        align-items: center;
        justify-content: center;
    }

    @media (max-width: 768px) {
        .display-5 {
            font-size: 1.8rem;
        }

        .berita-content {
            font-size: 1rem;
        }
    }
</style>
@endpush
