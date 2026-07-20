<!doctype html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport"
        content="width=device-width, initial-scale=1, minimum-scale=1, maximum-scale=1, viewport-fit=cover" />
    <meta name="apple-mobile-web-app-capable" content="yes" />
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <meta name="theme-color" content="#000000">
    <title>E-Presensi Condongcatur</title>
    <meta name="description" content="E-Presensi Condongcatur">
    <meta name="keywords" content="bootstrap 4, mobile template, cordova, phonegap, mobile, html" />
    <link rel="icon" type="image/png" href="{{ asset('assets/img/favicon.png') }}" sizes="32x32">
    <link rel="apple-touch-icon" sizes="180x180" href="{{ asset('assets/img/icon/192x192.png') }}">
    <link rel="preload" href="{{ asset('assets/img/login/login.png') }}" as="image">
    <link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
    <link rel="manifest" href="__manifest.json">
    <style>
        body.bg-white {
            background-color: #f0f4f8 !important;
            background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230ea5e9' fill-opacity='0.08'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") !important;
            display: flex;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
        }

        #appCapsule {
            width: 100%;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .login-form {
            background: white;
            border-radius: 20px;
            padding: 40px 30px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08);
            margin: 20px;
            transition: all 0.3s ease;
            max-width: 420px;
            width: 100%;
            border: 1px solid rgba(0, 0, 0, 0.03);
            position: relative;
        }

        .login-form:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 50px rgba(14, 165, 233, 0.15);
        }

        .form-image {
            max-width: 250px;
            margin-bottom: 20px;
        }

        .theme-toggle {
            position: absolute;
            top: 20px;
            right: 20px;
            background: rgba(0, 0, 0, 0.05);
            border-radius: 50%;
            width: 42px;
            height: 42px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #64748b;
            font-size: 20px;
            cursor: pointer;
            z-index: 15;
            transition: 0.3s;
        }

        body.dark-mode {
            background-color: #0f172a !important;
            background-image: none !important;
        }

        body.dark-mode .login-form {
            background: #1e293b;
            border-color: rgba(255, 255, 255, 0.05);
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.4);
        }

        body.dark-mode .login-form:hover {
            box-shadow: 0 15px 50px rgba(0, 0, 0, 0.6);
        }

        body.dark-mode h2,
        body.dark-mode h4 {
            color: #f8fafc;
        }

        body.dark-mode .form-control {
            background: #0f172a;
            border: 1px solid #334155;
            color: #f8fafc;
        }

        body.dark-mode .form-control:focus {
            background: #0f172a;
            border-color: #0ea5e9;
            color: #f8fafc;
        }

        body.dark-mode .theme-toggle {
            background: rgba(255, 255, 255, 0.1);
            color: #f8fafc;
        }

        body.dark-mode .password-toggle ion-icon {
            color: #94a3b8;
        }
    </style>
</head>

<body class="bg-white">

    <!-- loader -->
    <div id="loader">
        <div class="spinner-border text-primary" role="status"></div>
    </div>
    <!-- * loader -->


    <!-- App Capsule -->
    <div id="appCapsule" class="pt-0 relative">
        <a href="/" style="position:absolute; top:20px; left:20px; font-size:28px; color:#64748b; z-index:10;">
            <ion-icon name="arrow-back-outline"></ion-icon>
        </a>

        <div class="theme-toggle" onclick="toggleDarkMode()">
            <ion-icon name="moon-outline" id="themeIcon"></ion-icon>
        </div>

        <div class="login-form mt-1">
            <div class="section">
                <img src="{{ asset('assets/img/login/login.png')}}" alt="E-Presensi" class="form-image"
                    fetchpriority="high" loading="eager" width="250" height="250">
            </div>
            <div class="section mt-1">
                <h2>E-Presensi</h2>
                <h4>Jangan lupa login dulu!</h4>
            </div>
            <div class="section mt-1 mb-5">
                @php
                    $messagewarning = Session::get('warning');
                @endphp
                @if (Session::get('warning'))
                    <div class="alert outline alert-warning">
                        {{ $messagewarning }}
                    </div>
                @endif
                <form action="/proseslogin" method="POST">
                    @csrf
                    <div class="form-group boxed">
                        <div class="input-wrapper">
                            <input type="text" name="id_pegawai" class="form-control" id="id_pegawai"
                                placeholder="ID Pegawai">
                            <i class="clear-input">
                                <ion-icon name="close-circle"></ion-icon>
                            </i>
                        </div>
                    </div>

                    <div class="form-group boxed">
                        <div class="input-wrapper" style="position: relative;">
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Password">
                            <span class="password-toggle" onclick="togglePassword('password', this)"
                                style="position: absolute; right: 10px; top: 12px; font-size: 20px; color: #64748b; cursor: pointer; z-index: 10;">
                                <ion-icon name="eye-outline"></ion-icon>
                            </span>
                        </div>
                    </div>

                    <div class="form-links mt-2 mb-4 d-flex justify-content-between">
                        <div><a href="javascript:void(0);" onclick="Swal.fire({
                            icon: 'info',
                            title: 'Lupa Password?',
                            text: 'Silahkan hubungi Administrator / Bagian Tata Usaha Kalurahan untuk mereset password Anda.',
                            confirmButtonColor: '#0ea5e9'
                        })" class="text-muted">Forgot Password?</a></div>
                    </div>

                    <div class="mt-4">
                        <button type="submit" class="btn btn-primary btn-block btn-lg"
                            style="border-radius:12px; box-shadow: 0 4px 12px rgba(14,165,233,0.3);">Log in</button>
                    </div>

                </form>
            </div>
        </div>

    </div>
    <!-- * App Capsule -->

    <!-- ///////////// Js Files ////////////////////  -->
    <!-- Jquery -->
    <script src="{{ asset('assets/js/lib/jquery-3.4.1.min.js') }}"></script>
    <!-- Bootstrap-->
    <script src="{{ asset('assets/js/lib/popper.min.js') }}"></script>
    <script src="{{ asset('assets/js/lib/bootstrap.min.js') }}"></script>
    <!-- Ionicons -->
    <script type="module" src="https://unpkg.com/ionicons@5.0.0/dist/ionicons/ionicons.js" defer></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11" defer></script>
    <!-- Base Js File -->
    <script src="{{ asset('assets/js/base.js') }}"></script>

    <script>
        function togglePassword(inputId, iconSpan) {
            var input = document.getElementById(inputId);
            var icon = iconSpan.querySelector('ion-icon');
            if (input.type === "password") {
                input.type = "text";
                icon.setAttribute('name', 'eye-off-outline');
            } else {
                input.type = "password";
                icon.setAttribute('name', 'eye-outline');
            }
        }

        function toggleDarkMode() {
            document.body.classList.toggle('dark-mode');
            const isDark = document.body.classList.contains('dark-mode');
            localStorage.setItem('theme', isDark ? 'dark' : 'light');
            document.getElementById('themeIcon').name = isDark ? 'sunny-outline' : 'moon-outline';
        }

        if (localStorage.getItem('theme') === 'dark') {
            document.body.classList.add('dark-mode');
            const themeIcon = document.getElementById('themeIcon');
            if (themeIcon) {
                themeIcon.name = 'sunny-outline';
            }
        }
    </script>

</body>

</html>