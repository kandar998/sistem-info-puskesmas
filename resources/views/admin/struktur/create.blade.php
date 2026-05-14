@extends('admin.layouts.admin')

@section('title', 'Tambah Data Struktur')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle me-2"></i>Tambah Data Struktur
        </h1>
        <a href="{{ route('admin.struktur.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Tambah Data
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.struktur.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap <span class="text-danger">*</span></label>
                            <input type="text" name="nama" class="form-control @error('nama') is-invalid @enderror"
                                   value="{{ old('nama') }}" placeholder="Masukkan nama lengkap" required>
                            @error('nama')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Jabatan <span class="text-danger">*</span></label>
                            <input type="text" name="jabatan" class="form-control @error('jabatan') is-invalid @enderror"
                                   value="{{ old('jabatan') }}" placeholder="Contoh: Kepala Puskesmas" required>
                            @error('jabatan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Urutan Tampil <span class="text-danger">*</span></label>
                            <input type="number" name="urutan" class="form-control @error('urutan') is-invalid @enderror"
                                   value="{{ old('urutan', $nextUrutan ?? 1) }}" min="1" required>
                            @error('urutan')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Urutan tampil di halaman depan (semakin kecil semakin atas)</small>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">Foto</label>
                            <input type="file" name="foto" class="form-control @error('foto') is-invalid @enderror"
                                   accept="image/*" id="fotoInput">
                            @error('foto')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Format: JPG, PNG. Maksimal 2MB. Ukuran ideal: 300x300px</small>

                            <div class="mt-3 text-center" id="previewContainer" style="display: none;">
                                <img id="imagePreview" src="#" alt="Preview" class="img-thumbnail" style="max-height: 200px;">
                            </div>
                        </div>

                        <hr>

                        <div class="d-flex justify-content-end gap-2">
                            <button type="reset" class="btn btn-secondary">
                                <i class="fas fa-undo me-2"></i>Reset
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save me-2"></i>Simpan Data
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
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips:</strong>
                        <ul class="mb-0 mt-2">
                            <li>Gunakan foto dengan latar belakang yang rapi</li>
                            <li>Pastikan wajah terlihat jelas</li>
                            <li>Ukuran file maksimal 2MB</li>
                            <li>Format yang didukung: JPG, PNG</li>
                        </ul>
                    </div>

                    <hr>

                    <div class="text-center">
                        <div class="bg-light p-3 rounded">
                            <i class="fas fa-sitemap fa-3x text-primary mb-2"></i>
                            <h6>Struktur Organisasi</h6>
                            <p class="small text-muted">Tambahkan data struktural untuk ditampilkan di halaman depan</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Image preview
    document.getElementById('fotoInput').addEventListener('change', function(e) {
        const previewContainer = document.getElementById('previewContainer');
        const imagePreview = document.getElementById('imagePreview');

        if (e.target.files && e.target.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                imagePreview.src = e.target.result;
                previewContainer.style.display = 'block';
            }

            reader.readAsDataURL(e.target.files[0]);
        } else {
            previewContainer.style.display = 'none';
        }
    });
</script>
@endpush
