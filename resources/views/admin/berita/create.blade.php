@extends('admin.layouts.admin')

@section('title', 'Tambah Berita')

@push('styles')
<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.css" rel="stylesheet">
<style>
    .note-editor.note-frame {
        border: 1px solid #e3e6f0;
        border-radius: 0.5rem;
    }

    .note-editor .note-toolbar {
        background: #f8f9fa;
        border-bottom: 1px solid #e3e6f0;
        border-radius: 0.5rem 0.5rem 0 0;
        padding: 10px;
    }

    .note-editor .note-statusbar {
        background: #f8f9fa;
        border-top: 1px solid #e3e6f0;
        border-radius: 0 0 0.5rem 0.5rem;
    }

    .image-preview {
        width: 200px;
        height: 150px;
        border: 2px dashed #ddd;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        position: relative;
        cursor: pointer;
        transition: all 0.3s;
    }

    .image-preview:hover {
        border-color: #0d6efd;
        background: #f8f9fa;
    }

    .image-preview img {
        width: 100%;
        height: 100%;
        object-fit: cover;
    }

    .image-preview .preview-text {
        text-align: center;
        color: #6c757d;
    }

    .image-preview .preview-text i {
        font-size: 3rem;
        margin-bottom: 10px;
    }

    .remove-image {
        position: absolute;
        top: 5px;
        right: 5px;
        background: rgba(255,255,255,0.9);
        border: none;
        border-radius: 50%;
        width: 30px;
        height: 30px;
        display: none;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        color: #dc3545;
        transition: all 0.3s;
    }

    .image-preview:hover .remove-image {
        display: flex;
    }

    .remove-image:hover {
        background: #dc3545;
        color: white;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-plus-circle me-2"></i>Tambah Berita
        </h1>
        <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary btn-sm">
            <i class="fas fa-arrow-left me-2"></i>Kembali
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <div class="col-12">
            <div class="card shadow">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">Form Tambah Berita</h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.berita.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf

                        <div class="row">
                            <!-- Kolom Kiri -->
                            <div class="col-md-8">
                                <!-- Judul -->
                                <div class="mb-4">
                                    <label for="judul" class="form-label fw-bold">Judul Berita <span class="text-danger">*</span></label>
                                    <input type="text"
                                           class="form-control form-control-lg @error('judul') is-invalid @enderror"
                                           id="judul"
                                           name="judul"
                                           value="{{ old('judul') }}"
                                           placeholder="Masukkan judul berita">
                                    @error('judul')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Konten -->
                                <div class="mb-4">
                                    <label for="konten" class="form-label fw-bold">Konten Berita <span class="text-danger">*</span></label>
                                    <textarea class="form-control @error('konten') is-invalid @enderror"
                                              id="summernote"
                                              name="konten"
                                              rows="10">{{ old('konten') }}</textarea>
                                    @error('konten')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>
                            </div>

                            <!-- Kolom Kanan -->
                            <div class="col-md-4">
                                <!-- Gambar -->
                                <div class="mb-4">
                                    <label class="form-label fw-bold">Gambar Berita</label>
                                    <div class="image-preview" onclick="document.getElementById('gambar').click()">
                                        <input type="file"
                                               class="d-none"
                                               id="gambar"
                                               name="gambar"
                                               accept="image/jpeg,image/png,image/jpg"
                                               onchange="previewImage(this)">
                                        <div id="preview-container">
                                            <div class="preview-text">
                                                <i class="fas fa-cloud-upload-alt"></i>
                                                <p class="mb-0">Klik untuk upload</p>
                                                <small class="text-muted">Format: JPG/PNG (Max. 2MB)</small>
                                            </div>
                                        </div>
                                        <div class="remove-image" onclick="removeImage(event)">
                                            <i class="fas fa-times"></i>
                                        </div>
                                    </div>
                                    @error('gambar')
                                        <div class="text-danger small mt-2">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Tanggal -->
                                <div class="mb-4">
                                    <label for="tanggal" class="form-label fw-bold">Tanggal <span class="text-danger">*</span></label>
                                    <input type="date"
                                           class="form-control @error('tanggal') is-invalid @enderror"
                                           id="tanggal"
                                           name="tanggal"
                                           value="{{ old('tanggal', date('Y-m-d')) }}">
                                    @error('tanggal')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Status -->
                                <div class="mb-4">
                                    <label for="status" class="form-label fw-bold">Status <span class="text-danger">*</span></label>
                                    <select class="form-select @error('status') is-invalid @enderror"
                                            id="status"
                                            name="status">
                                        <option value="publish" {{ old('status') == 'publish' ? 'selected' : '' }}>Publish</option>
                                        <option value="draft" {{ old('status') == 'draft' ? 'selected' : '' }}>Draft</option>
                                    </select>
                                    @error('status')
                                        <div class="invalid-feedback">{{ $message }}</div>
                                    @enderror
                                </div>

                                <!-- Info Box -->
                                <div class="alert alert-info">
                                    <i class="fas fa-info-circle me-2"></i>
                                    <strong>Informasi:</strong>
                                    <ul class="mb-0 mt-2">
                                        <li>Field dengan tanda <span class="text-danger">*</span> wajib diisi</li>
                                        <li>Gambar akan ditampilkan di halaman berita</li>
                                        <li>Status draft tidak akan tampil di halaman utama</li>
                                    </ul>
                                </div>
                            </div>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="row mt-4">
                            <div class="col-12">
                                <hr>
                                <div class="d-flex justify-content-end gap-2">
                                    <a href="{{ route('admin.berita.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-times me-2"></i>Batal
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-save me-2"></i>Simpan Berita
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
<!-- Summernote JS -->
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-bs5.min.js"></script>
<script>
    // Initialize Summernote
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['font', ['bold', 'underline', 'italic', 'clear']],
                ['fontname', ['fontname']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture', 'video']],
                ['view', ['fullscreen', 'codeview', 'help']]
            ],
            placeholder: 'Tulis konten berita di sini...',
            lang: 'id-ID',
            callbacks: {
                onImageUpload: function(files) {
                    // Handle image upload if needed
                }
            }
        });
    });

    // Preview Image
    function previewImage(input) {
        const preview = document.getElementById('preview-container');
        const file = input.files[0];

        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                preview.innerHTML = `<img src="${e.target.result}" alt="Preview">`;
            }
            reader.readAsDataURL(file);
        }
    }

    // Remove Image
    function removeImage(event) {
        event.stopPropagation();
        const input = document.getElementById('gambar');
        const preview = document.getElementById('preview-container');

        input.value = '';
        preview.innerHTML = `
            <div class="preview-text">
                <i class="fas fa-cloud-upload-alt"></i>
                <p class="mb-0">Klik untuk upload</p>
                <small class="text-muted">Format: JPG/PNG (Max. 2MB)</small>
            </div>
        `;
    }
</script>
@endpush
