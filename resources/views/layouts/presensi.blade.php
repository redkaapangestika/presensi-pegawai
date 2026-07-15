<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>Dashboard E-Presensi</title>
    <meta name="description" content="Dashboard E-Presensi">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">

    <link rel="manifest" href="__manifest.json">
    <style>
        /* Dark Mode Global Styles */
        body.dark-mode {
            background-color: #111827 !important;
            color: #f3f4f6 !important;
        }

        body.dark-mode .appHeader,
        body.dark-mode .appBottomMenu,
        body.dark-mode .presensi-container,
        body.dark-mode .page-container,
        body.dark-mode .bg-main-curve {
            background: #1f2937 !important;
        }

        body.dark-mode .log-kerja-card,
        body.dark-mode .izin-card,
        body.dark-mode .profile-card,
        body.dark-mode .rekap-item,
        body.dark-mode .menu-floating-card,
        body.dark-mode .nav-tabs-modern,
        body.dark-mode .listview.image-listview>li,
        body.dark-mode .item,
        body.dark-mode .form-group-custom,
        body.dark-mode .box-presensi,
        body.dark-mode .profile-info-card,
        body.dark-mode .action-card,
        body.dark-mode .modal-content {
            background-color: #374151 !important;
            border-color: #4b5563 !important;
        }

        body.dark-mode h1,
        body.dark-mode h2,
        body.dark-mode h3,
        body.dark-mode h4,
        body.dark-mode b,
        body.dark-mode label,
        body.dark-mode .rekap-label,
        body.dark-mode .rekap-title,
        body.dark-mode .info-value,
        body.dark-mode .izin-date,
        body.dark-mode .historicard .card-title,
        body.dark-mode .font-weight-bold {
            color: #f3f4f6 !important;
        }

        body.dark-mode .log-kerja-input,
        body.dark-mode .custom-input,
        body.dark-mode .form-control,
        body.dark-mode input,
        body.dark-mode select,
        body.dark-mode textarea {
            background-color: #1f2937 !important;
            color: #e5e7eb !important;
            border-color: #4b5563 !important;
        }

        body.dark-mode .text-muted,
        body.dark-mode .izin-ket,
        body.dark-mode .info-label,
        body.dark-mode .modern-menu-text,
        body.dark-mode .historicard p {
            color: #9ca3af !important;
        }

        body.dark-mode .pageTitle {
            color: #fff !important;
        }

        body.dark-mode .form-control-custom,
        body.dark-mode .sisa-cuti-wrapper,
        body.dark-mode .historicard {
            background: transparent !important;
        }

        body.dark-mode .modal-header,
        body.dark-mode .modal-footer,
        body.dark-mode .info-item,
        body.dark-mode .historicard-header {
            border-color: #4b5563 !important;
        }

        body.dark-mode .address-card {
            background-color: #374151 !important;
            color: #e5e7eb !important;
            border: 1px solid #4b5563 !important;
        }

        body.dark-mode .nav-tabs-modern .nav-link {
            color: #9ca3af !important;
        }

        body.dark-mode .nav-tabs-modern .nav-link.active {
            color: #38bdf8 !important;
            border-bottom: 2px solid #38bdf8 !important;
        }

        body.dark-mode .appBottomMenu .item.active {
            color: #ffffff !important;
        }

        body.dark-mode .filter-container {
            background-color: #111827 !important;
        }

        body.dark-mode .alert-warning {
            background-color: #78350f !important;
            color: #fde68a !important;
            border: none;
        }
    </style>
</head>

<body style="background-color:#e9ecef;">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->

    @yield('header')

    <!-- App Capsule -->
    <div id="appCapsule">
        @yield('content')
    </div>
    <!-- * App Capsule -->


    @include('layouts.buttomNav')


    @include('layouts.script')



</body>

</html>