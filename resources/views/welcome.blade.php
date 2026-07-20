<!doctype html>
<html lang="id">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=5, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#0c1a2e">
    <title>E-Presensi · Kalurahan Condongcatur</title>
    <meta name="description" content="Sistem Informasi Presensi Pegawai Kalurahan Condongcatur berbasis GPS dan foto.">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap"
        rel="stylesheet">

    <style>
        :root {
            --primary: #38bdf8;
            --primary-glow: rgba(56, 189, 248, 0.3);
            --accent: #818cf8;
            --accent2: #34d399;
            --bg-deep: #060d1a;
            --bg-card: rgba(255, 255, 255, 0.04);
            --bg-card-hover: rgba(255, 255, 255, 0.08);
            --border: rgba(255, 255, 255, 0.08);
            --text-main: #f0f6ff;
            --text-muted: #7c8da8;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Inter', sans-serif;
            background: var(--bg-deep);
            color: var(--text-main);
            min-height: 100vh;
            overflow-x: hidden;
        }

        /* ── Background ── */
        .bg-mesh {
            position: fixed;
            inset: 0;
            z-index: 0;
            background:
                radial-gradient(ellipse 80% 60% at 10% 0%, rgba(56, 189, 248, 0.18) 0%, transparent 60%),
                radial-gradient(ellipse 70% 60% at 90% 100%, rgba(129, 140, 248, 0.15) 0%, transparent 60%),
                radial-gradient(ellipse 50% 50% at 50% 50%, rgba(52, 211, 153, 0.05) 0%, transparent 70%),
                #060d1a;
        }

        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(56, 189, 248, 0.04) 1px, transparent 1px),
                linear-gradient(90deg, rgba(56, 189, 248, 0.04) 1px, transparent 1px);
            background-size: 80px 80px;
        }

        /* ── Floating orbs ── */
        .orb {
            position: fixed;
            border-radius: 50%;
            filter: blur(80px);
            animation: drift 18s ease-in-out infinite;
            pointer-events: none;
            z-index: 0;
        }

        .orb-1 {
            width: 400px;
            height: 400px;
            background: rgba(56, 189, 248, 0.08);
            top: -100px;
            left: -100px;
        }

        .orb-2 {
            width: 300px;
            height: 300px;
            background: rgba(129, 140, 248, 0.1);
            bottom: -50px;
            right: -80px;
            animation-delay: -8s;
        }

        .orb-3 {
            width: 200px;
            height: 200px;
            background: rgba(52, 211, 153, 0.07);
            top: 40%;
            left: 60%;
            animation-delay: -4s;
        }

        @keyframes drift {

            0%,
            100% {
                transform: translate(0, 0) scale(1);
            }

            33% {
                transform: translate(30px, -20px) scale(1.05);
            }

            66% {
                transform: translate(-20px, 30px) scale(0.95);
            }
        }

        /* ── Layout ── */
        .page-wrap {
            position: relative;
            z-index: 1;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            max-width: 520px;
            margin: 0 auto;
            padding: 0 20px 40px;
        }

        /* ── Desktop 2-column layout ── */
        @media (min-width: 768px) {
            .page-wrap {
                max-width: 960px;
                padding: 0 48px 60px;
                display: grid;
                grid-template-columns: 1fr 1fr;
                grid-template-rows: auto;
                column-gap: 60px;
                align-items: start;
            }

            .top-nav {
                grid-column: 1 / -1;
            }

            .hero {
                grid-column: 1;
                grid-row: 2 / 6;
                padding-top: 8px;
            }

            .stats-row {
                grid-column: 2;
                grid-row: 2;
            }

            .feature-ribbon {
                grid-column: 2;
                grid-row: 3;
            }

            .cards-section {
                grid-column: 2;
                grid-row: 4;
            }

            .info-strip {
                grid-column: 2;
                grid-row: 5;
            }

            .footer {
                grid-column: 1 / -1;
                grid-row: 6;
                padding-top: 32px;
                border-top: 1px solid var(--border);
                margin-top: 24px;
            }
        }

        /* ── Top nav ── */
        .top-nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 20px 0 16px;
        }

        .nav-badge {
            display: flex;
            align-items: center;
            gap: 8px;
            background: rgba(56, 189, 248, 0.1);
            border: 1px solid rgba(56, 189, 248, 0.2);
            border-radius: 99px;
            padding: 6px 14px;
            font-size: 11px;
            font-weight: 600;
            color: var(--primary);
            letter-spacing: 0.5px;
            text-transform: uppercase;
        }

        .nav-badge .dot {
            width: 6px;
            height: 6px;
            background: var(--accent2);
            border-radius: 50%;
            animation: blink 2s ease-in-out infinite;
        }

        @keyframes blink {

            0%,
            100% {
                opacity: 1;
            }

            50% {
                opacity: 0.3;
            }
        }

        .theme-btn {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 50%;
            width: 40px;
            height: 40px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
            cursor: pointer;
            color: var(--text-muted);
            transition: all 0.2s;
        }

        .theme-btn:hover {
            background: var(--bg-card-hover);
            color: var(--primary);
        }

        /* ── Hero ── */
        .hero {
            padding: 24px 0 36px;
            animation: fadeUp 0.7s ease-out both;
        }

        .logo-ring {
            display: inline-block;
            margin-bottom: 24px;
        }

        .logo-ring img {
            height: 64px;
            width: auto;
            display: block;
            filter: drop-shadow(0 4px 12px rgba(0, 0, 0, 0.4));
        }

        @keyframes pulse-ring {

            0%,
            100% {
                box-shadow: 0 0 0 8px rgba(56, 189, 248, 0.06), 0 0 0 16px rgba(56, 189, 248, 0.03);
            }

            50% {
                box-shadow: 0 0 0 12px rgba(56, 189, 248, 0.1), 0 0 0 24px rgba(56, 189, 248, 0.04);
            }
        }

        .hero-eyebrow {
            font-size: 11px;
            font-weight: 600;
            letter-spacing: 2px;
            text-transform: uppercase;
            color: var(--primary);
            margin-bottom: 10px;
        }

        .hero-title {
            font-size: clamp(1.8rem, 8vw, 3rem);
            font-weight: 900;
            line-height: 1.1;
            letter-spacing: -1.5px;
            margin-bottom: 16px;
            background: linear-gradient(135deg, #f0f6ff 0%, #7ec8f5 60%, #a5b4fc 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .hero-sub {
            font-size: clamp(0.83rem, 3vw, 0.95rem);
            color: var(--text-muted);
            line-height: 1.65;
            max-width: 340px;
        }

        /* ── Stats row ── */
        .stats-row {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 12px;
            margin-bottom: 32px;
            animation: fadeUp 0.9s ease-out both;
        }

        .stat-chip {
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 16px;
            padding: 14px 10px;
            text-align: center;
            backdrop-filter: blur(8px);
        }

        .stat-val {
            font-size: 1.4rem;
            font-weight: 800;
            letter-spacing: -0.5px;
            background: linear-gradient(135deg, #f0f6ff, var(--primary));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }

        .stat-label {
            font-size: 9.5px;
            font-weight: 600;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            color: var(--text-muted);
            margin-top: 2px;
        }

        /* ── Feature ribbon ── */
        .feature-ribbon {
            display: flex;
            gap: 8px;
            margin-bottom: 32px;
            overflow-x: auto;
            scrollbar-width: none;
            animation: fadeUp 1s ease-out both;
        }

        .feature-ribbon::-webkit-scrollbar {
            display: none;
        }

        .feat-tag {
            flex-shrink: 0;
            display: flex;
            align-items: center;
            gap: 6px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 99px;
            padding: 7px 14px;
            font-size: 12px;
            font-weight: 500;
            color: var(--text-muted);
            white-space: nowrap;
        }

        .feat-tag .icon {
            font-size: 14px;
        }

        .feat-tag.active {
            background: rgba(56, 189, 248, 0.1);
            border-color: rgba(56, 189, 248, 0.25);
            color: var(--primary);
        }

        /* ── Login Cards ── */
        .cards-section {
            display: flex;
            flex-direction: column;
            gap: 14px;
            margin-bottom: 32px;
            animation: fadeUp 1.1s ease-out both;
        }

        .login-card {
            display: flex;
            align-items: center;
            gap: 18px;
            padding: 22px 20px;
            background: var(--bg-card);
            border: 1px solid var(--border);
            border-radius: 22px;
            text-decoration: none;
            backdrop-filter: blur(12px);
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .login-card::before {
            content: '';
            position: absolute;
            inset: 0;
            border-radius: 22px;
            opacity: 0;
            transition: opacity 0.25s;
        }

        .card-pegawai::before {
            background: radial-gradient(ellipse at top left, rgba(56, 189, 248, 0.12), transparent 70%);
        }

        .card-pengelola::before {
            background: radial-gradient(ellipse at top left, rgba(129, 140, 248, 0.12), transparent 70%);
        }

        .login-card:hover {
            transform: translateY(-4px);
            border-color: rgba(255, 255, 255, 0.14);
            box-shadow: 0 20px 40px rgba(0, 0, 0, 0.3);
        }

        .login-card:hover::before {
            opacity: 1;
        }

        .login-card:active {
            transform: scale(0.98);
        }

        .card-icon-wrap {
            width: 56px;
            height: 56px;
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 26px;
            flex-shrink: 0;
            position: relative;
            z-index: 1;
        }

        .card-pegawai .card-icon-wrap {
            background: linear-gradient(135deg, rgba(56, 189, 248, 0.2), rgba(56, 189, 248, 0.05));
            border: 1px solid rgba(56, 189, 248, 0.2);
            color: var(--primary);
        }

        .card-pengelola .card-icon-wrap {
            background: linear-gradient(135deg, rgba(129, 140, 248, 0.2), rgba(129, 140, 248, 0.05));
            border: 1px solid rgba(129, 140, 248, 0.2);
            color: var(--accent);
        }

        .card-body {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        .card-title {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-main);
            margin-bottom: 4px;
            letter-spacing: -0.3px;
        }

        .card-desc {
            font-size: 0.8rem;
            color: var(--text-muted);
            line-height: 1.5;
        }

        .card-arrow {
            flex-shrink: 0;
            width: 34px;
            height: 34px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.05);
            border: 1px solid var(--border);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
            color: var(--text-muted);
            transition: all 0.25s;
            position: relative;
            z-index: 1;
        }

        .login-card:hover .card-arrow {
            background: rgba(255, 255, 255, 0.1);
            color: var(--text-main);
            transform: translateX(2px);
        }

        .card-pengelola .card-arrow:hover {
            color: var(--accent);
        }

        /* ── Info strip ── */
        .info-strip {
            display: flex;
            align-items: flex-start;
            gap: 12px;
            background: rgba(52, 211, 153, 0.06);
            border: 1px solid rgba(52, 211, 153, 0.15);
            border-radius: 16px;
            padding: 14px 16px;
            margin-bottom: 32px;
            animation: fadeUp 1.2s ease-out both;
        }

        .info-strip-icon {
            font-size: 20px;
            color: var(--accent2);
            margin-top: 1px;
            flex-shrink: 0;
        }

        .info-strip-body {
            font-size: 0.78rem;
            color: var(--text-muted);
            line-height: 1.6;
        }

        .info-strip-body strong {
            color: var(--accent2);
            font-weight: 600;
        }

        /* ── Footer ── */
        .footer {
            text-align: center;
            color: var(--text-muted);
            font-size: 0.72rem;
            line-height: 1.8;
        }

        .footer a {
            color: var(--primary);
            text-decoration: none;
        }

        /* ── Animations ── */
        @keyframes fadeUp {
            from {
                opacity: 0;
                transform: translateY(24px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* ── Responsive tweaks kecil ── */
        @media (max-width: 360px) {
            .stats-row {
                gap: 8px;
            }

            .stat-val {
                font-size: 1.15rem;
            }

            .login-card {
                padding: 16px 14px;
                gap: 12px;
            }

            .card-icon-wrap {
                width: 46px;
                height: 46px;
                font-size: 22px;
            }

            .card-title {
                font-size: 0.95rem;
            }

            .card-desc {
                font-size: 0.75rem;
            }

            .logo-ring {
                width: 64px;
                height: 64px;
                font-size: 30px;
            }
        }

        /* ── Light mode ── */
        body.light-mode {
            --bg-deep: #f1f5f9;
            --bg-card: rgba(255, 255, 255, 0.9);
            --bg-card-hover: rgba(255, 255, 255, 1);
            --border: rgba(0, 0, 0, 0.06);
            --text-main: #0f172a;
            --text-muted: #64748b;
        }

        body.light-mode .bg-mesh {
            background: radial-gradient(ellipse 60% 40% at 20% 0%, rgba(56, 189, 248, 0.1) 0%, transparent 60%), #f1f5f9;
        }

        body.light-mode .bg-grid {
            background-image: linear-gradient(rgba(100, 116, 139, 0.06) 1px, transparent 1px), linear-gradient(90deg, rgba(100, 116, 139, 0.06) 1px, transparent 1px);
            background-size: 80px 80px;
        }

        body.light-mode .hero-title {
            background: linear-gradient(135deg, #0f172a, #0284c7);
            -webkit-background-clip: text;
            background-clip: text;
        }

        body.light-mode .stat-val {
            background: linear-gradient(135deg, #0f172a, #0284c7);
            -webkit-background-clip: text;
            background-clip: text;
        }

        body.light-mode .login-card {
            box-shadow: 0 2px 16px rgba(0, 0, 0, 0.06);
        }

        body.light-mode .login-card:hover {
            box-shadow: 0 12px 40px rgba(0, 0, 0, 0.12);
        }

        body.light-mode .orb {
            opacity: 0.3;
        }

        body.light-mode .logo-ring img {
            filter: drop-shadow(0 2px 6px rgba(0, 0, 0, 0.15));
        }
    </style>
</head>

<body>
    <div class="bg-mesh"></div>
    <div class="bg-grid"></div>
    <div class="orb orb-1"></div>
    <div class="orb orb-2"></div>
    <div class="orb orb-3"></div>

    <div class="page-wrap">

        <!-- Top Nav -->
        <nav class="top-nav">
            <div class="nav-badge">
                <span class="dot"></span>
                Sistem Aktif
            </div>
            <button class="theme-btn" onclick="toggleMode()" id="themeBtn" title="Ganti tema">☀️</button>
        </nav>

        <!-- Hero -->
        <section class="hero">
            <div class="logo-ring">
                <img src="{{ asset('assets/img/logo.png') }}" alt="Logo Kalurahan Condongcatur" fetchpriority="high">
            </div>
            <p class="hero-eyebrow">Kalurahan Condongcatur</p>
            <h1 class="hero-title">E-Presensi<br>Digital</h1>
            <p class="hero-sub">Sistem pencatatan kehadiran modern berbasis GPS & foto untuk seluruh pegawai Kalurahan
                Condongcatur.</p>
        </section>

        <!-- Stats -->
        <div class="stats-row">
            <div class="stat-chip">
                <div class="stat-val" id="statPegawai">26</div>
                <div class="stat-label">Pegawai</div>
            </div>
            <div class="stat-chip">
                <div class="stat-val">GPS</div>
                <div class="stat-label">Verifikasi</div>
            </div>
            <div class="stat-chip">
                <div class="stat-val" id="statTime">--:--</div>
                <div class="stat-label">Sekarang</div>
            </div>
        </div>

        <!-- Feature tags -->
        <div class="feature-ribbon">
            <div class="feat-tag active">GPS Live</div>
            <div class="feat-tag active">Foto Bukti</div>
            <div class="feat-tag">Laporan Otomatis</div>
            <div class="feat-tag">Multi-Role</div>
        </div>

        <!-- Login Cards -->
        <div class="cards-section">
            <a href="/login" class="login-card card-pegawai">
                <div class="card-icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <circle cx="12" cy="8" r="4" />
                        <path d="M4 20c0-4 3.6-7 8-7s8 3 8 7" />
                    </svg>
                </div>
                <div class="card-body">
                    <div class="card-title">Login Pegawai</div>
                    <div class="card-desc">Presensi masuk/pulang, histori, dan pengajuan izin cuti.</div>
                </div>
                <div class="card-arrow">→</div>
            </a>

            <a href="/panel" class="login-card card-pengelola">
                <div class="card-icon-wrap">
                    <svg width="22" height="22" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8"
                        stroke-linecap="round" stroke-linejoin="round">
                        <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z" />
                    </svg>
                </div>
                <div class="card-body">
                    <div class="card-title">Portal Pengelola</div>
                    <div class="card-desc">Dashboard Admin, Petugas validasi & Laporan Lurah.</div>
                </div>
                <div class="card-arrow">→</div>
            </a>
        </div>

        <!-- Info strip -->
        <div class="info-strip">
            <div class="info-strip-body">
                <strong>Login Pegawai</strong>: gunakan <strong>ID Pegawai</strong> (contoh: <strong>L0001</strong>) dan
                password <strong>1234</strong>.
                Untuk Admin/Lurah/Petugas, gunakan akun email di Portal Pengelola.
            </div>
        </div>

        <!-- Footer -->
        <footer class="footer">
            &copy; <?php echo date('Y'); ?> Kalurahan Condongcatur &mdash; Depok, Sleman.<br>
            Dibuat untuk pelayanan publik yang lebih baik.
        </footer>
    </div>

    <script>
        // Live clock
        function updateClock() {
            const now = new Date();
            const h = String(now.getHours()).padStart(2, '0');
            const m = String(now.getMinutes()).padStart(2, '0');
            document.getElementById('statTime').textContent = h + ':' + m;
        }
        updateClock();
        setInterval(updateClock, 30000);

        // Theme toggle (light/dark)
        function toggleMode() {
            const body = document.body;
            const isLight = body.classList.toggle('light-mode');
            localStorage.setItem('theme', isLight ? 'light' : 'dark');
            document.getElementById('themeBtn').textContent = isLight ? '🌙' : '☀️';
        }

        if (localStorage.getItem('theme') === 'light') {
            document.body.classList.add('light-mode');
            document.getElementById('themeBtn').textContent = '🌙';
        }
    </script>
</body>

</html>