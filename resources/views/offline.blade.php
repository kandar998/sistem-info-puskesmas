<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Offline - Puskesmas Katoi</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #11998e, #2ecc71);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .offline-card {
            background: white;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            max-width: 400px;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
        }
        .offline-icon {
            font-size: 80px;
            color: #2ecc71;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="offline-card">
        <div class="offline-icon">
            <i class="fas fa-wifi-slash"></i>
        </div>
        <h3 class="mb-3">Tidak Ada Koneksi Internet</h3>
        <p class="text-muted mb-4">
            Mohon periksa kembali koneksi internet Anda untuk mengakses layanan Puskesmas Katoi.
        </p>
        <button class="btn btn-success btn-lg" onclick="location.reload()">
            <i class="fas fa-sync-alt me-2"></i>Coba Lagi
        </button>
    </div>
</body>
</html>
