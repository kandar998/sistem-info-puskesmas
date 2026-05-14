@extends('admin.layouts.admin')

@section('title', 'Pengaturan Website')

@section('content')
<div class="container-fluid">
    <!-- Page Heading -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cog me-2"></i>Pengaturan Website
        </h1>
    </div>

    <div class="row">
        <!-- Statistik Settings -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-bar me-2"></i>Pengaturan Statistik Footer
                    </h6>
                </div>
                <div class="card-body">
                    @php
                        $statistic = \App\Models\Setting::where('key', 'footer_statistic')->first();
                        $statistic = $statistic ? json_decode($statistic->value, true) : [
                            'total_pasien' => 0,
                            'total_dokter' => 0,
                            'total_kunjungan_hari' => 0,
                            'total_posyandu' => 0
                        ];
                    @endphp

                    <form action="{{ route('admin.setting.statistic.update') }}" method="POST">
                        @csrf

                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Pasien</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-users"></i></span>
                                    <input type="number" name="total_pasien" class="form-control"
                                           value="{{ old('total_pasien', $statistic['total_pasien']) }}" min="0" required>
                                </div>
                                <small class="text-muted">Jumlah total pasien terdaftar</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Dokter</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-user-md"></i></span>
                                    <input type="number" name="total_dokter" class="form-control"
                                           value="{{ old('total_dokter', $statistic['total_dokter']) }}" min="0" required>
                                </div>
                                <small class="text-muted">Jumlah dokter yang bertugas</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Kunjungan Hari Ini</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-calendar-check"></i></span>
                                    <input type="number" name="total_kunjungan_hari" class="form-control"
                                           value="{{ old('total_kunjungan_hari', $statistic['total_kunjungan_hari']) }}" min="0" required>
                                </div>
                                <small class="text-muted">Jumlah kunjungan pasien hari ini</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label class="form-label">Total Posyandu</label>
                                <div class="input-group">
                                    <span class="input-group-text"><i class="fas fa-child"></i></span>
                                    <input type="number" name="total_posyandu" class="form-control"
                                           value="{{ old('total_posyandu', $statistic['total_posyandu']) }}" min="0" required>
                                </div>
                                <small class="text-muted">Jumlah posyandu aktif</small>
                            </div>
                        </div>

                        <hr>

                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-save me-2"></i>Simpan Statistik
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <!-- Informasi Settings -->
        <div class="col-lg-6">
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi Sistem
                    </h6>
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <td width="40%">Puskesmas Katoi</td>
                            <td><strong>Melayani Sepenuh Hati</strong></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td>Desa Katoi, Kecematan Simbula, Kabupaten Kolaka Utara</td>
                        </tr>

                        <tr>
                            <td>Email</td>
                            <td>puskesmaskatoi@gamil.com</td>
                        </tr>
                        <tr>
                            <td>Environment</td>
                            <td><span class="badge bg-success">{{ app()->environment() }}</span></td>
                        </tr>
                        <tr>
                            <td>Debug Mode</td>
                            <td>
                                @if(config('app.debug'))
                                    <span class="badge bg-warning text-dark">ON</span>
                                @else
                                    <span class="badge bg-secondary">OFF</span>
                                @endif
                            </td>
                        </tr>
                        <tr>
                            <td>Cache Driver</td>
                            <td>{{ config('cache.default') }}</td>
                        </tr>
                        <tr>
                            <td>Session Driver</td>
                            <td>{{ config('session.driver') }}</td>
                        </tr>
                    </table>

                    <hr>

                    <div class="alert alert-warning">
                        <i class="fas fa-exclamation-triangle me-2"></i>
                        <strong>Perhatian:</strong> Hati-hati dalam mengubah pengaturan. Perubahan akan langsung tampil di halaman depan website.
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow mb-4">
                <div class="card-header py-3 bg-white">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-bolt me-2"></i>Aksi Cepat
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.profil.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-building me-2"></i>Edit Profil
                        </a>
                        <a href="{{ route('admin.visi-misi.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-eye me-2"></i>Edit Visi & Misi
                        </a>
                        <a href="{{ route('admin.sejarah.edit') }}" class="btn btn-outline-primary">
                            <i class="fas fa-history me-2"></i>Edit Sejarah
                        </a>
                        <button class="btn btn-outline-danger" onclick="clearCache()">
                            <i class="fas fa-trash me-2"></i>Bersihkan Cache
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function clearCache() {
    if (confirm('Apakah Anda yakin ingin membersihkan cache?')) {
        fetch('{{ route("admin.setting.cache.clear") }}', {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        })
        .then(response => response.json())
        .then(data => {
            alert('Cache berhasil dibersihkan!');
        })
        .catch(error => {
            alert('Gagal membersihkan cache');
        });
    }
}
</script>
@endpush
