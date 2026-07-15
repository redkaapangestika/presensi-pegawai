<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Presensi</title>
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
        <h3>REKAPITULASI PRESENSI PEGAWAI</h3>
        <p>Bulan: {{ $namabulan[$bulan] }} Tahun: {{ $tahun }}</p>
    </div>

    <div style="margin-bottom: 10px;">
        @if($pegawai)
            <strong>ID / NIK Pegawai:</strong> {{ $pegawai->id_pegawai }}<br>
            <strong>Nama Lengkap:</strong> {{ $pegawai->nama_lengkap }}<br>
            <strong>Jabatan:</strong> {{ $pegawai->jabatan }}
        @else
            <strong>Pegawai:</strong> Semua Pegawai (Log Presensi Global)
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                @if(!$pegawai)
                <th>Nama Pegawai</th> @endif
                <th>Tanggal</th>
                <th>Jam Masuk</th>
                <th>Jam Pulang</th>
                <th>Status Validasi</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @if($presensi->isEmpty())
                <tr>
                    <td colspan="{{ $pegawai ? '6' : '7' }}" class="text-center">Tidak ada data presensi pada bulan ini.
                    </td>
                </tr>
            @else
                @foreach($presensi as $key => $d)
                    @php
                        $is_late = $d->jam_in > '08:00:00';
                    @endphp
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        @if(!$pegawai)
                        <td>{{ $d->nama_lengkap }}</td> @endif
                        <td>{{ date("d-m-Y", strtotime($d->tgl_presensi)) }}</td>
                        <td>{{ $d->jam_in }}</td>
                        <td>{{ $d->jam_out ?? 'Belum Absen Pulang' }}</td>
                        <td>
                            {{ $d->status_validasi == 'valid' ? 'Valid' : ($d->status_validasi == 'invalid' ? 'Tidak Valid' : 'Menunggu') }}
                        </td>
                        <td>
                            {{ $is_late ? 'Terlambat' : 'Tepat Waktu' }}
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