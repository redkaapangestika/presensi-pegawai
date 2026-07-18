<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <title>Cetak Laporan Cuti Global</title>
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
        <h3>REKAPITULASI PENGGUNAAN CUTI/IZIN PEGAWAI</h3>
        <p>Bulan: {{ $namabulan[$bulan] }} Tahun: {{ $tahun }}</p>
    </div>

    <div style="margin-bottom: 10px;">
        @if($pegawai)
            <strong>ID Pegawai:</strong> {{ $pegawai->id_pegawai }}<br>
            <strong>Nama Lengkap:</strong> {{ $pegawai->nama_lengkap }}<br>
            <strong>Jabatan:</strong> {{ $pegawai->jabatan }}
        @else
            <strong>Pegawai:</strong> Semua Pegawai (Rekapitulasi Global)
        @endif
    </div>

    <table>
        <thead>
            <tr>
                <th width="30">No</th>
                @if(!$pegawai)
                <th width="150">Nama Pegawai</th> @endif
                <th>Tanggal/Periode Cuti</th>
                <th>Tipe</th>
                <th>Keterangan</th>
                <th>Status Validasi</th>
            </tr>
        </thead>
        <tbody>
            @if($cuti->isEmpty())
                <tr>
                    <td colspan="{{ $pegawai ? '5' : '6' }}" class="text-center">Tidak ada aktivitas izin / cuti di bulan
                        ini.</td>
                </tr>
            @else
                @foreach($cuti as $key => $d)
                    <tr>
                        <td class="text-center">{{ $key + 1 }}</td>
                        @if(!$pegawai)
                        <td><b>{{ $d->nama_lengkap }}</b><br><small>{{ $d->id_pegawai }}</small></td> @endif
                        <td>{{ date("d-m-Y", strtotime($d->tgl_izin)) }}</td>
                        <td>{{ $d->status == 'i' ? 'Izin' : 'Cuti' }}</td>
                        <td>{{ $d->keterangan }}</td>
                        <td>
                            {{ $d->status_approved == 1 ? 'Disetujui' : ($d->status_approved == 2 ? 'Ditolak' : 'Menunggu') }}
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