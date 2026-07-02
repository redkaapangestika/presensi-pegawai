@if ($histori->isEmpty())
    <div class="alert alert-warning">
        <p>Data tidak ditemukan</p>
    </div>
@endif
@foreach ($histori as $d)
<ul class="listview image-listview">
    <li>
        <div class="item">
            @php
                $path = Storage::url('uploads/absensi/'.$d->foto_in);
            @endphp
            <img src="{{ url($path) }}" alt="image" class="image">
            <div class="in">
                <div>
                    <b>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</b><br>
                    {{-- <small class="text-muted">{{ $d->jabatan }}</small> --}}
                </div>
                <span class="badge {{ $d->jam_in <= '08:00:00' ? 'badge-success' : 'badge-danger' }}">{{ $d->jam_in }}</span>
                <span class="badge {{ $d->jam_out >= '17:00:00' ? 'badge-success' : 'badge-danger' }}">{{ $d->jam_out }}</span>
            </div>
        </div>
    </li>
</ul>

@endforeach