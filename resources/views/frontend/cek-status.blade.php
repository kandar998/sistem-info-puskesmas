@extends('layouts.app')

@section('title', 'Cek Status Pendaftaran')

@section('content')
<!-- Hero Section -->
<section class="hero-section" style="min-height: 40vh; background: linear-gradient(rgba(0, 0, 0, 0.7), rgba(0, 0, 0, 0.7)), url('{{ $profil->foto_background ?? asset('images/default-bg.jpg') }}');">
    <div class="container text-center" data-aos="fade-up">
        <h1 class="display-4 fw-bold mb-4">CEK STATUS PENDAFTARAN</h1>
        <p class="lead">Lihat status pendaftaran pelayanan online Anda</p>
        <nav aria-label="breadcrumb" class="mt-4">
            <ol class="breadcrumb justify-content-center bg-transparent">
                <li class="breadcrumb-item"><a href="{{ route('home') }}" class="text-white">Beranda</a></li>
                <li class="breadcrumb-item"><a href="{{ route('pelayanan.index') }}" class="text-white">Pelayanan</a></li>
                <li class="breadcrumb-item active text-white" aria-current="page">Cek Status</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Cek Status Section -->
<section class="py-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <!-- Form Cek Status -->
                <div class="card border-0 shadow-lg mb-5" data-aos="fade-up">
                    <div class="card-header bg-primary text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-search me-2"></i>Cek Status Pendaftaran</h4>
                    </div>
                    <div class="card-body p-4">
                        <form action="{{ route('pelayanan.cek-status') }}" method="POST">
                            @csrf
                            <div class="row g-3">
                                <div class="col-md-9">
                                    <label class="form-label">Masukkan Nomor Rekam Medis</label>
                                    <input type="text" name="no_rm" class="form-control form-control-lg"
                                           placeholder="Contoh: RM-202312-0001" value="{{ old('no_rm') }}" required>
                                </div>
                                <div class="col-md-3 d-flex align-items-end">
                                    <button type="submit" class="btn btn-primary btn-lg w-100">
                                        <i class="fas fa-search me-2"></i>Cari
                                    </button>
                                </div>
                            </div>
                            <small class="text-muted">* Nomor Rekam Medis didapatkan setelah mendaftar online</small>
                        </form>
                    </div>
                </div>

                <!-- Hasil Pencarian -->
                @if(isset($pelayanan))
                <div class="card border-0 shadow-lg" data-aos="fade-up" data-aos-delay="100">
                    <div class="card-header bg-success text-white py-3">
                        <h4 class="mb-0"><i class="fas fa-info-circle me-2"></i>Hasil Pencarian</h4>
                    </div>
                    <div class="card-body p-4">
                        <!-- Status Badge -->
                        <div class="text-center mb-4">
                            @if($pelayanan->status == 'pending')
                                <div class="display-1 text-warning">
                                    <i class="fas fa-hourglass-half"></i>
                                </div>
                                <h3 class="text-warning mt-3">PENDING</h3>
                                <p class="text-muted">Pendaftaran Anda sedang menunggu verifikasi</p>
                            @elseif($pelayanan->status == 'diproses')
                                <div class="display-1 text-info">
                                    <i class="fas fa-spinner fa-spin"></i>
                                </div>
                                <h3 class="text-info mt-3">DIPROSES</h3>
                                <p class="text-muted">Pendaftaran Anda sedang diproses</p>
                            @elseif($pelayanan->status == 'selesai')
                                <div class="display-1 text-success">
                                    <i class="fas fa-check-circle"></i>
                                </div>
                                <h3 class="text-success mt-3">SELESAI</h3>
                                <p class="text-muted">Pendaftaran Anda telah selesai diproses</p>
                            @elseif($pelayanan->status == 'ditolak')
                                <div class="display-1 text-danger">
                                    <i class="fas fa-times-circle"></i>
                                </div>
                                <h3 class="text-danger mt-3">DITOLAK</h3>
                                <p class="text-muted">Pendaftaran Anda ditolak</p>
                            @endif
                        </div>

                        <!-- Timeline -->
                        <div class="timeline mb-4">
                            <div class="timeline-item">
                                <div class="timeline-icon bg-primary">
                                    <i class="fas fa-file-medical"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Pendaftaran</h6>
                                    <small class="text-muted">{{ $pelayanan->created_at->format('d F Y H:i') }}</small>
                                    <p class="mb-0">Pendaftaran berhasil dibuat</p>
                                </div>
                            </div>

                            @if($pelayanan->status != 'pending')
                            <div class="timeline-item">
                                <div class="timeline-icon bg-info">
                                    <i class="fas fa-check"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Status Diperbarui</h6>
                                    <small class="text-muted">{{ $pelayanan->updated_at->format('d F Y H:i') }}</small>
                                    <p class="mb-0">Status: {{ $pelayanan->status }}</p>
                                </div>
                            </div>
                            @endif

                            @if($pelayanan->catatan_admin)
                            <div class="timeline-item">
                                <div class="timeline-icon bg-warning">
                                    <i class="fas fa-comment"></i>
                                </div>
                                <div class="timeline-content">
                                    <h6 class="mb-1">Catatan Admin</h6>
                                    <p class="mb-0">{{ $pelayanan->catatan_admin }}</p>
                                </div>
                            </div>
                            @endif
                        </div>

                        <!-- Detail Pasien -->
                        <hr>
                        <h5 class="mb-3">Detail Pendaftaran</h5>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">No. Rekam Medis</label>
                                <div class="fw-bold">{{ $pelayanan->no_rm }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">NIK</label>
                                <div>{{ $pelayanan->nik }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Nama Lengkap</label>
                                <div>{{ $pelayanan->nama }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Poli Tujuan</label>
                                <div>{{ $pelayanan->poli_tujuan }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Tanggal Periksa</label>
                                <div>{{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d F Y') }}</div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label class="text-muted small">Keluhan</label>
                                <div>{{ $pelayanan->keluhan }}</div>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <hr>
                        <div class="d-flex justify-content-between gap-2">
                            <a href="{{ route('pelayanan.index') }}" class="btn btn-outline-primary">
                                <i class="fas fa-arrow-left me-2"></i>Kembali
                            </a>
                            <a href="https://wa.me/{{ $profil->telepon ?? '' }}" target="_blank" class="btn btn-success">
                                <i class="fab fa-whatsapp me-2"></i>Hubungi Admin
                            </a>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Jika tidak ditemukan -->
                @if(request()->isMethod('post') && !isset($pelayanan))
                <div class="alert alert-danger text-center" data-aos="fade-up">
                    <i class="fas fa-exclamation-triangle fa-3x mb-3"></i>
                    <h4>Data Tidak Ditemukan</h4>
                    <p>Nomor Rekam Medis yang Anda masukkan tidak ditemukan. Pastikan nomor yang dimasukkan benar.</p>
                    <a href="{{ route('pelayanan.index') }}" class="btn btn-primary mt-2">
                        <i class="fas fa-plus-circle me-2"></i>Daftar Baru
                    </a>
                </div>
                @endif
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

    .display-1 {
        font-size: 5rem;
    }

    /* Timeline */
    .timeline {
        position: relative;
        padding-left: 50px;
    }

    .timeline::before {
        content: '';
        position: absolute;
        left: 25px;
        top: 0;
        bottom: 0;
        width: 2px;
        background: #e9ecef;
    }

    .timeline-item {
        position: relative;
        margin-bottom: 30px;
        position: relative;
    }

    .timeline-icon {
        position: absolute;
        left: -50px;
        top: 0;
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        z-index: 1;
    }

    .timeline-icon.bg-primary { background: var(--primary-color); }
    .timeline-icon.bg-info { background: var(--info-color); }
    .timeline-icon.bg-warning { background: var(--warning-color); }
    .timeline-icon.bg-success { background: var(--success-color); }

    .timeline-content {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 8px;
        margin-left: 15px;
    }

    @media (max-width: 768px) {
        .hero-section {
            min-height: 30vh;
        }

        .display-4 {
            font-size: 2rem;
        }

        .display-1 {
            font-size: 3rem;
        }

        .timeline {
            padding-left: 40px;
        }

        .timeline::before {
            left: 20px;
        }

        .timeline-icon {
            left: -40px;
            width: 30px;
            height: 30px;
            font-size: 0.8rem;
        }
    }
</style>
@endpush
