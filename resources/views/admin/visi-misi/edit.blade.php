@extends('admin.layouts.admin')

@section('title', 'Edit Visi & Misi')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-eye me-2"></i>Edit Visi & Misi
        </h1>
        <a href="{{ route('home') }}#visi-misi" target="_blank" class="btn btn-info btn-sm">
            <i class="fas fa-eye me-2"></i>Lihat Halaman Depan
        </a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-edit me-2"></i>Form Edit Visi & Misi
                    </h6>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.visi-misi.update') }}" method="POST">
                        @csrf
                        @method('PUT')

                        <!-- Visi -->
                        <div class="mb-4">
                            <label class="form-label h6">
                                <i class="fas fa-eye text-primary me-2"></i>Visi <span class="text-danger">*</span>
                            </label>
                            <textarea name="visi" class="form-control @error('visi') is-invalid @enderror"
                                      rows="3" placeholder="Masukkan visi Puskesmas..." required>{{ old('visi', $visiMisi->visi ?? '') }}</textarea>
                            @error('visi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Visi adalah gambaran masa depan yang ingin dicapai</small>
                        </div>

                        <!-- Misi -->
                        <div class="mb-4">
                            <label class="form-label h6">
                                <i class="fas fa-bullseye text-primary me-2"></i>Misi <span class="text-danger">*</span>
                            </label>
                            <textarea name="misi" class="form-control @error('misi') is-invalid @enderror"
                                      rows="6" placeholder="Masukkan misi Puskesmas (pisahkan dengan baris baru untuk setiap poin)..." required>{{ old('misi', $visiMisi->misi ?? '') }}</textarea>
                            @error('misi')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <small class="text-muted">Tulis setiap poin misi pada baris baru. Contoh:<br>
                            1. Meningkatkan mutu pelayanan<br>
                            2. Meningkatkan profesionalisme SDM</small>
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
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label class="text-muted small">Terakhir Diperbarui</label>
                        <div class="h6">
                            @if($visiMisi && $visiMisi->updated_at)
                                {{ $visiMisi->updated_at->format('d F Y H:i') }}
                            @else
                                Belum pernah diperbarui
                            @endif
                        </div>
                    </div>

                    <hr>

                    <div class="alert alert-info">
                        <i class="fas fa-lightbulb me-2"></i>
                        <strong>Tips Penulisan Misi:</strong>
                        <ul class="mb-0 mt-2 small">
                            <li>Gunakan bahasa yang jelas dan mudah dipahami</li>
                            <li>Setiap poin misi harus spesifik dan terukur</li>
                            <li>Maksimal 7 poin misi agar mudah diingat</li>
                            <li>Gunakan kata kerja yang kuat</li>
                        </ul>
                    </div>

                    <div class="mt-3">
                        <h6 class="mb-2">Preview:</h6>
                        <div class="bg-light p-3 rounded" id="previewVisi">
                            <strong>Visi:</strong>
                            <p class="mb-2">{{ Str::limit($visiMisi->visi ?? 'Visi akan ditampilkan di sini', 100) }}</p>
                            <strong>Misi:</strong>
                            <ul class="mb-0">
                                @if($visiMisi && $visiMisi->misi)
                                    @foreach(explode("\n", $visiMisi->misi) as $misi)
                                        @if(trim($misi))
                                            <li>{{ Str::limit(trim($misi), 50) }}</li>
                                        @endif
                                    @endforeach
                                @else
                                    <li class="text-muted">Misi akan ditampilkan di sini</li>
                                @endif
                            </ul>
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
    // Live preview
    const visiInput = document.querySelector('textarea[name="visi"]');
    const misiInput = document.querySelector('textarea[name="misi"]');
    const previewVisi = document.getElementById('previewVisi');

    function updatePreview() {
        if (previewVisi) {
            const visiText = visiInput.value || 'Visi akan ditampilkan di sini';
            const misiLines = misiInput.value.split('\n').filter(line => line.trim() !== '');

            let misiHtml = '<ul class="mb-0">';
            if (misiLines.length > 0) {
                misiLines.forEach(line => {
                    misiHtml += `<li>${line.substring(0, 50)}${line.length > 50 ? '...' : ''}</li>`;
                });
            } else {
                misiHtml += '<li class="text-muted">Misi akan ditampilkan di sini</li>';
            }
            misiHtml += '</ul>';

            previewVisi.innerHTML = `
                <strong>Visi:</strong>
                <p class="mb-2">${visiText.substring(0, 100)}${visiText.length > 100 ? '...' : ''}</p>
                <strong>Misi:</strong>
                ${misiHtml}
            `;
        }
    }

    if (visiInput && misiInput) {
        visiInput.addEventListener('input', updatePreview);
        misiInput.addEventListener('input', updatePreview);
    }
</script>
@endpush
