@extends('admin.layouts.admin')

@section('title', 'Detail Pelayanan')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-file-medical me-2"></i>Detail Pelayanan
        </h1>
        <div>
            <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left me-2"></i>Kembali
            </a>
            <a href="{{ route('admin.pelayanan.edit', $pelayanan->id) }}" class="btn btn-warning btn-sm">
                <i class="fas fa-edit me-2"></i>Edit Status
            </a>
        </div>
    </div>

    <div class="row">
        <!-- Informasi Pasien -->
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-user me-2"></i>Informasi Pasien
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nomor Rekam Medis</label>
                            <div class="h5">{{ $pelayanan->no_rm }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">NIK</label>
                            <div class="h5">{{ $pelayanan->nik }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Nama Lengkap</label>
                            <div class="h5">{{ $pelayanan->nama }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Tempat Lahir</label>
                            <div>{{ $pelayanan->tempat_lahir }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Tanggal Lahir</label>
                            <div>{{ \Carbon\Carbon::parse($pelayanan->tanggal_lahir)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">Jenis Kelamin</label>
                            <div>
                                @if($pelayanan->jenis_kelamin == 'L')
                                    <span class="badge bg-info">Laki-laki</span>
                                @else
                                    <span class="badge bg-success">Perempuan</span>
                                @endif
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <label class="text-muted small">No. Handphone</label>
                            <div>{{ $pelayanan->no_hp }}</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Alamat</label>
                            <div>{{ $pelayanan->alamat }}</div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Informasi Pelayanan -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-stethoscope me-2"></i>Informasi Pelayanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Poli Tujuan</label>
                            <div class="h5">{{ $pelayanan->poli_tujuan }}</div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="text-muted small">Tanggal Periksa</label>
                            <div class="h5">{{ \Carbon\Carbon::parse($pelayanan->tanggal_periksa)->format('d/m/Y') }}</div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="text-muted small">Keluhan</label>
                            <div class="p-3 bg-light rounded">
                                {{ $pelayanan->keluhan }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Status dan Catatan -->
        <div class="col-lg-4">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Status Pelayanan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="text-center mb-4">
                        @if($pelayanan->status == 'pending')
                            <div class="display-1 text-warning">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <h4 class="text-warning mt-3">Pending</h4>
                        @elseif($pelayanan->status == 'diproses')
                            <div class="display-1 text-info">
                                <i class="fas fa-spinner fa-spin"></i>
                            </div>
                            <h4 class="text-info mt-3">Diproses</h4>
                        @elseif($pelayanan->status == 'selesai')
                            <div class="display-1 text-success">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <h4 class="text-success mt-3">Selesai</h4>
                        @elseif($pelayanan->status == 'ditolak')
                            <div class="display-1 text-danger">
                                <i class="fas fa-times-circle"></i>
                            </div>
                            <h4 class="text-danger mt-3">Ditolak</h4>
                        @endif
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="text-muted small">Tanggal Daftar</label>
                        <div>{{ $pelayanan->created_at->format('d/m/Y H:i') }}</div>
                    </div>

                    @if($pelayanan->catatan_admin)
                    <div class="mb-3">
                        <label class="text-muted small">Catatan Admin</label>
                        <div class="p-3 bg-light rounded">
                            {{ $pelayanan->catatan_admin }}
                        </div>
                    </div>
                    @endif

                    <hr>

                    <a href="{{ route('admin.pelayanan.edit', $pelayanan->id) }}" class="btn btn-warning w-100">
                        <i class="fas fa-edit me-2"></i>Update Status
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('styles')
<style>
    .display-1 {
        font-size: 5rem;
    }
    @media (max-width: 768px) {
        .display-1 {
            font-size: 3rem;
        }
    }
</style>
@endpush
