<header class="navbar navbar-expand-md navbar-light d-none d-lg-flex d-print-none">
  <div class="container-xl">
    <div class="navbar-nav flex-row order-md-last ms-auto">
      <div class="d-none d-md-flex">
        <a href="?theme=dark" class="nav-link px-0 hide-theme-dark" title="Enable dark mode" data-bs-toggle="tooltip"
          data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/moon -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 3c.132 0 .263 0 .393 0a7.5 7.5 0 0 0 7.92 12.446a9 9 0 1 1 -8.313 -12.454z" />
          </svg>
        </a>
        <a href="?theme=light" class="nav-link px-0 hide-theme-light" title="Enable light mode" data-bs-toggle="tooltip"
          data-bs-placement="bottom">
          <!-- Download SVG icon from http://tabler-icons.io/i/sun -->
          <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
            stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
            <path d="M12 12m-4 0a4 4 0 1 0 8 0a4 4 0 1 0 -8 0" />
            <path d="M3 12h1m8 -9v1m8 8h1m-9 8v1m-6.4 -15.4l.7 .7m12.1 -.7l-.7 .7m0 11.4l.7 .7m-12.1 -.7l-.7 .7" />
          </svg>
        </a>
        @if(Auth::guard('user')->user()->role == 'petugas')
          <div class="nav-item dropdown d-none d-md-flex me-3">
            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
              <!-- Download SVG icon from http://tabler-icons.io/i/bell -->
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
              </svg>
              @php
                $pengajuan_pending = \Illuminate\Support\Facades\DB::table('pengajuan_izin')->where('status_approved', 0)->count();
                $today = date('Y-m-d');
                $presensi_pending = \Illuminate\Support\Facades\DB::table('presensis')->where('tgl_presensi', $today)->whereNull('status_validasi')->count();
                $total_pending = $pengajuan_pending + $presensi_pending;
              @endphp
              @if($total_pending > 0)
                <span class="badge bg-red">{{ $total_pending }}</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card">
              <div class="card">
                <div class="card-header">
                  <h3 class="card-title">Notifikasi Sistem</h3>
                </div>
                <div class="list-group list-group-flush list-group-hoverable">
                  <div class="list-group-item">
                    <div class="row align-items-center">
                      <div class="col-auto">
                        @if($total_pending > 0)
                          <span class="status-dot status-dot-animated bg-red d-block"></span>
                        @else
                          <span class="status-dot bg-green d-block"></span>
                        @endif
                      </div>
                      <div class="col text-truncate">
                        @if($pengajuan_pending > 0)
                          <a href="/petugas/verifikasi-cuti" class="text-body d-block mt-1"><b>Verifikasi Cuti &
                              Izin</b></a>
                          <div class="d-block text-muted text-truncate mt-n1 mb-2">
                            Ada {{ $pengajuan_pending }} pengajuan yang menunggu verifikasi.
                          </div>
                        @endif

                        @if($presensi_pending > 0)
                          <a href="/petugas/validasi-presensi" class="text-body d-block mt-1"><b>Validasi Presensi
                              Harian</b></a>
                          <div class="d-block text-muted text-truncate mt-n1 mb-2">
                            Ada {{ $presensi_pending }} kehadiran hari ini yang belum Anda setujui.
                          </div>
                        @endif

                        @if($total_pending == 0)
                          <div class="d-block text-muted text-truncate mt-n1">
                            Tidak ada notifikasi sistem yang tertunda.
                          </div>
                        @endif
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        @endif
      </div>
      <div class="nav-item dropdown">
        <a href="#" class="nav-link d-flex lh-1 text-reset p-0" data-bs-toggle="dropdown" aria-label="Open user menu">
          @php
            $userFoto = Auth::guard('user')->user()->foto;
            $avatarUrl = $userFoto ? asset('storage/uploads/admin/' . $userFoto) : 'https://ui-avatars.com/api/?name=' . urlencode(Auth::guard('user')->user()->name) . '&background=random';
          @endphp
          <span class="avatar avatar-sm" style="background-image: url('{{ $avatarUrl }}')"></span>
          <div class="d-none d-xl-block ps-2">
            <div>{{ Auth::guard('user')->user()->name }}</div>
            <div class="mt-1 small text-muted text-uppercase">{{ Auth::guard('user')->user()->role }}</div>
          </div>
        </a>
        <div class="dropdown-menu dropdown-menu-end dropdown-menu-arrow">
          <a href="/panel/profile" class="dropdown-item">Settings</a>
          <div class="dropdown-divider"></div>
          <form action="/proseslogoutadmin" method="POST" style="margin:0;padding:0;">
            @csrf
            <button type="submit" class="dropdown-item"
              style="background:none;border:none;width:100%;text-align:left;cursor:pointer;">
              Logout
            </button>
          </form>
        </div>
      </div>
    </div>
  </div>
</header>