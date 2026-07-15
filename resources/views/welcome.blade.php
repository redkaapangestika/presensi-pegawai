<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="theme-color" content="#0ea5e9">
    <title>Sistem Informasi Presensi Pegawai</title>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>

    <style>
        :root {
            --primary: #0ea5e9;
            --primary-dark: #0284c7;
            --bg-color: #f8fafc;
            --text-dark: #1e293b;
            --text-light: #64748b;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-dark);
            height: 100vh;
            display: flex;
            flex-direction: column;
            overflow-x: hidden;
        }

        .hero-section {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
            padding: 60px 20px 40px;
            color: white;
            text-align: center;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            box-shadow: 0 10px 25px rgba(14, 165, 233, 0.2);
            position: relative;
        }

        .hero-section::after {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
            background: url("data:image/svg+xml,%3Csvg width='100' height='100' viewBox='0 0 100 100' xmlns='http://www.w3.org/2000/svg'%3E%3Cpath d='M11 18c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm48 25c3.866 0 7-3.134 7-7s-3.134-7-7-7-7 3.134-7 7 3.134 7 7 7zm-43-7c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm63 31c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM34 90c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zm56-76c1.657 0 3-1.343 3-3s-1.343-3-3-3-3 1.343-3 3 1.343 3 3 3zM12 86c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm28-65c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm23-11c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-6 60c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm29 22c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zM32 63c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm57-13c2.76 0 5-2.24 5-5s-2.24-5-5-5-5 2.24-5 5 2.24 5 5 5zm-9-21c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM60 91c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM35 41c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2zM12 60c1.105 0 2-.895 2-2s-.895-2-2-2-2 .895-2 2 .895 2 2 2z' fill='%23ffffff' fill-opacity='0.1' fill-rule='evenodd'/%3E%3C/svg%3E");
            animation: pulse-bg 15s linear infinite;
            border-bottom-left-radius: 40px;
            border-bottom-right-radius: 40px;
            pointer-events: none;
        }

        @keyframes pulse-bg {
            0% {
                background-position: 0 0;
            }

            100% {
                background-position: 100px 100px;
            }
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-8px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .logo-wrap {
            width: 90px;
            height: 90px;
            background: white;
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            box-shadow: 0 8px 16px rgba(0, 0, 0, 0.1);
            position: relative;
            z-index: 2;
            animation: float 3s ease-in-out infinite;
        }

        .logo-wrap ion-icon {
            font-size: 50px;
            color: var(--primary);
        }

        .welcome-title {
            font-size: 1.5rem;
            font-weight: 800;
            margin-bottom: 10px;
            letter-spacing: -0.5px;
            position: relative;
            z-index: 2;
            animation: fadeInUp 0.8s ease-out;
        }

        .welcome-subtitle {
            font-size: 0.95rem;
            font-weight: 400;
            opacity: 0.9;
            position: relative;
            z-index: 2;
            animation: fadeInUp 1s ease-out;
        }

        .action-container {
            padding: 40px 20px;
            flex-grow: 1;
            display: flex;
            flex-direction: column;
            gap: 20px;
            animation: fadeInUp 1.2s ease-out;
        }

        .login-card {
            background: white;
            border-radius: 20px;
            padding: 24px 20px;
            display: flex;
            align-items: center;
            text-decoration: none;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(0, 0, 0, 0.02);
            transform: translateY(0);
        }

        .login-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.1);
        }

        .login-card:active {
            transform: scale(0.97);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        .login-card-icon {
            width: 54px;
            height: 54px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            font-size: 26px;
        }

        .card-pegawai .login-card-icon {
            background: #eff6ff;
            color: #3b82f6;
        }

        .card-pengelola .login-card-icon {
            background: #fffbeb;
            color: #d97706;
        }

        .login-card-content h3 {
            color: var(--text-dark);
            font-size: 1.15rem;
            margin-bottom: 4px;
            font-weight: 700;
            letter-spacing: -0.3px;
        }

        .login-card-content p {
            color: var(--text-light);
            font-size: 0.85rem;
            font-weight: 500;
            line-height: 1.3;
        }

        .chevron-icon {
            position: absolute;
            right: 20px;
            color: #cbd5e1;
            font-size: 24px;
        }

        .footer {
            text-align: center;
            padding: 20px;
            color: #94a3b8;
            font-size: 0.75rem;
            font-weight: 500;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(255, 255, 255, 0.2);
            backdrop-filter: blur(5px);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 20px;
            cursor: pointer;
            z-index: 10;
        }

        body.dark-mode {
            --bg-color: #0f172a;
            --text-dark: #f8fafc;
            --text-light: #94a3b8;
        }

        body.dark-mode .login-card {
            background: #1e293b;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.2);
            border: 1px solid rgba(255, 255, 255, 0.05);
        }

        body.dark-mode .card-pegawai .login-card-icon {
            background: #1e3a8a;
            color: #60a5fa;
        }

        body.dark-mode .card-pengelola .login-card-icon {
            background: #78350f;
            color: #fbbf24;
        }

        body.dark-mode .logo-wrap {
            background: #1e293b;
        }
    </style>
</head>

<body>

    <div class="hero-section">
        <div class="theme-toggle" onclick="toggleDarkMode()">
            <ion-icon name="moon-outline" id="themeIcon"></ion-icon>
        </div>
        <div class="logo-wrap">
            <ion-icon name="finger-print"></ion-icon>
        </div>
        <h1 class="welcome-title">E-Presensi Kelurahan</h1>
        <p class="welcome-subtitle">Sistem Informasi Presensi Pegawai<br>Condongcatur Berbasis GPS</p>
    </div>

    <div class="action-container">

        <a href="/login" class="login-card card-pegawai">
            <div class="login-card-icon">
                <ion-icon name="person"></ion-icon>
            </div>
            <div class="login-card-content">
                <h3>Login Pegawai</h3>
                <p>Masuk untuk melakukan presensi dan melihat riwayat Anda.</p>
            </div>
            <ion-icon name="chevron-forward-outline" class="chevron-icon"></ion-icon>
        </a>

        <a href="/panel" class="login-card card-pengelola">
            <div class="login-card-icon">
                <ion-icon name="shield"></ion-icon>
            </div>
            <div class="login-card-content">
                <h3>Portal Pengelola</h3>
                <p>Masuk sebagai Admin, Lurah, atau Petugas Validasi.</p>
            </div>
            <ion-icon name="chevron-forward-outline" class="chevron-icon"></ion-icon>
        </a>

    </div>

    <div class="footer">
        &copy; <?php echo date("Y"); ?> Kalurahan Condongcatur.<br>All rights reserved.
    </div>

    <script>
        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('themeIcon').name = isDark ? 'sunny-outline' : 'moon-outline';
        }

        // On load
        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            document.getElementById('themeIcon').name = 'sunny-outline';
        }
    </script>
</body>

</html>