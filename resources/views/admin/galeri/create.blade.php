@extends('admin.layouts.admin')

@section('title', 'Tambah Galeri')

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
        cursor: pointer;
        transition: all 0.3s;
    }

    .type-card:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }

    .type-card.active {
        border-color: #0d6efd;
        background: #e7f1ff;
    }

    .type-card i {
        font-size: 3rem;
        margin-bottom: 15px;
        color: #6c757d;
    }

    .type-card.active i {
        color: #0d6efd;
    }

    .type-card h5 {
        margin-bottom: 5px;
        font-weight: 600;
    }

    .type-card p {
        color: #6c757d;
        font-size: 0.9rem;
        margin-bottom: 0;
    }

    .upload-area {
        border: 3px dashed #dee2e6;
        border-radius: 12px;
        padding: 40px 20px;
        text-align: center;
        cursor: pointer;
        transition: all 0.3s;
        position: relative;
        min-height: 300px;
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
        max-height: 250px;
        object-fit: contain;
    }

    .file-info {
        position: absolute;
        bottom: 10px;
        left: 0;
        right: 0;
        font-size: 0.85rem;
        color: #6c757d;
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

    .remove-file:hover {
        background: #dc3545;
        color: white;
    }

    .video-url-input {
        display: none;
        margin-top: 20px;
    }

    .video-url-input.show {
        display: block;
    }

    .thumbnail-preview {
        width: 120px;
        height: 80px;
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
            <i class="fas fa-plus-circle me-2"></i>Tambah Galeri
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
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Galeri</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.galeri.store') }}" method="POST" enctype="multipart/form-data" id="galleryForm">
                        @csrf

                        <!-- Tipe Selector -->
                        <div class="mb-4">
                            <label class="form-label fw-bold">Tipe Konten <span class="text-danger">*</span></label>
                            <div class="type-selector">
                                <div class="type-card {{ old('tipe') == 'foto' ? 'active' : '' }}" data-type="foto" onclick="selectType('foto')">
                                    <i class="fas fa-camera"></i>
                                    <h5>Foto</h5>
                                    <p>Upload gambar dari perangkat</p>
                                </div>
                                <div class="type-card {{ old('tipe') == 'video' ? 'active' : '' }}" data-type="video" onclick="selectType('video')">
                                    <i class="fas fa-video"></i>
                                    <h5>Video</h5>
                                    <p>Link YouTube/URL video</p>
                                </div>
                            </div>
                            <input type="hidden" name="tipe" id="tipe" value="{{ old('tipe', 'foto') }}">
                            @error('tipe')
                                <div class="text-danger small mt-2">{{ $message }}</div>
                            @enderror
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
                                           value="{{ old('judul') }}"
                                           placeholder="Masukkan judul foto/video">
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
                                              rows="4"
                                              placeholder="Masukkan deskripsi (opsional)">{{ old('deskripsi') }}</textarea>
                                    @error('deskripsi')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-4">
                                <!-- Upload Area untuk Foto -->
                                <div id="fotoUpload" class="{{ old('tipe') == 'video' ? 'd-none' : '' }}">
                                    <label class="form-label fw-bold">Upload Foto <span class="text-danger">*</span></label>
                                    <div class="upload-area" onclick="document.getElementById('file_foto').click()">
                                        <input type="file"
                                               class="d-none"
                                               id="file_foto"
                                               name="file"
                                               accept="image/jpeg,image/png,image/jpg"
                                               onchange="previewFile(this, 'foto')">
                                        <div id="foto-preview-container">
                                            <div class="preview-placeholder">
                                                <i class="fas fa-cloud-upload-alt fa-4x mb-3 text-muted"></i>
                                                <h6>Klik untuk upload foto</h6>
                                                <p class="text-muted small mb-0">Format: JPG, PNG (Max. 5MB)</p>
                                                <p class="text-muted small">Rekomendasi ukuran: 1920x1080</p>
                                            </div>
                                        </div>
                                        <div class="remove-file" onclick="removeFile(event, 'foto')">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    @error('file')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Upload Area untuk Video -->
                                <div id="videoUpload" class="{{ old('tipe') == 'foto' ? 'd-none' : '' }}">
                                    <label class="form-label fw-bold">URL Video <span class="text-danger">*</span></label>
                                    <div class="upload-area" onclick="document.getElementById('file_video').click()" style="min-height: auto; padding: 30px;">
                                        <input type="url"
                                               class="form-control mb-3"
                                               id="file_video"
                                               name="file"
                                               placeholder="https://www.youtube.com/watch?v=..."
                                               value="{{ old('file') }}">
                                        <div class="text-muted small">
                                            <i class="fas fa-info-circle me-1"></i>
                                            Masukkan link YouTube atau URL video
                                        </div>
                                    </div>
                                    @error('file')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror

                                    <!-- Preview Thumbnail untuk Video (opsional) -->
                                    <div class="mt-3">
                                        <label class="form-label fw-bold">Thumbnail (Opsional)</label>
                                        <input type="file"
                                               class="form-control"
                                               name="thumbnail"
                                               accept="image/jpeg,image/png,image/jpg">
                                        <small class="text-muted">Upload thumbnail untuk video (jika tidak diisi akan menggunakan default)</small>
                                    </div>
                                </div>

                                <!-- Info Box -->
                                <div class="alert alert-info mt-4">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                                        <li>Untuk video, masukkan link yang valid</li>
                                        <li>Thumbnail akan digunakan sebagai preview video</li>
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
                                        <i class="fas fa-save me-2"></i>Simpan Galeri
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
    function selectType(type) {
        // Update hidden input
        document.getElementById('tipe').value = type;

        // Update active state on cards
        document.querySelectorAll('.type-card').forEach(card => {
            if (card.dataset.type === type) {
                card.classList.add('active');
            } else {
                card.classList.remove('active');
            }
        });

        // Show/hide upload sections
        if (type === 'foto') {
            document.getElementById('fotoUpload').classList.remove('d-none');
            document.getElementById('videoUpload').classList.add('d-none');
        } else {
            document.getElementById('fotoUpload').classList.add('d-none');
            document.getElementById('videoUpload').classList.remove('d-none');
        }
    }

    function previewFile(input, type) {
        const file = input.files[0];
        if (!file) return;

        const container = document.getElementById(type + '-preview-container');
        const reader = new FileReader();

        reader.onload = function(e) {
            container.innerHTML = `<img src="${e.target.result}" class="upload-preview" alt="Preview">`;
        }

        reader.readAsDataURL(file);

        // Add has-file class
        input.closest('.upload-area').classList.add('has-file');
    }

    function removeFile(event, type) {
        event.stopPropagation();

        const input = document.getElementById('file_' + type);
        const container = document.getElementById(type + '-preview-container');
        const uploadArea = input.closest('.upload-area');

        input.value = '';
        container.innerHTML = `
            <div class="preview-placeholder">
                <i class="fas fa-cloud-upload-alt fa-4x mb-3 text-muted"></i>
                <h6>Klik untuk upload ${type === 'foto' ? 'foto' : 'video'}</h6>
                <p class="text-muted small mb-0">${type === 'foto' ? 'Format: JPG, PNG (Max. 5MB)' : 'Masukkan URL video'}</p>
            </div>
        `;

        uploadArea.classList.remove('has-file');
    }

    // Auto preview untuk video URL (basic)
    document.getElementById('file_video')?.addEventListener('input', function() {
        const url = this.value;
        const uploadArea = this.closest('.upload-area');

        if (url && (url.includes('youtube.com') || url.includes('youtu.be') || url.includes('vimeo.com'))) {
            uploadArea.classList.add('has-file');
        } else {
            uploadArea.classList.remove('has-file');
        }
    });
</script>
@endpush
