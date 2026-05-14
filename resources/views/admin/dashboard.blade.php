@extends('admin.layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="container-fluid">
    <!-- Page Heading dengan Logo -->
    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <div class="d-flex align-items-center">
            <img src="{{ asset('images/logo-puskesmas.png') }}" alt="Logo Puskesmas"
                 style="height: 50px; width: auto; margin-right: 15px;"
                 onerror="this.style.display='none'">
            <h1 class="h3 mb-0 text-gray-800">Dashboard</h1>
        </div>
        <a href="{{ route('admin.pelayanan.index') }}" class="btn btn-primary btn-sm">
            <i class="fas fa-plus-circle me-2"></i>Lihat Pelayanan
        </a>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Total Pelayanan Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card">
                <div class="stat-title">Total Pelayanan</div>
                <div class="stat-value">{{ number_format($totalPelayanan ?? 0) }}</div>
                <i class="fas fa-calendar-check"></i>
            </div>
        </div>

        <!-- Pelayanan Hari Ini Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #11998e, #38ef7d);">
                <div class="stat-title">Pelayanan Hari Ini</div>
                <div class="stat-value">{{ number_format($pelayananHariIni ?? 0) }}</div>
                <i class="fas fa-clock"></i>
            </div>
        </div>

        <!-- Pending Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #f093fb, #f5576c);">
                <div class="stat-title">Pending</div>
                <div class="stat-value">{{ number_format($pelayananPending ?? 0) }}</div>
                <i class="fas fa-hourglass-half"></i>
            </div>
        </div>

        <!-- Total Berita Card -->
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="stat-card" style="background: linear-gradient(135deg, #4facfe, #00f2fe);">
                <div class="stat-title">Total Berita</div>
                <div class="stat-value">{{ number_format($totalBerita ?? 0) }}</div>
                <i class="fas fa-newspaper"></i>
            </div>
        </div>
    </div>

    <!-- Content Row -->
    <div class="row">
        <!-- Grafik Pelayanan -->
        <div class="col-xl-8 col-lg-7">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-chart-line me-2"></i>Grafik Pelayanan Per Bulan
                    </h6>
                </div>
                <div class="card-body">
                    <canvas id="myChart" style="width:100%; max-width:600px; height:300px;"></canvas>
                </div>
            </div>
        </div>

        <!-- Info Panel -->
        <div class="col-xl-4 col-lg-5">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h6 class="m-0 font-weight-bold text-primary">
                        <i class="fas fa-info-circle me-2"></i>Informasi
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <h6><i class="fas fa-user me-2 text-primary"></i> Admin</h6>
                        <p class="text-muted">{{ Auth::user()->name }}</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-envelope me-2 text-primary"></i> Email</h6>
                        <p class="text-muted">{{ Auth::user()->email }}</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-calendar me-2 text-primary"></i> Login Terakhir</h6>
                        <p class="text-muted">{{ now()->format('d M Y H:i') }}</p>
                    </div>
                    <div class="mb-3">
                        <h6><i class="fas fa-shield-alt me-2 text-primary"></i> Role</h6>
                        <span class="badge bg-primary">Administrator</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
// Inisialisasi Chart
const ctx = document.getElementById('myChart');
if (ctx) {
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'],
            datasets: [{
                label: 'Jumlah Pelayanan',
                data: [
                    @php
                        $chartData = array_fill(1, 12, 0);
                        foreach($pelayananPerBulan as $item) {
                            $chartData[$item->bulan] = $item->total;
                        }
                    @endphp
                    @foreach(range(1,12) as $bulan)
                        {{ $chartData[$bulan] ?? 0 }},
                    @endforeach
                ],
                borderColor: 'rgb(75, 192, 192)',
                backgroundColor: 'rgba(75, 192, 192, 0.2)',
                tension: 0.1,
                fill: true
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    ticks: {
                        stepSize: 1
                    }
                }
            }
        }
    });
}
</script>
@endpush
