@extends('admin.layouts.admin')

@section('title', 'Edit Jadwal Pemeriksaan')

@section('content')
<div class="container-fluid">
    <!-- Page Header -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div>
            <h1 class="h3 mb-0 text-gray-800">
                <i class="fas fa-edit me-2"></i>Edit Jadwal Pemeriksaan
            </h1>
            <p class="text-muted small">Ubah data jadwal pemeriksaan</p>
        </div>
        <a href="{{ route('admin.jadwal-pemeriksaan.index') }}" class="btn btn-secondary btn-sm rounded-pill shadow-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Form Card -->
    <div class="card border-0 shadow-sm">
        <div class="card-body p-4">
            <form action="{{ route('admin.jadwal-pemeriksaan.update', $jadwalPemeriksaan->id) }}" method="POST">
                @csrf
                @method('PUT')

                <div class="row g-4">
                    <!-- Poli -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-hospital text-primary me-2"></i>Poli
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('poli') is-invalid @enderror"
                                    name="poli" required>
                                <option value="">Pilih Poli</option>
                                <option value="Umum" {{ ($jadwalPemeriksaan->poli ?? old('poli')) == 'Umum' ? 'selected' : '' }}>Poli Umum</option>
                                <option value="Gigi" {{ ($jadwalPemeriksaan->poli ?? old('poli')) == 'Gigi' ? 'selected' : '' }}>Poli Gigi</option>
                                <option value="Anak" {{ ($jadwalPemeriksaan->poli ?? old('poli')) == 'Anak' ? 'selected' : '' }}>Poli Anak</option>
                                <option value="KB" {{ ($jadwalPemeriksaan->poli ?? old('poli')) == 'KB' ? 'selected' : '' }}>Poli KB</option>
                                <option value="Lansia" {{ ($jadwalPemeriksaan->poli ?? old('poli')) == 'Lansia' ? 'selected' : '' }}>Poli Lansia</option>
                            </select>
                            @error('poli')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Dokter -->
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-user-md text-primary me-2"></i>Nama Dokter
                                <span class="text-danger">*</span>
                            </label>
                            <input type="text"
                                   class="form-control @error('dokter') is-invalid @enderror"
                                   name="dokter"
                                   value="{{ old('dokter', $jadwalPemeriksaan->dokter) }}"
                                   placeholder="Masukkan nama dokter"
                                   required>
                            @error('dokter')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Hari -->
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-calendar-alt text-primary me-2"></i>Hari
                                <span class="text-danger">*</span>
                            </label>
                            <select class="form-select @error('hari') is-invalid @enderror"
                                    name="hari" required>
                                <option value="">Pilih Hari</option>
                                @foreach(['Senin', 'Selasa', 'Rabu', 'Kamis', 'Jumat', 'Sabtu'] as $hari)
                                    <option value="{{ $hari }}"
                                        {{ (old('hari', $jadwalPemeriksaan->hari) == $hari) ? 'selected' : '' }}>
                                        {{ $hari }}
                                    </option>
                                @endforeach
                            </select>
                            @error('hari')
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
                                   value="{{ old('jam_mulai', $jadwalPemeriksaan->jam_mulai) }}"
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
                                   value="{{ old('jam_selesai', $jadwalPemeriksaan->jam_selesai) }}"
                                   required>
                            @error('jam_selesai')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>

                    <!-- Kuota -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label fw-bold">
                                <i class="fas fa-users text-primary me-2"></i>Kuota Pasien
                                <span class="text-danger">*</span>
                            </label>
                            <input type="number"
                                   class="form-control @error('kuota') is-invalid @enderror"
                                   name="kuota"
                                   value="{{ old('kuota', $jadwalPemeriksaan->kuota) }}"
                                   min="1"
                                   max="100"
                                   required>
                            <small class="text-muted">Maksimal 100 pasien per jadwal</small>
                            @error('kuota')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="alert alert-info bg-light border-0 mt-4">
                    <div class="d-flex">
                        <i class="fas fa-info-circle fa-2x text-info me-3"></i>
                        <div>
                            <h6 class="fw-bold mb-1">Informasi</h6>
                            <p class="small mb-0">
                                Jadwal yang sudah diubah akan langsung tampil di halaman utama website.
                                Pastikan data yang dimasukkan sudah benar.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Submit Buttons -->
                <div class="d-flex justify-content-end gap-2 mt-4 pt-3 border-top">
                    <a href="{{ route('admin.jadwal-pemeriksaan.index') }}"
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
        border-radius: 10px;
        padding: 0.6rem 1rem;
        border: 1px solid #e0e0e0;
        transition: all 0.3s ease;
    }

    .form-control:focus, .form-select:focus {
        border-color: #0d6efd;
        box-shadow: 0 0 0 3px rgba(13, 110, 253, 0.1);
    }

    .btn {
        padding: 0.6rem 1.5rem;
        font-weight: 500;
    }

    .alert {
        border-radius: 12px;
    }

    @media (max-width: 768px) {
        .card-body {
            padding: 1.5rem !important;
        }

        .btn {
            padding: 0.5rem 1rem;
        }
    }
</style>
@endpush
