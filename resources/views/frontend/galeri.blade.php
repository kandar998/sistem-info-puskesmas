@extends('layouts.app')

@section('title', 'Galeri Kegiatan')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">GALERI KEGIATAN</h1>
        <p class="lead">Dokumentasi kegiatan dan pelayanan Puskesmas Katoi</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Galeri</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Filter Section -->
<section class="py-4 bg-light">
    <div class="container">
        <div class="row justify-content-center" data-aos="fade-up">
            <div class="col-md-8">
                <div class="btn-group w-100" role="group">
                    <button type="button" class="btn btn-outline-primary active filter-btn" data-filter="all">
                        <i class="fas fa-images me-2"></i>Semua
                    </button>
                    <button type="button" class="btn btn-outline-primary filter-btn" data-filter="foto">
                        <i class="fas fa-camera me-2"></i>Foto
                    </button>
                    <button type="button" class="btn btn-outline-primary filter-btn" data-filter="video">
                        <i class="fas fa-video me-2"></i>Video
                    </button>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Galeri Grid -->
<section class="py-5">
    <div class="container">
        <div class="row g-4" id="galeri-grid">
            @forelse($galeris as $galeri)
            <div class="col-lg-4 col-md-6 galeri-item" data-type="{{ $galeri->tipe }}" data-aos="zoom-in" data-aos-delay="{{ $loop->index * 50 }}">
                <div class="card border-0 shadow-sm h-100">
                    @if($galeri->tipe == 'foto')
                        <div class="galeri-image-wrapper">
                            <img src="{{ Storage::url($galeri->file) }}"
                                 class="card-img-top"
                                 alt="{{ $galeri->judul }}"
                                 style="height: 250px; object-fit: cover;">
                            <div class="galeri-overlay">
                                <button type="button" class="btn btn-light btn-lg rounded-circle" data-bs-toggle="modal" data-bs-target="#modal{{ $galeri->id }}">
                                    <i class="fas fa-search-plus"></i>
                                </button>
                            </div>
                        </div>
                    @else
                        <div class="galeri-image-wrapper">
                            @if($galeri->thumbnail)
                                <img src="{{ Storage::url($galeri->thumbnail) }}"
                                     class="card-img-top"
                                     alt="{{ $galeri->judul }}"
                                     style="height: 250px; object-fit: cover;">
                            @else
                                <div class="bg-light d-flex align-items-center justify-content-center" style="height: 250px;">
                                    <i class="fas fa-video fa-4x text-primary"></i>
                                </div>
                            @endif
                            <div class="galeri-overlay">
                                <a href="{{ $galeri->file }}" target="_blank" class="btn btn-light btn-lg rounded-circle">
                                    <i class="fas fa-play"></i>
                                </a>
                            </div>
                            <span class="badge bg-danger position-absolute top-0 end-0 m-3">
                                <i class="fas fa-video me-1"></i>Video
                            </span>
                        </div>
                    @endif
                    <div class="card-body">
                        <h6 class="card-title">{{ $galeri->judul }}</h6>
                        @if($galeri->deskripsi)
                            <p class="card-text small text-muted">{{ Str::limit($galeri->deskripsi, 80) }}</p>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Modal untuk Foto -->
            @if($galeri->tipe == 'foto')
            <div class="modal fade" id="modal{{ $galeri->id }}" tabindex="-1">
                <div class="modal-dialog modal-lg modal-dialog-centered">
                    <div class="modal-content">
                        <div class="modal-header border-0">
                            <h5 class="modal-title">{{ $galeri->judul }}</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                        </div>
                        <div class="modal-body text-center p-0">
                            <img src="{{ Storage::url($galeri->file) }}" class="img-fluid" alt="{{ $galeri->judul }}">
                        </div>
                        @if($galeri->deskripsi)
                        <div class="modal-footer border-0">
                            <p class="text-muted mb-0">{{ $galeri->deskripsi }}</p>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
            @endif
            @empty
            <div class="col-12 text-center py-5" data-aos="fade-up">
                <div class="empty-state">
                    <i class="fas fa-images fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum Ada Galeri</h4>
                    <p class="text-muted">Belum ada foto atau video yang diupload.</p>
                </div>
            </div>
            @endforelse
        </div>

        <!-- Pagination -->
        @if($galeris->hasPages())
        <div class="d-flex justify-content-center mt-5" data-aos="fade-up">
            {{ $galeris->links() }}
        </div>
        @endif
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

    .galeri-image-wrapper {
        position: relative;
        overflow: hidden;
        cursor: pointer;
    }

    .galeri-overlay {
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background: rgba(0,0,0,0.5);
        display: flex;
        align-items: center;
        justify-content: center;
        opacity: 0;
        transition: opacity 0.3s ease;
    }

    .galeri-image-wrapper:hover .galeri-overlay {
        opacity: 1;
    }

    .galeri-overlay .btn {
        transform: scale(0.8);
        transition: transform 0.3s ease;
    }

    .galeri-image-wrapper:hover .galeri-overlay .btn {
        transform: scale(1);
    }

    .filter-btn {
        border-radius: 0;
        padding: 12px;
        transition: all 0.3s;
    }

    .filter-btn:first-child {
        border-top-left-radius: 30px;
        border-bottom-left-radius: 30px;
    }

    .filter-btn:last-child {
        border-top-right-radius: 30px;
        border-bottom-right-radius: 30px;
    }

    .filter-btn.active {
        background: var(--primary-color);
        color: white;
        border-color: var(--primary-color);
    }

    .modal-content {
        border: none;
        background: transparent;
    }

    .modal-header {
        background: white;
        border-top-left-radius: 12px;
        border-top-right-radius: 12px;
    }

    .modal-footer {
        background: white;
        border-bottom-left-radius: 12px;
        border-bottom-right-radius: 12px;
    }

    .modal-body {
        background: rgba(0,0,0,0.9);
    }

    .empty-state {
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 30vh;
        }

        .display-4 {
            font-size: 2rem;
        }

        .filter-btn {
            padding: 8px;
            font-size: 0.9rem;
        }

        .filter-btn i {
            margin-right: 0.3rem;
        }
    }
</style>
@endpush

@push('scripts')
<script>
    // Filter galeri
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            // Update active state
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            this.classList.add('active');

            const filter = this.dataset.filter;
            const items = document.querySelectorAll('.galeri-item');

            items.forEach(item => {
                if (filter === 'all' || item.dataset.type === filter) {
                    item.style.display = 'block';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush
