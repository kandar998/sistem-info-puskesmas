@extends('admin.layouts.admin')

@section('title', 'Edit Galeri')

@push('styles')
<style>
    .type-selector {
        display: flex;
        gap: 20px;
        margin-bottom: 30px;
    }

    .type-card {
        flex: 1;
        border: 2px solid #dee2e6;
        border-radius: 12px;
        padding: 30px 20px;
        text-align: center;
        cursor: not-allowed;
        transition: all 0.3s;
        opacity: 0.6;
    }

    .type-card.active {
        border-color: #0d6efd;
        background: #e7f1ff;
        opacity: 1;
    }

    .type-card i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #6c757d;
    }

    .type-card.active i {
        color: #0d6efd;
    }

    .current-file {
        background: #f8f9fa;
        border-radius: 12px;
        padding: 20px;
        margin-bottom: 20px;
    }

    .current-file img {
        max-width: 100%;
        max-height: 200px;
        border-radius: 8px;
        margin-bottom: 15px;
    }

    .current-file .file-info {
        font-size: 0.9rem;
        color: #6c757d;
    }

    .upload-area {
        border: 3px dashed #dee2e6;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        min-height: 250px;
        display: flex;
        align-items: center;
        justify-content: center;
    }

    .upload-area:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }

    .upload-area.has-file {
        border-style: solid;
        border-color: #28a745;
        background: #f0fff4;
    }

    .upload-preview {
        max-width: 100%;
        max-height: 200px;
        object-fit: contain;
    }

    .remove-file {
        position: absolute;
        top: 10px;
        right: 10px;
        background: white;
        border: 1px solid #dc3545;
        border-radius: 50%;
        width: 35px;
        height: 35px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #dc3545;
        transition: all 0.3s;
    }

    .upload-area:hover .remove-file {
        display: flex;
    }

    .video-url-input input {
        font-size: 0.9rem;
    }

    .thumbnail-preview {
        width: 150px;
        height: 100px;
        object-fit: cover;
        border-radius: 5px;
        margin-top: 10px;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-edit me-2"></i>Edit Galeri
        </h1>
        <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Edit Galeri</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.update', $galeri->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Tipe (Readonly) -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipe Konten</label>
                            <div class="type-selector">
                                <div class="type-card {{ $galeri->tipe == 'foto' ? 'active' : '' }}">
                                    <i class="fas fa-camera"></i>
                                    <h5>Foto</h5>
                                </div>
                                <div class="type-card {{ $galeri->tipe == 'video' ? 'active' : '' }}">
                                    <i class="fas fa-video"></i>
                                    <h5>Video</h5>
                                </div>
                            </div>
                            <small class="text-muted">Tipe konten tidak dapat diubah</small>
                        </div>

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-8">
                                <!-- Judul -->
                                <div class="mb-4">
                                    <label for="judul" class="form-label fw-bold">Judul <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                           id="judul"
                                           name="judul"
                                           value="{{ old('judul', $galeri->judul) }}"
                                           placeholder="Masukkan judul">
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Deskripsi -->
                                <div class="mb-4">
                                    <label for="deskripsi" class="form-label fw-bold">Deskripsi</label>
                                    <textarea class="form-control @error('deskripsi') is-invalid @enderror"
                                              id="deskripsi"
                                              name="deskripsi"
                                              rows="5"
                                              placeholder="Masukkan deskripsi (opsional)">{{ old('deskripsi', $galeri->deskripsi) }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-4">
                                @if($galeri->tipe == 'foto')
                                    <!-- Current Photo -->
                                    <div class="current-file mb-4">
                                        <label class="form-label fw-bold">Foto Saat Ini</label>
                                        <img src="{{ Storage::url($galeri->file) }}" alt="Current Photo" class="img-fluid">
                                        <div class="file-info mt-2">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Klik di bawah untuk mengganti foto
                                        </div>
                                    </div>

                                    <!-- Upload New Photo -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Ganti Foto</label>
                                        <div class="upload-area" onclick="document.getElementById('file_foto').click()">
                                            <input type="file"
                                                   class="d-none"
                                                   id="file_foto"
                                                   name="file"
                                                   accept="image/jpeg,image/png,image/jpg"
                                                   onchange="previewFile(this)">
                                            <div id="preview-container">
                                                <div class="preview-placeholder">
                                                    <i class="fas fa-cloud-upload-alt fa-4x mb-3 text-muted"></i>
                                                    <h6>Klik untuk upload foto baru</h6>
                                                    <p class="text-muted small mb-0">Format: JPG, PNG (Max. 5MB)</p>
                                                </div>
                                            </div>
                                            <div class="remove-file" onclick="removeFile(event)">
                                                <i class="fas fa-times"></i>
                                            </div>
                                        </div>
                                        @error('file')
                                            <div class="text-danger small mt-2">{{ $message }}</div>
                                        @enderror
                                    </div>

                                @else
                                    <!-- Current Video Info -->
                                    <div class="current-file mb-4">
                                        <label class="form-label fw-bold">Video Saat Ini</label>
                                        <div class="file-info">
                                            <i class="fas fa-link me-1"></i>
                                            <a href="{{ $galeri->file }}" target="_blank" class="text-truncate d-block">
                                                {{ $galeri->file }}
                                            </a>
                                        </div>
                                        @if($galeri->thumbnail)
                                            <img src="{{ Storage::url($galeri->thumbnail) }}"
                                                 alt="Thumbnail"
                                                 class="thumbnail-preview mt-2">
                                        @endif
                                    </div>

                                    <!-- Update Video URL -->
                                    <div class="mb-4">
                                        <label for="file" class="form-label fw-bold">URL Video</label>
                                        <input type="url"
                                               class="form-control @error('file') is-invalid @enderror"
                                               id="file"
                                               name="file"
                                               value="{{ old('file', $galeri->file) }}"
                                               placeholder="https://www.youtube.com/watch?v=...">
                                        @error('file')
                                            <div class="invalid-feedback">{{ $message }}</div>
                                        @enderror
                                    </div>

                                    <!-- Update Thumbnail -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold">Thumbnail (Opsional)</label>
                                        <input type="file"
                                               class="form-control"
                                               name="thumbnail"
                                               accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">Upload thumbnail baru untuk video</small>
                                    </div>
                                @endif

                                <!-- Info Box -->
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                                        <li>Upload file baru untuk mengganti konten</li>
                                        <li>Kosongkan jika tidak ingin mengubah konten</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.galeri.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Update Galeri
                                    </button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function previewFile(input) {
        const file = input.files[0];
        if (!file) return;

        const container = document.getElementById('preview-container');
        const reader = new FileReader();

        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" class="upload-preview" alt="Preview">`;
        }

        reader.readAsDataURL(file);

        // Add has-file class
        input.closest('.upload-area').classList.add('has-file');
    }

    function removeFile(event) {
        event.stopPropagation();

        const input = document.getElementById('file_foto');
        const container = document.getElementById('preview-container');
        const uploadArea = input.closest('.upload-area');

        input.value = '';
        container.innerHTML = `
            <div class="preview-placeholder">
                <i class="fas fa-cloud-upload-alt fa-4x mb-3 text-muted"></i>
                <h6>Klik untuk upload foto baru</h6>
                <p class="text-muted small mb-0">Format: JPG, PNG (Max. 5MB)</p>
            </div>
        `;

        uploadArea.classList.remove('has-file');
    }
</script>
@endpush
