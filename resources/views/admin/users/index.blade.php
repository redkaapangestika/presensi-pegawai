@extends('layouts.admin.tabler')

@section('content')
    <div class="page-header d-print-none">
        <div class="container-xl">
            <div class="row g-2 align-items-center">
                <div class="col">
                    <h2 class="page-title">
                        Manajemen Pengelola (User)
                    </h2>
                    <div class="text-muted mt-1">Mengelola hak akses dan pengguna di balik layar aplikasi ini</div>
                </div>
            </div>
        </div>
    </div>
    <div class="page-body">
        <div class="container-xl">
            <div class="row">
                <div class="col-12">
                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <h3 class="mb-1">Berhasil</h3>
                            <p>{{ Session::get('success') }}</p>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif

                    @if (Session::get('warning'))
                        <div class="alert alert-warning alert-dismissible" role="alert">
                            <h3 class="mb-1">Peringatan</h3>
                            <p>{{ Session::get('warning') }}</p>
                            <a class="btn-close" data-bs-dismiss="alert" aria-label="close"></a>
                        </div>
                    @endif
                    <div class="card">
                        <div class="card-header border-0 d-flex justify-content-between align-items-center">
                            <h3 class="card-title">Daftar Pengelola Sistem</h3>
                            <a href="#" class="btn btn-primary d-sm-inline-block" data-bs-toggle="modal"
                                data-bs-target="#modal-tambah-user">
                                <svg xmlns="http://www.w3.org/2000/svg" class="icon" width="24" height="24"
                                    viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                    <path d="M12 5l0 14" />
                                    <path d="M5 12l14 0" />
                                </svg>
                                Tambah Pengelola
                            </a>
                        </div>
                        <div class="table-responsive">
                            <table class="table card-table table-vcenter text-nowrap datatable">
                                <thead>
                                    <tr>
                                        <th>No</th>
                                        <th>Nama</th>
                                        <th>Email</th>
                                        <th>Role / Hak Akses</th>
                                        <th class="w-1">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($users as $u)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $u->name }}</td>
                                            <td class="text-muted">{{ $u->email }}</td>
                                            <td>
                                                @if($u->role == 'admin')
                                                    <span class="badge bg-red text-red-fg">Admin Utama</span>
                                                @elseif($u->role == 'petugas')
                                                    <span class="badge bg-blue text-blue-fg">Petugas Lapangan</span>
                                                @elseif($u->role == 'lurah')
                                                    <span class="badge bg-green text-green-fg">Lurah Konseptor</span>
                                                @else
                                                    <span class="badge bg-secondary text-secondary-fg">{{ $u->role }}</span>
                                                @endif
                                            </td>
                                            <td>
                                                <div class="btn-group">
                                                    <a href="#" class="btn btn-sm btn-icon btn-primary btn-edit"
                                                        data-id="{{ $u->id }}">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="icon icon-tabler icon-tabler-pencil" width="24" height="24"
                                                            viewBox="0 0 24 24" stroke-width="2" stroke="currentColor"
                                                            fill="none" stroke-linecap="round" stroke-linejoin="round">
                                                            <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                            <path d="M4 20h4l10.5 -10.5a1.5 1.5 0 0 0 -4 -4l-10.5 10.5v4" />
                                                            <path d="M13.5 6.5l4 4" />
                                                        </svg>
                                                    </a>
                                                    <form action="/users/{{ $u->id }}/delete" method="POST"
                                                        class="d-inline form-delete">
                                                        @csrf
                                                        <button type="submit" class="btn btn-sm btn-icon btn-danger btn-delete">
                                                            <svg xmlns="http://www.w3.org/2000/svg"
                                                                class="icon icon-tabler icon-tabler-trash" width="24"
                                                                height="24" viewBox="0 0 24 24" stroke-width="2"
                                                                stroke="currentColor" fill="none" stroke-linecap="round"
                                                                stroke-linejoin="round">
                                                                <path stroke="none" d="M0 0h24v24H0z" fill="none" />
                                                                <path d="M4 7l16 0" />
                                                                <path d="M10 11l0 6" />
                                                                <path d="M14 11l0 6" />
                                                                <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                                                <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                                            </svg>
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah User -->
    <div class="modal modal-blur fade" id="modal-tambah-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Pengelola Sistem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="/users/store" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label class="form-label">Nama Lengkap</label>
                            <input type="text" class="form-control" name="name" required placeholder="Contoh: Budi Santoso">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Alamat Email</label>
                            <input type="email" class="form-control" name="email" required placeholder="budi@example.com">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Hak Akses Role</label>
                            <select class="form-select" name="role" required>
                                <option value="">-- Pilih Role --</option>
                                <option value="admin">Admin Utama</option>
                                <option value="petugas">Petugas Lapangan / Admin Operasional</option>
                                <option value="lurah">Lurah Konseptor / Pemantau</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Kata Sandi (Minimum 6 karakter)</label>
                            <input type="password" class="form-control" name="password" required>
                        </div>
                        <div class="modal-footer px-0 pb-0">
                            <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan Data</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit User -->
    <div class="modal modal-blur fade" id="modal-edit-user" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Edit Pengelola Sistem</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body" id="load-edit-form">
                    <!-- FORM -->
                </div>
            </div>
        </div>
    </div>
@endsection

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        $(document).ready(function () {
            $(".btn-edit").click(function (e) {
                e.preventDefault();
                var id = $(this).attr('data-id');
                $.ajax({
                    type: 'POST',
                    url: '/users/edit',
                    cache: false,
                    data: {
                        _token: '{{ csrf_token() }}',
                        id: id
                    },
                    success: function (respond) {
                        $('#load-edit-form').html(respond);
                        $('#modal-edit-user').modal('show');
                    }
                });
            });

            $(".btn-delete").click(function (e) {
                e.preventDefault();
                let form = $(this).closest('form');
                Swal.fire({
                    title: 'Apakah Anda yakin?',
                    text: "Data pengelola ini akan dihapus secara permanen!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, Hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush