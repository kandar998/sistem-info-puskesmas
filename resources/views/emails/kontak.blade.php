<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pesan Kontak Baru</title>
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            background: #f4f4f4;
            margin: 0;
            padding: 20px;
        }
        .container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
        }
        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 2px solid #0d6efd;
        }
        .header h1 {
            color: #0d6efd;
            margin: 0;
        }
        .content {
            margin-bottom: 30px;
        }
        .info-item {
            margin-bottom: 20px;
            padding: 15px;
            background: #f8f9fa;
            border-radius: 5px;
        }
        .info-item label {
            font-weight: bold;
            color: #0d6efd;
            display: block;
            margin-bottom: 5px;
        }
        .info-item p {
            margin: 0;
            color: #333;
        }
        .message-box {
            background: #e9ecef;
            padding: 20px;
            border-radius: 5px;
            border-left: 4px solid #0d6efd;
        }
        .footer {
            text-align: center;
            margin-top: 30px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            color: #6c757d;
            font-size: 0.9rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>📬 Pesan Kontak Baru</h1>
            <p>Dari Website Puskesmas Katoi</p>
        </div>

        <div class="content">
            <div class="info-item">
                <label>📋 Nama Lengkap</label>
                <p>{{ $nama }}</p>
            </div>

            <div class="info-item">
                <label>📧 Email</label>
                <p>{{ $email }}</p>
            </div>

            @if($telepon)
            <div class="info-item">
                <label>📞 No. Telepon</label>
                <p>{{ $telepon }}</p>
            </div>
            @endif

            <div class="info-item">
                <label>📅 Tanggal Kirim</label>
                <p>{{ $tanggal }}</p>
            </div>

            <div class="message-box">
                <label style="font-weight: bold; color: #0d6efd; display: block; margin-bottom: 10px;">💬 Pesan</label>
                <p style="margin: 0;">{{ $pesan }}</p>
            </div>
        </div>

        <div class="footer">
            <p>Email ini dikirim secara otomatis dari website Puskesmas Katoi.</p>
            <p>Harap segera ditindaklanjuti.</p>
        </div>
    </div>
</body>
</html>
