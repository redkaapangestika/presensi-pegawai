<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark" id="main-sidebar">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
      aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark">
      <a href=".">
        <img src="{{ asset('tabler/static/logo-white.svg') }}" width="110" height="32" alt="Tabler"
          class="navbar-brand-image">
      </a>
    </h1>
    <div class="navbar-nav flex-row d-lg-none">
      <div class="nav-item dropdown d-none d-md-flex me-3">
        <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
            <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
          </svg>
          <span class="badge bg-red"></span>
        </a>
      </div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          <span class="avatar avatar-sm" style="background-image: url(./static/avatars/000m.jpg)"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::guard('user')->user()->name }}</div>
            <div class="mt-1 small text-muted text-uppercase">{{ Auth::guard('user')->user()->role }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <form action="/proseslogoutadmin" method="POST" style="margin:0; padding:0;">
            @csrf
            <button type="submit" class="dropdown-item"
              style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>

    <div class="collapse navbar-collapse" id="sidebar-menu">
      <ul class="navbar-nav pt-lg-3">

        {{-- ============================================================ --}}
        {{-- HOME — Semua Role (Admin, Petugas, Lurah) --}}
        {{-- ============================================================ --}}
        <li class="nav-item">
          <a class="nav-link" href="/panel/dashboardadmin">
            <span class="nav-link-icon d-md-none d-lg-inline-block">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M5 12l-2 0l9 -9l9 9l-2 0" />
                <path d="M5 12v7a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-7" />
                <path d="M9 21v-6a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v6" />
              </svg>
            </span>
            <span class="nav-link-title">Home</span>
          </a>
        </li>

        {{-- ============================================================ --}}
        {{-- ADMIN ONLY — Data Master --}}
        {{-- ============================================================ --}}
        @if(Auth::guard('user')->user()->role == 'admin')

          <li class="nav-item">
            <span class="nav-link-title ms-3 small text-muted text-uppercase"
              style="font-size:0.65rem; letter-spacing:0.08em;">Master Data</span>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-data-master" data-bs-toggle="dropdown"
              data-bs-auto-close="false" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M12 3l8 4.5l0 9l-8 4.5l-8 -4.5l0 -9l8 -4.5" />
                  <path d="M12 12l8 -4.5" />
                  <path d="M12 12l0 9" />
                  <path d="M12 12l-8 -4.5" />
                  <path d="M16 5.25l-8 4.5" />
                </svg>
              </span>
              <span class="nav-link-title">Data Master</span>
            </a>
            <div class="dropdown-menu">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item" href="/pegawai">Data Pegawai</a>
                  <a class="dropdown-item" href="/departemen">Data Departemen</a>
                </div>
              </div>
            </div>
          </li>

        @endif

        {{-- ============================================================ --}}
        {{-- PETUGAS ONLY — Operasional & Verifikasi --}}
        {{-- ============================================================ --}}
        @if(Auth::guard('user')->user()->role == 'petugas')

          <li class="nav-item">
            <span class="nav-link-title ms-3 small text-muted text-uppercase"
              style="font-size:0.65rem; letter-spacing:0.08em;">Operasional</span>
          </li>

          {{-- Monitoring Presensi --}}
          <li class="nav-item">
            <a class="nav-link" href="/presensi/monitoring">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="icon">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M3 5a1 1 0 0 1 1 -1h16a1 1 0 0 1 1 1v10a1 1 0 0 1 -1 1h-16a1 1 0 0 1 -1 -1l0 -10" />
                  <path d="M7 20h10" />
                  <path d="M9 16v4" />
                  <path d="M15 16v4" />
                  <path d="M7 10h2l2 3l2 -6l1 3h3" />
                </svg>
              </span>
              <span class="nav-link-title">Monitoring Presensi</span>
            </a>
          </li>

          {{-- Atur Jadwal --}}
          <li class="nav-item">
            <a class="nav-link" href="/petugas/jadwal">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M4 7a2 2 0 0 1 2 -2h12a2 2 0 0 1 2 2v12a2 2 0 0 1 -2 2h-12a2 2 0 0 1 -2 -2v-12" />
                  <path d="M16 3v4" />
                  <path d="M8 3v4" />
                  <path d="M4 11h16" />
                  <path d="M8 15h2" />
                  <path d="M14 15h2" />
                  <path d="M8 18h2" />
                  <path d="M14 18h2" />
                </svg>
              </span>
              <span class="nav-link-title">Atur Jadwal</span>
            </a>
          </li>

          <li class="nav-item">
            <span class="nav-link-title ms-3 small text-muted text-uppercase"
              style="font-size:0.65rem; letter-spacing:0.08em;">Verifikasi</span>
          </li>

          {{-- Verifikasi Cuti --}}
          <li class="nav-item">
            <a class="nav-link" href="/petugas/verifikasi-cuti">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                  <rect x="9" y="3" width="6" height="4" rx="2" />
                  <path d="M9 12l2 2l4 -4" />
                </svg>
              </span>
              <span class="nav-link-title">Verifikasi Cuti</span>
            </a>
          </li>

          {{-- Validasi Presensi --}}
          <li class="nav-item">
            <a class="nav-link" href="/petugas/validasi-presensi">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 12l5 5l10 -10" />
                </svg>
              </span>
              <span class="nav-link-title">Validasi Presensi</span>
            </a>
          </li>

        @endif

        {{-- ============================================================ --}}
        {{-- PETUGAS & LURAH — Laporan Akhir --}}
        {{-- ============================================================ --}}
        @if(in_array(Auth::guard('user')->user()->role, ['petugas', 'lurah']))

          <li class="nav-item">
            <span class="nav-link-title ms-3 small text-muted text-uppercase"
              style="font-size:0.65rem; letter-spacing:0.08em;">Laporan</span>
          </li>

          <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle" href="#navbar-laporan" data-bs-toggle="dropdown"
              data-bs-auto-close="false" role="button" aria-expanded="false">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                  stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2" />
                  <rect x="9" y="3" width="6" height="4" rx="2" />
                  <path d="M9 14h6" />
                  <path d="M9 17h6" />
                  <path d="M12 11h3" />
                </svg>
              </span>
              <span class="nav-link-title">Laporan Akhir</span>
            </a>
            <div class="dropdown-menu">
              <div class="dropdown-menu-columns">
                <div class="dropdown-menu-column">
                  <a class="dropdown-item" href="#">Laporan Presensi</a>
                  <a class="dropdown-item" href="#">Laporan Kinerja</a>
                  <a class="dropdown-item" href="#">Laporan Cuti</a>
                </div>
              </div>
            </div>
          </li>

        @endif

      </ul>
    </div>
  </div>
</aside>