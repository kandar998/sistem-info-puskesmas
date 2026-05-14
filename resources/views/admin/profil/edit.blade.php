@extends('admin.layouts.admin')

@section('title', 'Edit Profil Puskesmas')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-building me-2"></i>Edit Profil Puskesmas
        </h1>
        <a href="{{ route('home') }}" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-eye me-2"></i>Lihat Halaman Depan
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Profil
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.profil.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Nama Puskesmas <span class="text-danger">*</span></label>
                                <input type="text" name="nama_puskesmas" class="form-control @error('nama_puskesmas') is-invalid @enderror"
                                       value="{{ old('nama_puskesmas', $profil->nama_puskesmas ?? '') }}" required>
                                @error('nama_puskesmas')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Telepon <span class="text-danger">*</span></label>
                                <input type="text" name="telepon" class="form-control @error('telepon') is-invalid @enderror"
                                       value="{{ old('telepon', $profil->telepon ?? '') }}" required>
                                @error('telepon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Email <span class="text-danger">*</span></label>
                                <input type="email" name="email" class="form-control @error('email') is-invalid @enderror"
                                       value="{{ old('email', $profil->email ?? '') }}" required>
                                @error('email')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Alamat <span class="text-danger">*</span></label>
                                <textarea name="alamat" class="form-control @error('alamat') is-invalid @enderror"
                                          rows="2" required>{{ old('alamat', $profil->alamat ?? '') }}</textarea>
                                @error('alamat')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-12 mb-3">
                                <label class="form-label">Deskripsi <span class="text-danger">*</span></label>
                                <textarea name="deskripsi" class="form-control @error('deskripsi') is-invalid @enderror"
                                          rows="4" required>{{ old('deskripsi', $profil->deskripsi ?? '') }}</textarea>
                                @error('deskripsi')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <hr>

                        <h6 class="mb-3">Upload Gambar</h6>

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Logo Puskesmas</label>
                                <input type="file" name="logo" class="form-control @error('logo') is-invalid @enderror"
                                       accept="image/*">
                                @error('logo')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG. Maksimal 2MB</small>

                                @if($profil && $profil->logo)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($profil->logo) }}" alt="Logo" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Foto Background</label>
                                <input type="file" name="foto_background" class="form-control @error('foto_background') is-invalid @enderror"
                                       accept="image/*">
                                @error('foto_background')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">Format: JPG, PNG. Maksimal 5MB</small>

                                @if($profil && $profil->foto_background)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($profil->foto_background) }}" alt="Background" class="img-thumbnail" style="max-height: 100px;">
                                </div>
                                @endif
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Perubahan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Preview
                    </h6>
                </div>
                <div class="card-body text-center">
                    @if($profil && $profil->logo)
                        <img src="{{ Storage::url($profil->logo) }}" alt="Logo" class="img-fluid mb-3" style="max-height: 120px;">
                    @else
                        <div class="bg-light p-4 rounded mb-3">
                            <i class="fas fa-image fa-4x text-muted"></i>
                            <p class="text-muted mt-2">Belum ada logo</p>
                        </div>
                    @endif

                    <h5>{{ $profil->nama_puskesmas ?? 'PUSKESMAS KATOI' }}</h5>
                    <p class="text-muted small">{{ $profil->alamat ?? 'Jl. Kesehatan No. 123' }}</p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Preview image before upload
    document.querySelector('input[name="logo"]').addEventListener('change', function(e) {
        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();
            reader.onload = function(e) {
                // Optional: show preview
            }
            reader.readAsDataURL(e.target.files[0]);
        }
    });
</script>
@endpush
