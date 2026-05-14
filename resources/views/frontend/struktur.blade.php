@extends('layouts.app')

@section('title', 'Struktur Organisasi')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">STRUKTUR ORGANISASI</h1>
        <p class="lead">Susunan kepengurusan Puskesmas Katoi</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Struktur Organisasi</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Struktur Section -->
<section class="py-5">
    <div class="container">
        <!-- Diagram Struktur -->
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="section-title">BAGAN STRUKTUR ORGANISASI</h2>
        </div>

        @if($strukturs->isNotEmpty())
            <!-- Kepala Puskesmas -->
            @php
                $kepala = $strukturs->where('jabatan', 'LIKE', '%Kepala%')->first();
                $other = $strukturs->where('jabatan', 'NOT LIKE', '%Kepala%');
            @endphp

            @if($kepala)
            <div class="row justify-content-center mb-5" data-aos="fade-up">
                <div class="col-lg-4 col-md-6">
                    <div class="card border-0 shadow-lg text-center position-relative">
                        <div class="position-absolute top-0 start-50 translate-middle">
                            <span class="badge bg-primary px-4 py-2 rounded-pill">KEPALA PUSKESMAS</span>
                        </div>
                        <div class="card-body pt-5">
                            <div class="mb-4">
                                @if($kepala->foto)
                                    <img src="{{ Storage::url($kepala->foto) }}"
                                         alt="{{ $kepala->nama }}"
                                         class="rounded-circle img-fluid profile-image border-primary"
                                         style="width: 200px; height: 200px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto profile-placeholder border-primary"
                                         style="width: 200px; height: 200px;">
                                        <i class="fas fa-user-tie fa-5x text-primary"></i>
                                    </div>
                                @endif
                            </div>
                            <h3 class="fw-bold">{{ $kepala->nama }}</h3>
                            <p class="text-primary mb-0">{{ $kepala->jabatan }}</p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Staff Lainnya -->
            <div class="row g-4">
                @foreach($other as $struktur)
                <div class="col-lg-3 col-md-6" data-aos="fade-up" data-aos-delay="{{ $loop->iteration * 50 }}">
                    <div class="card border-0 shadow-sm h-100 hover-card">
                        <div class="card-body text-center">
                            <div class="position-relative mb-4">
                                @if($struktur->foto)
                                    <img src="{{ Storage::url($struktur->foto) }}"
                                         alt="{{ $struktur->nama }}"
                                         class="rounded-circle img-fluid staff-image border-primary"
                                         style="width: 150px; height: 150px; object-fit: cover;">
                                @else
                                    <div class="bg-light rounded-circle d-flex align-items-center justify-content-center mx-auto staff-placeholder border-primary"
                                         style="width: 150px; height: 150px;">
                                        <i class="fas fa-user fa-4x text-primary"></i>
                                    </div>
                                @endif
                                <div class="position-absolute bottom-0 end-0 translate-middle">
                                    <span class="badge bg-primary rounded-circle p-2">
                                        <i class="fas fa-check"></i>
                                    </span>
                                </div>
                            </div>
                            <h5 class="fw-bold">{{ $struktur->nama }}</h5>
                            <p class="text-primary mb-0">{{ $struktur->jabatan }}</p>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-5" data-aos="fade-up">
                <div class="empty-state">
                    <i class="fas fa-sitemap fa-5x text-muted mb-4"></i>
                    <h4 class="text-muted">Belum Ada Data Struktur</h4>
                    <p class="text-muted">Data struktur organisasi belum tersedia.</p>
                </div>
            </div>
        @endif

        <!-- Diagram Garis (Optional) -->
        <div class="mt-5 text-center" data-aos="fade-up">
            <div class="card border-0 bg-light">
                <div class="card-body p-5">
                    <h5 class="mb-4">BAGAN ORGANISASI</h5>
                    <div class="org-chart">
                        <div class="org-level">
                            <span class="org-node">KEPALA PUSKESMAS</span>
                        </div>
                        <div class="org-level">
                            <span class="org-connector">│</span>
                        </div>
                        <div class="org-level d-flex justify-content-center gap-3">
                            <div class="org-node">KASUBAG TU</div>
                            <div class="org-node">KOORDINATOR PELAYANAN</div>
                        </div>
                        <div class="org-level">
                            <span class="org-connector">│</span>
                        </div>
                        <div class="org-level d-flex justify-content-center gap-2 flex-wrap">
                            <span class="org-node-small">PONKESDES</span>
                            <span class="org-node-small">POSYANDU</span>
                            <span class="org-node-small">UKM</span>
                            <span class="org-node-small">UKP</span>
                            <span class="org-node-small">FARMASI</span>
                        </div>
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

    .hover-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }

    .hover-card:hover {
        transform: translateY(-10px);
        box-shadow: 0 15px 30px rgba(0,0,0,0.1) !important;
    }

    /* PERBAIKAN: Style untuk border gambar */
    .profile-image,
    .profile-placeholder,
    .staff-image,
    .staff-placeholder {
        border: 4px solid var(--primary-color) !important;
        padding: 3px;
        background: white;
    }

    .profile-image,
    .profile-placeholder {
        border-width: 4px !important;
    }

    .staff-image,
    .staff-placeholder {
        border-width: 3px !important;
    }

    .profile-placeholder,
    .staff-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        background: #f8f9fa;
    }

    .org-chart {
        font-size: 0.9rem;
    }

    .org-level {
        margin: 20px 0;
        position: relative;
    }

    .org-node {
        display: inline-block;
        padding: 10px 20px;
        background: var(--primary-color);
        color: white;
        border-radius: 30px;
        font-weight: bold;
        margin: 0 10px;
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
        border: 2px solid white;
    }

    .org-node-small {
        display: inline-block;
        padding: 8px 15px;
        background: #e9ecef;
        color: #333;
        border-radius: 20px;
        margin: 5px;
        font-size: 0.85rem;
        border: 1px solid #dee2e6;
        transition: all 0.3s ease;
    }

    .org-node-small:hover {
        background: var(--primary-color);
        color: white;
        transform: translateY(-3px);
        box-shadow: 0 5px 15px rgba(0,123,255,0.3);
    }

    .org-connector {
        display: block;
        color: var(--primary-color);
        font-size: 1.5rem;
        line-height: 0.5;
    }

    .empty-state {
        padding: 60px 20px;
        background: #f8f9fa;
        border-radius: 12px;
    }

    /* Responsive */
    @media (max-width: 768px) {
        .hero-section {
            min-height: 30vh;
        }

        .display-4 {
            font-size: 2rem;
        }

        .org-node {
            display: block;
            margin: 10px auto;
            width: fit-content;
        }

        .org-level.d-flex {
            flex-direction: column;
        }

        .profile-image,
        .profile-placeholder {
            width: 150px !important;
            height: 150px !important;
        }

        .profile-placeholder i {
            font-size: 3rem !important;
        }

        .staff-image,
        .staff-placeholder {
            width: 120px !important;
            height: 120px !important;
        }
    }
</style>
@endpush
