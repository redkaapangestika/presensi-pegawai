<form action="/users/{{ $user->id }}/update" method="POST">
    @csrf
    <div class="mb-3">
        <label class="form-label">Nama Lengkap</label>
        <input type="text" class="form-control" name="name" value="{{ $user->name }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Alamat Email</label>
        <input type="email" class="form-control" name="email" value="{{ $user->email }}" required>
    </div>
    <div class="mb-3">
        <label class="form-label">Hak Akses Role</label>
        <select class="form-select" name="role" required>
            <option value="">-- Pilih Role --</option>
            <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Admin Utama</option>
            <option value="petugas" {{ $user->role == 'petugas' ? 'selected' : '' }}>Petugas Lapangan / Admin Operasional
            </option>
            <option value="lurah" {{ $user->role == 'lurah' ? 'selected' : '' }}>Lurah Konseptor / Pemantau</option>
        </select>
    </div>
    <div class="mb-3">
        <label class="form-label">Kata Sandi Baru</label>
        <input type="password" class="form-control" name="password">
        <small class="form-hint">Biarkan kosong jika tidak ingin mengubah kata sandi.</small>
    </div>
    <div class="modal-footer px-0 pb-0">
        <button type="button" class="btn me-auto" data-bs-dismiss="modal">Batal</button>
        <button type="submit" class="btn btn-primary" data-bs-dismiss="modal">Simpan Perubahan</button>
    </div>
</form>