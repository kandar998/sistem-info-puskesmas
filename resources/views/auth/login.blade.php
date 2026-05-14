<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Puskesmas Katoi</title>

    <!-- Font Awesome 6 -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Poppins', sans-serif;
            min-height: 100vh;
            background: linear-gradient(135deg, #11998e 0%, #38ef7d 50%, #2ecc71 100%);
            background-size: 400% 400%;
            animation: gradientBG 15s ease infinite;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            position: relative;
            overflow-x: hidden;
        }

        @keyframes gradientBG {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Animated Background Shapes */
        .shape {
            position: absolute;
            background: rgba(56, 239, 125, 0.15);
            border-radius: 50%;
            filter: blur(60px);
            animation: float 20s infinite;
            z-index: 0;
        }

        .shape-1 {
            width: 300px;
            height: 300px;
            top: -100px;
            left: -100px;
            background: rgba(56, 239, 125, 0.2);
            animation: float 18s infinite;
        }

        .shape-2 {
            width: 400px;
            height: 400px;
            bottom: -150px;
            right: -150px;
            background: rgba(46, 204, 113, 0.15);
            animation: float 22s infinite reverse;
        }

        .shape-3 {
            width: 250px;
            height: 250px;
            bottom: 50%;
            right: 20%;
            background: rgba(56, 239, 125, 0.12);
            animation: float 25s infinite;
        }

        @keyframes float {
            0% { transform: translate(0, 0) rotate(0deg); }
            33% { transform: translate(30px, -30px) rotate(120deg); }
            66% { transform: translate(-20px, 20px) rotate(240deg); }
            100% { transform: translate(0, 0) rotate(360deg); }
        }

        /* Main Container Horizontal */
        .login-container {
            position: relative;
            z-index: 1;
            width: 100%;
            max-width: 1000px;
            background: white;
            border-radius: 30px;
            box-shadow: 0 25px 50px rgba(0, 0, 0, 0.2);
            overflow: hidden;
            animation: slideUp 0.6s ease;
            display: flex;
            flex-direction: row;
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Left Panel - Welcome Section (Hijau) */
        .login-left {
            flex: 1;
            background: linear-gradient(135deg, #11998e 0%, #2ecc71 50%, #38ef7d 100%);
            padding: 50px 40px;
            color: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
            position: relative;
            overflow: hidden;
        }

        .login-left::before {
            content: '';
            position: absolute;
            top: -50%;
            right: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(255,255,255,0.1) 0%, transparent 70%);
            animation: pulse 8s ease infinite;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(1); opacity: 0.3; }
            50% { transform: scale(1.1); opacity: 0.5; }
        }

        .logo-large {
            text-align: center;
            margin-bottom: 40px;
            position: relative;
            z-index: 1;
        }

        .logo-circle {
            width: 100px;
            height: 100px;
            background: rgba(255, 255, 255, 0.2);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            backdrop-filter: blur(10px);
            border: 2px solid rgba(255, 255, 255, 0.3);
            animation: logoFloat 3s ease-in-out infinite;
            overflow: hidden;
        }

        @keyframes logoFloat {
            0%, 100% { transform: translateY(0); }
            50% { transform: translateY(-10px); }
        }

        /* Logo Image Style */
        .logo-img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 50%;
        }

        .logo-circle i {
            font-size: 50px;
            color: white;
        }

        .logo-large h1 {
            font-size: 32px;
            font-weight: 700;
            letter-spacing: -0.5px;
            margin-bottom: 10px;
        }

        .logo-large p {
            font-size: 14px;
            opacity: 0.9;
        }

        .welcome-text {
            position: relative;
            z-index: 1;
        }

        .welcome-text h2 {
            font-size: 28px;
            font-weight: 700;
            margin-bottom: 20px;
            line-height: 1.3;
        }

        .welcome-text p {
            font-size: 15px;
            line-height: 1.6;
            opacity: 0.95;
            margin-bottom: 30px;
        }

        .features-list {
            list-style: none;
            margin-top: 30px;
        }

        .features-list li {
            margin-bottom: 15px;
            display: flex;
            align-items: center;
            gap: 12px;
            font-size: 14px;
        }

        .features-list li i {
            width: 25px;
            font-size: 18px;
        }

        /* Right Panel - Form Section */
        .login-right {
            flex: 1;
            padding: 50px 40px;
            background: white;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .login-right h2 {
            font-size: 28px;
            font-weight: 700;
            color: #333;
            margin-bottom: 8px;
        }

        .login-right p {
            color: #666;
            font-size: 14px;
            margin-bottom: 30px;
        }

        /* Input Groups */
        .input-group {
            margin-bottom: 20px;
        }

        .input-label {
            display: block;
            font-size: 14px;
            font-weight: 500;
            color: #333;
            margin-bottom: 8px;
        }

        .input-label i {
            margin-right: 8px;
            color: #2ecc71;
            font-size: 14px;
        }

        .input-wrapper {
            position: relative;
        }

        .input-wrapper input {
            width: 100%;
            padding: 14px 16px;
            font-size: 15px;
            border: 1.5px solid #e0e0e0;
            border-radius: 12px;
            outline: none;
            transition: all 0.3s ease;
            font-family: 'Poppins', sans-serif;
            background: #f8f9fa;
        }

        .input-wrapper input:focus {
            border-color: #2ecc71;
            background: white;
            box-shadow: 0 0 0 4px rgba(46, 204, 113, 0.1);
        }

        .input-wrapper input::placeholder {
            color: #aaa;
            font-weight: 400;
        }

        /* Password Toggle */
        .password-toggle {
            position: absolute;
            right: 15px;
            top: 50%;
            transform: translateY(-50%);
            background: transparent;
            border: none;
            color: #aaa;
            cursor: pointer;
            font-size: 16px;
            transition: color 0.3s;
        }

        .password-toggle:hover {
            color: #2ecc71;
        }

        /* Options Section */
        .login-options {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin: 20px 0;
            font-size: 13px;
        }

        .checkbox-container {
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
        }

        .checkbox-container input {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #2ecc71;
        }

        .checkbox-container span {
            color: #666;
        }

        .forgot-link {
            color: #2ecc71;
            text-decoration: none;
            font-weight: 500;
            transition: color 0.3s;
        }

        .forgot-link:hover {
            color: #11998e;
            text-decoration: underline;
        }

        /* Login Button */
        .login-btn {
            width: 100%;
            padding: 14px;
            background: linear-gradient(135deg, #11998e 0%, #2ecc71 100%);
            border: none;
            border-radius: 12px;
            color: white;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin: 10px 0 20px;
            font-family: 'Poppins', sans-serif;
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 20px rgba(46, 204, 113, 0.3);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        /* Register Link */
        .register-section {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
        }

        .register-section p {
            color: #666;
            font-size: 14px;
        }

        .register-link {
            color: #2ecc71;
            text-decoration: none;
            font-weight: 600;
            margin-left: 5px;
            transition: color 0.3s;
        }

        .register-link:hover {
            color: #11998e;
            text-decoration: underline;
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 12px;
            margin-bottom: 20px;
            font-size: 13px;
            display: flex;
            align-items: center;
            gap: 10px;
            animation: fadeIn 0.3s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .alert-success {
            background: #d1e7dd;
            color: #0f5132;
            border: 1px solid #badbcc;
        }

        .alert-danger {
            background: #f8d7da;
            color: #842029;
            border: 1px solid #f5c2c7;
        }

        .alert i {
            font-size: 16px;
        }

        /* Loading State */
        .login-btn.loading {
            opacity: 0.8;
            cursor: not-allowed;
            transform: scale(0.98);
        }

        .login-btn.loading i {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }

        /* Responsive */
        @media (max-width: 800px) {
            .login-container {
                flex-direction: column;
                max-width: 500px;
            }

            .login-left {
                padding: 40px 30px;
                text-align: center;
            }

            .welcome-text h2 {
                font-size: 24px;
            }

            .features-list {
                display: none;
            }

            .login-right {
                padding: 40px 30px;
            }

            .login-right h2 {
                font-size: 24px;
            }
        }

        @media (max-width: 480px) {
            .login-left {
                padding: 30px 20px;
            }

            .login-right {
                padding: 30px 20px;
            }

            .logo-circle {
                width: 70px;
                height: 70px;
            }

            .logo-circle i {
                font-size: 35px;
            }

            .logo-large h1 {
                font-size: 24px;
            }

            .login-right h2 {
                font-size: 22px;
            }

            .login-options {
                flex-direction: column;
                gap: 12px;
                align-items: flex-start;
            }
        }
    </style>
</head>
<body>
    <!-- Animated Background Shapes -->
    <div class="shape shape-1"></div>
    <div class="shape shape-2"></div>
    <div class="shape shape-3"></div>

    <div class="login-container">
        <!-- Left Panel - Welcome Section -->
        <div class="login-left">
            <div class="logo-large">
                <div class="logo-circle">
                    <img src="{{ asset('images/logo-puskesmas.png') }}" alt="Logo Puskesmas Katoi" class="logo-img">
                </div>
                <h1>PUSKESMAS KATOI</h1>
                <p>Sistem Informasi Pelayanan Pasien</p>
            </div>

            <div class="welcome-text">
                <h2>Selamat Datang!</h2>
                <p>Silakan login untuk mengakses sistem pelayanan pasien Puskesmas Katoi.</p>

                <ul class="features-list">
                    <li><i class="fas fa-check-circle"></i> Pendaftaran Online</li>
                    <li><i class="fas fa-calendar-check"></i> Cek Jadwal Periksa</li>
                    <li><i class="fas fa-chart-line"></i> Riwayat Pelayanan</li>
                    <li><i class="fas fa-newspaper"></i> Informasi Berita Terkini</li>
                </ul>
            </div>
        </div>

        <!-- Right Panel - Form Section -->
        <div class="login-right">
            <h2>Login</h2>
            <p>Masukkan email dan password Anda</p>

            @if (session('status'))
                <div class="alert alert-success">
                    <i class="fas fa-check-circle"></i> {{ session('status') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger">
                    <i class="fas fa-exclamation-circle"></i> {{ $errors->first() }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" id="loginForm">
                @csrf

                <!-- Email Field -->
                <div class="input-group">
                    <label class="input-label">
                        <i class="fas fa-envelope"></i> Email
                    </label>
                    <div class="input-wrapper">
                        <input type="email" name="email" placeholder="Masukkan email Anda"
                               value="{{ old('email') }}" required autofocus>
                    </div>
                </div>

                <!-- Password Field -->
                <div class="input-group">
                    <label class="input-label">
                        <i class="fas fa-lock"></i> Password
                    </label>
                    <div class="input-wrapper">
                        <input type="password" name="password" id="password"
                               placeholder="Masukkan password Anda" required>
                        <button type="button" class="password-toggle" onclick="togglePassword()">
                            <i class="fas fa-eye" id="toggleIcon"></i>
                        </button>
                    </div>
                </div>

                <!-- Options -->
                <div class="login-options">
                    <label class="checkbox-container">
                        <input type="checkbox" name="remember" {{ old('remember') ? 'checked' : '' }}>
                        <span>Ingat saya</span>
                    </label>
                    @if (Route::has('password.request'))
                        <a href="{{ route('password.request') }}" class="forgot-link">
                            Lupa password?
                        </a>
                    @endif
                </div>

                <!-- Submit Button -->
                <button type="submit" class="login-btn" id="loginBtn">
                    Masuk <i class="fas fa-arrow-right"></i>
                </button>
            </form>

            <!-- Register Link -->
            <div class="register-section">
                <p>
                    Belum punya akun?
                    <a href="{{ route('register') }}" class="register-link">
                        Daftar Sekarang <i class="fas fa-user-plus"></i>
                    </a>
                </p>
            </div>
        </div>
    </div>

    <script>
        const loginForm = document.getElementById('loginForm');
        const loginBtn = document.getElementById('loginBtn');
        const passwordInput = document.getElementById('password');
        const toggleIcon = document.getElementById('toggleIcon');

        if (loginForm) {
            loginForm.addEventListener('submit', function(e) {
                loginBtn.innerHTML = 'Memproses <i class="fas fa-spinner fa-spin"></i>';
                loginBtn.classList.add('loading');
                loginBtn.disabled = true;
            });
        }

        // Password visibility toggle
        function togglePassword() {
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                toggleIcon.classList.remove('fa-eye');
                toggleIcon.classList.add('fa-eye-slash');
            } else {
                passwordInput.type = 'password';
                toggleIcon.classList.remove('fa-eye-slash');
                toggleIcon.classList.add('fa-eye');
            }
        }
    </script>
</body>
</html>
