@extends('admin.layouts.admin')

@section('title', 'Tambah Jadwal Posyandu')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-plus-circle me-2"></i>Tambah Jadwal Posyandu
            </h1>
            <p class="text-muted small">Buat jadwal kegiatan posyandu baru</p>
        </div>
        <a href="{{ route('admin.jadwal-posyandu.index') }}" class="btn btn-secondary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.jadwal-posyandu.store') }}" method="POST">
                @csrf

                <div class="row g-4">
                    <!-- Nama Posyandu -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-home text-primary me-2"></i>Nama Posyandu
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('nama_posyandu') is-invalid @enderror"
                                   name="nama_posyandu"
                                   value="{{ old('nama_posyandu') }}"
                                   placeholder="Contoh: Posyandu Mawar"
                                   required>
                            @error('nama_posyandu')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Lokasi -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-map-marker-alt text-primary me-2"></i>Lokasi
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('lokasi') is-invalid @enderror"
                                   name="lokasi"
                                   value="{{ old('lokasi') }}"
                                   placeholder="Contoh: Desa Katoi, RT 01/RW 02"
                                   required>
                            @error('lokasi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Tanggal -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>Tanggal
                                <span class="text-danger">*</span>
                            </label>
                            <input type="date"
                                   class="form-control @error('tanggal') is-invalid @enderror"
                                   name="tanggal"
                                   value="{{ old('tanggal', now()->format('Y-m-d')) }}"
                                   min="{{ now()->format('Y-m-d') }}"
                                   required>
                            @error('tanggal')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jam Mulai -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock text-primary me-2"></i>Jam Mulai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time"
                                   class="form-control @error('jam_mulai') is-invalid @enderror"
                                   name="jam_mulai"
                                   value="{{ old('jam_mulai', '08:00') }}"
                                   required>
                            @error('jam_mulai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Jam Selesai -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-clock text-primary me-2"></i>Jam Selesai
                                <span class="text-danger">*</span>
                            </label>
                            <input type="time"
                                   class="form-control @error('jam_selesai') is-invalid @enderror"
                                   name="jam_selesai"
                                   value="{{ old('jam_selesai', '12:00') }}"
                                   required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Keterangan -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-info-circle text-primary me-2"></i>Keterangan
                            </label>
                            <textarea class="form-control @error('keterangan') is-invalid @enderror"
                                      name="keterangan"
                                      rows="3"
                                      placeholder="Contoh: Membawa KMS, imunisasi, vitamin A, dll">{{ old('keterangan') }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Tips Card -->
                <div class="alert alert-primary bg-light border-0 mt-4">
                    <div class="d-flex">
                        <i class="fas fa-lightbulb fa-2x text-primary me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Tips Pengisian</h6>
                            <ul class="small mb-0">
                                <li>Pastikan nama posyandu ditulis dengan lengkap</li>
                                <li>Sertakan alamat detail untuk memudahkan masyarakat menemukan lokasi</li>
                                <li>Isi keterangan dengan perlengkapan yang perlu dibawa</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.jadwal-posyandu.index') }}"
                       class="btn btn-light rounded-pill px-4">
                        <i class="fas fa-times me-2"></i>Batal
                    </a>
                    <button type="submit" class="btn btn-primary rounded-pill px-5">
                        <i class="fas fa-save me-2"></i>Simpan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .form-group {
        margin-bottom: 1rem;
    }

    .form-label {
        margin-bottom: 0.5rem;
        font-size: 0.9rem;
    }

    .form-control, .form-select {
        border-radius: 12px;
        padding: 0.7rem 1.2rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 4px rgba(13, 110, 253, 0.1);
    }

    .btn {
        padding: 0.7rem 1.8rem;
        font-weight: 500;
        border-radius: 50px;
    }

    .alert {
        border-radius: 15px;
    }

    textarea.form-control {
        min-height: 100px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn {
            padding: 0.5rem 1.2rem;
            font-size: 0.9rem;
        }

        h1.h3 {
            font-size: 1.3rem;
        }
    }
</style>
@endpush
