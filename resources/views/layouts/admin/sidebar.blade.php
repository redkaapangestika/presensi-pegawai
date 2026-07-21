<style>
  #main-sidebar {
    background-color: #176bb8 !important;
  }

  /* Default Text and Icon Colors */
  #main-sidebar .nav-item:not(.active) .nav-link,
  #main-sidebar .nav-item:not(.active) .nav-link-title,
  #main-sidebar .nav-item:not(.active) .nav-link-icon svg,
  #main-sidebar .nav-item:not(.active) .nav-link-icon {
    color: #ffffff !important;
  }

  /* Active Link Styles */
  #main-sidebar .nav-item.active>.nav-link {
    background-color: #ffffff !important;
    border-radius: 8px !important;
    margin: 4px 12px !important;
    /* padding: 10px 16px !important; Uncomment if you want to push it more */
  }

  #main-sidebar .nav-item.active>.nav-link .nav-link-title,
  #main-sidebar .nav-item.active>.nav-link .nav-link-icon svg,
  #main-sidebar .nav-item.active>.nav-link .nav-link-icon {
    color: #176bb8 !important;
    font-weight: 600;
  }

  #main-sidebar .text-muted {
    color: #e2e8f0 !important;
    /* Lighter color for sub-headers */
  }
</style>
<aside class="navbar navbar-vertical navbar-expand-lg navbar-dark" id="main-sidebar">
  <div class="container-fluid">
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#sidebar-menu"
      aria-controls="sidebar-menu" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <h1 class="navbar-brand navbar-brand-autodark"
      style="margin: 16px; padding: 12px; background: white; border-radius: 12px; box-shadow: 0 4px 12px rgba(0,0,0,0.15);">
      <a href="/panel/dashboardadmin" style="display: flex; justify-content: center; width: 100%;">
        <img src="{{ asset('assets/img/logo.png') }}" alt="SIPERKAT Condongcatur"
          style="height: 44px; width: auto; object-fit: contain;">
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
          @php
            $userFotoSide = Auth::guard('user')->user()->foto;
            $avatarUrlSide = $userFotoSide ? Storage::url('uploads/admin/' . $userFotoSide) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::guard('user')->user()->name) . '&background=random';
          @endphp
          <span class="avatar avatar-sm" style="background-image: url('{{ $avatarUrlSide }}')"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::guard('user')->user()->name }}</div>
            <div class="mt-1 small text-muted text-uppercase">{{ Auth::guard('user')->user()->role }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="/panel/settings" class="dropdown-item">Settings</a>
          <div class="dropdown-divider"></div>
          <form action="/proseslogout" method="POST" style="margin:0; padding:0;">
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
        <li class="nav-item {{ request()->is('panel/dashboardadmin') ? 'active' : '' }}">
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

          <li
            class="nav-item dropdown {{ request()->is('pegawai*') || request()->is('departemen*') || request()->is('users*') ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-data-master" data-bs-toggle="dropdown"
              data-bs-auto-close="false" role="button"
              aria-expanded="{{ request()->is('pegawai*') || request()->is('departemen*') || request()->is('users*') ? 'true' : 'false' }}">
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
                  <a class="dropdown-item" href="/users">Data Pengelola (Users)</a>
                </div>
              </div>
            </div>
          </li>

        @endif

        {{-- ============================================================ --}}
        {{-- PETUGAS ONLY — Operasional & Verifikasi --}}
        {{-- ============================================================ --}}
        @if(Auth::guard('user')->user()->role == 'petugas')

          {{-- Monitoring Presensi --}}
          <li class="nav-item {{ request()->is('presensi/monitoring*') ? 'active' : '' }}">
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
          <li class="nav-item {{ request()->is('petugas/jadwal*') ? 'active' : '' }}">
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

          {{-- Verifikasi Cuti --}}
          <li class="nav-item {{ request()->is('petugas/verifikasi-cuti*') ? 'active' : '' }}">
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
          <li class="nav-item {{ request()->is('petugas/validasi-presensi*') ? 'active' : '' }}">
            <a class="nav-link" href="/petugas/validasi-presensi">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-check" width="24" height="24"
                  viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                  stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path d="M5 12l5 5l10 -10" />
                </svg>
              </span>
              <span class="nav-link-title">Validasi Presensi</span>
            </a>
          </li>

          {{-- Log Kerja Harian --}}
          <li class="nav-item {{ request()->is('petugas/log-kerja*') ? 'active' : '' }}">
            <a class="nav-link" href="/petugas/log-kerja">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" class="icon icon-tabler icon-tabler-clipboard-check" width="24"
                  height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                  stroke-linecap="round" stroke-linejoin="round">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                  <path d="M9 5h-2a2 2 0 0 0 -2 2v12a2 2 0 0 0 2 2h10a2 2 0 0 0 2 -2v-12a2 2 0 0 0 -2 -2h-2"></path>
                  <path d="M9 3m0 2a2 2 0 0 1 2 -2h2a2 2 0 0 1 2 2v0a2 2 0 0 1 -2 2h-2a2 2 0 0 1 -2 -2z"></path>
                  <path d="M9 14l2 2l4 -4"></path>
                </svg>
              </span>
              <span class="nav-link-title">Log Kerja Harian</span>
            </a>
          </li>

        @endif

        {{-- ============================================================ --}}
        {{-- ADMIN & PETUGAS — Pengaturan Sistem --}}
        {{-- ============================================================ --}}
        @if(in_array(Auth::guard('user')->user()->role, ['petugas']))
          <li class="nav-item {{ request()->is('panel/settings*') ? 'active' : '' }}">
            <a class="nav-link" href="/panel/settings">
              <span class="nav-link-icon d-md-none d-lg-inline-block">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none"
                  stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"
                  class="icon icon-tabler icons-tabler-outline icon-tabler-settings">
                  <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                  <path
                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z" />
                  <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0" />
                </svg>
              </span>
              <span class="nav-link-title">Pengaturan Sistem</span>
            </a>
          </li>
        @endif

        {{-- ============================================================ --}}
        {{-- ============================================================ --}}
        {{-- PETUGAS, LURAH & ADMIN — Laporan Akhir --}}
        {{-- ============================================================ --}}
        @if(in_array(Auth::guard('user')->user()->role, ['petugas', 'lurah', 'admin']))

          <li class="nav-item dropdown {{ request()->is('panel/laporan*') ? 'active' : '' }}">
            <a class="nav-link dropdown-toggle" href="#navbar-laporan" data-bs-toggle="dropdown"
              data-bs-auto-close="false" role="button"
              aria-expanded="{{ request()->is('panel/laporan*') ? 'true' : 'false' }}">
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
                  <a class="dropdown-item" href="/panel/laporan/presensi">Laporan Presensi</a>
                  <a class="dropdown-item" href="/panel/laporan/kinerja">Laporan Kinerja</a>
                  <a class="dropdown-item" href="/panel/laporan/cuti">Laporan Cuti</a>
                  <a class="dropdown-item" href="/panel/laporan/pegawai">Laporan Pegawai</a>
                </div>
              </div>
            </div>
          </li>

        @endif

      </ul>
    </div>
  </div>
</aside>