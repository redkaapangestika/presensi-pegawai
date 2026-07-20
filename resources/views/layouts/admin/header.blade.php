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
        @if(Auth::guard('user')->user()->role == 'petugas' || Auth::guard('user')->user()->role == 'admin')
          <div class="nav-item dropdown d-none d-md-flex me-3">
            <a href="#" class="nav-link px-0" data-bs-toggle="dropdown" tabindex="-1" aria-label="Show notifications">
              <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24" viewBox="0 0 24 24"
                stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                <path d="M10 5a2 2 0 0 1 4 0a7 7 0 0 1 4 6v3a4 4 0 0 0 2 3h-16a4 4 0 0 0 2 -3v-3a7 7 0 0 1 4 -6" />
                <path d="M9 17v1a3 3 0 0 0 6 0v-1" />
              </svg>
              @php
                $notifications = Auth::guard('user')->user()->unreadNotifications()->latest()->take(5)->get();
                $total_pending = Auth::guard('user')->user()->unreadNotifications()->count();
              @endphp
              @if($total_pending > 0)
                <span class="badge bg-red">{{ $total_pending }}</span>
              @endif
            </a>
            <div class="dropdown-menu dropdown-menu-arrow dropdown-menu-end dropdown-menu-card"
              style="width: 320px; max-height: 480px; overflow-y: auto;">
              <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                  <h3 class="card-title">Notifikasi Sistem</h3>
                  @if($total_pending > 0)
                    <a href="/panel/notifications/read" class="text-muted small">Tandai sudah dibaca</a>
                  @endif
                </div>
                <div class="list-group list-group-flush list-group-hoverable">
                  @forelse($notifications as $notif)
                    <a href="{{ $notif->data['url'] ?? '#' }}" class="list-group-item list-group-item-action">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          @if(isset($notif->data['tipe']) && $notif->data['tipe'] == 'masuk')
                            <span class="status-dot status-dot-animated bg-green d-block"></span>
                          @elseif(isset($notif->data['tipe']) && $notif->data['tipe'] == 'pulang')
                            <span class="status-dot bg-blue d-block"></span>
                          @elseif(isset($notif->data['tipe']) && $notif->data['tipe'] == 'izin')
                            <span class="status-dot status-dot-animated bg-orange d-block"></span>
                          @else
                            <span class="status-dot bg-azure d-block"></span>
                          @endif
                        </div>
                        <div class="col text-truncate">
                          <div class="d-block mt-1"><b>{{ $notif->data['title'] ?? 'Pemberitahuan' }}</b></div>
                          <div class="d-block text-muted text-truncate mt-n1 mb-2">
                            {{ $notif->data['message'] ?? '' }}
                          </div>
                          <div class="text-muted small mt-1">{{ $notif->created_at->diffForHumans() }}</div>
                        </div>
                      </div>
                    </a>
                  @empty
                    <div class="list-group-item">
                      <div class="row align-items-center">
                        <div class="col-auto">
                          <span class="status-dot bg-green d-block"></span>
                        </div>
                        <div class="col text-truncate">
                          <div class="d-block text-muted mt-n1">
                            Tidak ada notifikasi aktivitas pegawai.
                          </div>
                        </div>
                      </div>
                    </div>
                  @endforelse
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