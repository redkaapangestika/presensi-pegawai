<!doctype html>
<!--
* Tabler - Premium and Open Source dashboard template with responsive and high quality UI.
* @version 1.0.0-beta17
* @link https://tabler.io
* Copyright 2018-2023 The Tabler Authors
* Copyright 2018-2023 codecalm.net Paweł Kuna
* Licensed under MIT (https://github.com/tabler/tabler/blob/master/LICENSE)
-->
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover" />
  <meta http-equiv="X-UA-Compatible" content="ie=edge" />
  <title>Sign in with illustration - Tabler - Premium and Open Source dashboard template with responsive and high
    quality UI.</title>
  <!-- CSS files -->
  <link href="{{ asset('tabler/dist/css/tabler.min.css?1674944402') }}" rel="stylesheet" />
  <link href="{{ asset('tabler/dist/css/tabler-flags.min.css?1674944402') }}" rel="stylesheet" />
  <link href="{{ asset('tabler/dist/css/tabler-payments.min.css?1674944402') }}" rel="stylesheet" />
  <link href="{{ asset('tabler/dist/css/tabler-vendors.min.css?1674944402') }}" rel="stylesheet" />
  <link href="{{ asset('tabler/dist/css/demo.min.css?1674944402') }}" rel="stylesheet" />
  <style>
    @import url('https://rsms.me/inter/inter.css');

    :root {
      --tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
    }

    body {
      font-feature-settings: "cv03", "cv04", "cv11";
      background-color: #f0f4f8 !important;
      background-image: url("data:image/svg+xml,%3Csvg width='60' height='60' viewBox='0 0 60 60' xmlns='http://www.w3.org/2000/svg'%3E%3Cg fill='none' fill-rule='evenodd'%3E%3Cg fill='%230054a6' fill-opacity='0.05'%3E%3Cpath d='M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E") !important;
    }

    .card-md {
      border-radius: 20px !important;
      box-shadow: 0 10px 40px rgba(0, 0, 0, 0.08) !important;
      border: 1px solid rgba(0, 0, 0, 0.03) !important;
      transition: all 0.3s ease !important;
    }

    .card-md:hover {
      transform: translateY(-8px);
      box-shadow: 0 15px 50px rgba(0, 84, 166, 0.15) !important;
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
      z-index: 100;
      transition: 0.3s;
    }

    body[data-bs-theme="dark"] {
      background-color: #0f172a !important;
      background-image: none !important;
    }

    body[data-bs-theme="dark"] .theme-toggle {
      background: rgba(255, 255, 255, 0.1);
      color: #f8fafc;
    }

    body[data-bs-theme="dark"] .card-md {
      background-color: #1e293b !important;
      border-color: rgba(255, 255, 255, 0.05) !important;
    }

    body[data-bs-theme="dark"] h2,
    body[data-bs-theme="dark"] p {
      color: #f8fafc !important;
    }
  </style>
</head>

<body class=" d-flex flex-column">

  <!-- Aksi Toggle Dark Mode, ID disamakan agar bisa dipanggil JavaScript -->
  <div class="theme-toggle" onclick="toggleDarkMode()">
    <svg id="themeIcon" xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
      stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
    </svg>
  </div>

  <a href="/" style="position:absolute; top:20px; left:20px; font-size:28px; color:#64748b; z-index:100; opacity:0.7;">
    <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="30" height="30" viewBox="0 0 24 24" stroke-width="2"
      stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
      <path stroke="none" d="M0 0h24v24H0z" fill="none" />
      <path d="M5 12l14 0" />
      <path d="M5 12l6 6" />
      <path d="M5 12l6 -6" />
    </svg>
  </a>

  <script src="{{ asset('tabler/dist/js/demo-theme.min.js?1674944402') }}"></script>
  <div class="page page-center">
    <div class="container container-normal py-4">
      <div class="container container-tight py-4">
        <div class="card card-md mt-4">
          <div class="card-body">
            <div class="text-center mb-4 mt-2">
              <img src="{{ asset('assets/img/login/login.png') }}" height="220" class="d-block mx-auto"
                style="border-radius: 16px; box-shadow: 0 8px 20px rgba(0,0,0,0.08);" alt="">
            </div>
            <h2 class="h2 text-center mb-1">Login Panel</h2>
            <p class="text-muted text-center mb-4">Admin &bull; Petugas &bull; Lurah</p>
            @if (Session::get('warning'))
              <div class="alert alert-warning">
                <p>{{ Session::get('warning') }}</p>
              </div>
            @endif
            <form action="/panel" method="post" autocomplete="off" novalidate>
              @csrf
              <div class="mb-3">
                <label class="form-label">Email address</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com" autocomplete="off">
              </div>
              <div class="mb-2">
                <label class="form-label">Password</label>
                <div class="input-group input-group-flat">
                  <input type="password" name="password" class="form-control" placeholder="Your password"
                    autocomplete="off">
                  <span class="input-group-text">
                    <a href="#" class="link-secondary" title="Show password" data-bs-toggle="tooltip">
                      <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                        <path d="M12 12m-2 0a2 2 0 1 0 4 0a2 2 0 1 0 -4 0" />
                        <path
                          d="M22 12c-2.667 4.667 -6 7 -10 7s-7.333 -2.333 -10 -7c2.667 -4.667 6 -7 10 -7s7.333 2.333 10 7" />
                      </svg>
                    </a>
                  </span>
                </div>
              </div>
              <div class="mb-2">
                <label class="form-check">
                  <input type="checkbox" class="form-check-input" />
                  <span class="form-check-label">Remember me on this device</span>
                </label>
              </div>
              <div class="form-footer">
                <button type="submit" class="btn btn-primary w-100">Sign in</button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Libs JS -->
  <!-- Tabler Core -->
  <script src="{{ asset('tabler/dist/js/tabler.min.js?1674944402') }}" defer></script>
  <script src="{{ asset('tabler/dist/js/demo.min.js?1674944402') }}" defer></script>

  <script>
    document.addEventListener("DOMContentLoaded", function () {
      const togglePassword = document.querySelector('.input-group-text .link-secondary');
      const passwordInput = document.querySelector('input[name="password"]');

      if (togglePassword && passwordInput) {
        togglePassword.addEventListener('click', function (e) {
          e.preventDefault();
          const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
          passwordInput.setAttribute('type', type);
        });
      }
    });

    function toggleDarkMode() {
      const body = document.body;
      const currentTheme = body.getAttribute('data-bs-theme');
      const newTheme = currentTheme === 'dark' ? 'light' : 'dark';

      body.setAttribute('data-bs-theme', newTheme);
      localStorage.setItem('theme', newTheme);
      localStorage.setItem('tablerTheme', newTheme);

      const svgSun = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />';
      const svgMoon = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />';

      const icon = document.getElementById('themeIcon');
      if (icon) icon.innerHTML = newTheme === 'dark' ? svgSun : svgMoon;
    }

    if (localStorage.getItem('theme') === 'dark') {
      document.body.setAttribute('data-bs-theme', 'dark');
      const svgSun = '<path stroke="none" d="M0 0h24v24H0z" fill="none"/><path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" /><path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />';
      const icon = document.getElementById('themeIcon');
      if (icon) icon.innerHTML = svgSun;
    } else {
      document.body.setAttribute('data-bs-theme', 'light');
    }
  </script>
</body>

</html>