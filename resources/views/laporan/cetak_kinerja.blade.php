<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Kinerja</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 14px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h3 {
            margin: 0;
            padding: 0;
        }

        .header p {
            margin: 5px 0 0 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .mt-4 {
            margin-top: 2rem;
        }

        .signature {
            width: 300px;
            float: right;
            text-align: center;
            margin-top: 30px;
        }
    </style>
</head>

<body onload="window.print()">
    <div class="header">
        <h3>REKAPITULASI LOG KINERJA PEGAWAI</h3>
        <p>Bulan: {{ $namabulan[$bulan] }} Tahun: {{ $tahun }}</p>
    </div>

    <div style="margin-bottom: 10px;">
        @if($pegawai)
            <strong>ID / NIK Pegawai:</strong> {{ $pegawai->id_pegawai }}<br>
            <strong>Nama Lengkap:</strong> {{ $pegawai->nama_lengkap }}<br>
            <strong>Jabatan:</strong> {{ $pegawai->jabatan }}<br>
            <strong>Status Penempatan:</strong>
            {{ $pegawai->is_dinas_luar ? 'Dinas Luar (' . $pegawai->lokasi_dinas . ')' : 'Kantor (Reguler)' }}
        @else
            <strong>Pegawai:</strong> Semua Pegawai (Log Kinerja Global)
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                @if(!$pegawai)
                <th width="150">Nama Pegawai</th> @endif
                <th width="100">Tanggal</th>
                <th width="100">Jam Pulang</th>
                <th>Log Kerja / Aktivitas Harian</th>
                <th width="150">Lampiran Bukti</th>
            </tr>
        </thead>
        <tbody>
            @if($kinerja->isEmpty())
                <tr>
                    <td colspan="{{ $pegawai ? '5' : '6' }}" class="text-center">Tidak ada log kinerja pada bulan ini.</td>
                </tr>
            @else
                @foreach($kinerja as $key => $d)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        @if(!$pegawai)
                        <td>{{ $d->nama_lengkap }}</td> @endif
                        <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_out ?? '-' }}</td>
                        <td>{!! nl2br(e($d->log_kerja)) !!}</td>
                        <td class="text-center">
                            @if($d->berkas_log)
                                @php
                                    $path = Storage::url('uploads/log_kerja/' . $d->berkas_log);
                                @endphp
                                @if(preg_match('/\.(jpg|jpeg|png)$/i', $d->berkas_log))
                                    <img src="{{ url($path) }}" alt="Bukti Kerja"
                                        style="max-width: 100px; max-height: 100px; border-radius: 4px;">
                                @else
                                    <a href="{{ url($path) }}" target="_blank">Lihat Dokumen</a>
                                @endif
                            @else
                                <span style="color: #999; font-style: italic;">Tidak ada lampiran</span>
                            @endif
                        </td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>

    <div class="signature">
        <p>Sleman, {{ date('d F Y') }}</p>
        <p style="margin-bottom: 70px;">Mengetahui,</p>
        <p><strong>Drs. Reno Candra S.</strong><br>Lurah Condongcatur</p>
    </div>
</body>

</html>