@extends('admin.layouts.admin')

@section('title', 'Edit Jadwal Posyandu')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i>Edit Jadwal Posyandu
            </h1>
            <p class="text-muted small">Ubah data jadwal posyandu</p>
        </div>
        <a href="{{ route('admin.jadwal-posyandu.index') }}" class="btn btn-secondary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.jadwal-posyandu.update', $jadwalPosyandu->id) }}" method="POST">
                @csrf
                @method('PUT')

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
                                   value="{{ old('nama_posyandu', $jadwalPosyandu->nama_posyandu) }}"
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
                                   value="{{ old('lokasi', $jadwalPosyandu->lokasi) }}"
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
                                   value="{{ old('tanggal', $jadwalPosyandu->tanggal->format('Y-m-d')) }}"
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
                                   value="{{ old('jam_mulai', $jadwalPosyandu->jam_mulai) }}"
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
                                   value="{{ old('jam_selesai', $jadwalPosyandu->jam_selesai) }}"
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
                                      placeholder="Contoh: Membawa KMS, imunisasi, vitamin A, dll">{{ old('keterangan', $jadwalPosyandu->keterangan) }}</textarea>
                            @error('keterangan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="alert alert-warning bg-light border-0 mt-4">
                    <div class="d-flex">
                        <i class="fas fa-exclamation-triangle fa-2x text-warning me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Perhatian</h6>
                            <p class="small mb-0">
                                Perubahan jadwal akan langsung tampil di website. Pastikan data yang diubah sudah benar.
                            </p>
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
                        <i class="fas fa-save me-2"></i>Update
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Current Schedule Card -->
    <div class="card border-0 shadow-sm mt-4">
        <div class="card-header bg-white py-3">
            <h6 class="mb-0 fw-bold">
                <i class="fas fa-info-circle text-primary me-2"></i>Informasi Jadwal Saat Ini
            </h6>
        </div>
        <div class="card-body">
            <div class="row">
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Nama Posyandu</small>
                    <strong>{{ $jadwalPosyandu->nama_posyandu }}</strong>
                </div>
                <div class="col-md-3 col-6 mb-3">
                    <small class="text-muted d-block">Lokasi</small>
                    <strong>{{ $jadwalPosyandu->lokasi }}</strong>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <small class="text-muted d-block">Tanggal</small>
                    <strong>{{ $jadwalPosyandu->tanggal->format('d/m/Y') }}</strong>
                </div>
                <div class="col-md-2 col-6 mb-3">
                    <small class="text-muted d-block">Jam</small>
                    <strong>{{ substr($jadwalPosyandu->jam_mulai, 0, 5) }} - {{ substr($jadwalPosyandu->jam_selesai, 0, 5) }}</strong>
                </div>
                <div class="col-md-2 col-12 mb-3">
                    <small class="text-muted d-block">Dibuat Pada</small>
                    <strong>{{ $jadwalPosyandu->created_at->format('d/m/Y H:i') }}</strong>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    /* Sama dengan create view */
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

    .card-header {
        border-bottom: 1px solid rgba(0,0,0,0.05);
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn {
            padding: 0.5rem 1.2rem;
        }

        h1.h3 {
            font-size: 1.3rem;
        }

        strong {
            font-size: 0.9rem;
        }
    }
</style>
@endpush
