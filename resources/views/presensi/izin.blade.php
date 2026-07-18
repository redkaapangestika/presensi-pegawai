@extends('layouts.presensi')
@section('header')
    <style>
        .appHeader.bg-primary {
            background: #0284c7 !important;
            border: none;
            box-shadow: none;
        }

        .page-container {
            padding: 80px 20px 20px 20px;
            background: #f9fafb;
            min-height: 100vh;
        }

        .izin-card {
            background: white;
            border-radius: 15px;
            padding: 15px 20px;
            margin-bottom: 15px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02);
            display: flex;
            flex-direction: column;
        }

        .izin-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 8px;
        }

        .izin-date {
            font-weight: 700;
            color: #1f2937;
            font-size: 0.95rem;
        }

        .izin-status-badge {
            padding: 4px 10px;
            border-radius: 12px;
            font-size: 0.7rem;
            font-weight: 700;
            text-transform: uppercase;
        }

        .status-pending {
            background: #fef3c7;
            color: #d97706;
        }

        .status-approved {
            background: #d1fae5;
            color: #059669;
        }

        .status-decline {
            background: #fee2e2;
            color: #b91c1c;
        }

        .izin-body {
            display: flex;
            align-items: center;
        }

        .izin-type {
            background: #f3f4f6;
            color: #4b5563;
            padding: 4px 10px;
            border-radius: 8px;
            font-size: 0.75rem;
            font-weight: 600;
            margin-right: 15px;
        }

        .izin-ket {
            color: #6b7280;
            font-size: 0.85rem;
        }

        .fab-btn-custom {
            position: fixed;
            bottom: 80px;
            right: 20px;
            width: 60px;
            height: 60px;
            background: #38bdf8;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 30px;
            box-shadow: 0 4px 10px rgba(56, 189, 248, 0.4);
            z-index: 999;
        }
    </style>
    <!-- App Header -->
    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/dashboard" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Data Cuti / Izin</div>
        <div class="right"></div>
    </div>
    <!-- * App Header -->
@endsection
@section('content')
    <div class="page-container">
        @if(Session::get('success'))
            <div class="alert alert-success" style="border-radius:12px;">
                {{ Session::get('success') }}
            </div>
        @endif
        @if(Session::get('error'))
            <div class="alert alert-danger" style="border-radius:12px;">
                {{ Session::get('error') }}
            </div>
        @endif

        <!-- Sisa Cuti Card -->
        <div
            style="background: white; border-radius: 15px; padding: 15px 20px; box-shadow: 0 4px 6px rgba(0, 0, 0, 0.02); margin-bottom: 20px; display: flex; justify-content: space-between; align-items: center; border: 1px solid #e5e7eb;">
            <div>
                <div style="font-size: 0.85rem; color: #6b7280; font-weight: 600;">Sisa Kuota Cuti Tahunan</div>
                <div style="font-size: 1.3rem; font-weight: 800; color: #0ea5e9;">{{ $sisa_cuti }} <span
                        style="font-size: 0.9rem; color:#6b7280; font-weight: 600;">Hari</span></div>
            </div>
            <div
                style="background: #e0f2fe; color: #0ea5e9; padding: 12px; border-radius: 12px; display: flex; align-items: center; justify-content: center;">
                <ion-icon name="calendar-clear" style="font-size: 26px;"></ion-icon>
            </div>
        </div>

        @if ($dataizin->isEmpty())
            <div class="alert alert-warning text-center" style="border-radius:15px; margin-top:20px;">
                <p class="mb-0">Belum ada riwayat cuti / izin.</p>
            </div>
        @else
            <div style="padding-bottom: 90px;">
                <div class="text-center mb-3">
                    <button type="button" onclick="window.open('/presensi/cetaklaporancuti', '_blank')"
                        class="btn btn-outline-primary shadow-sm" style="border-radius:12px; font-weight:700; width: 100%;">
                        <ion-icon name="print-outline"></ion-icon> Export Laporan Cuti
                    </button>
                </div>

                @foreach ($dataizin as $d)
                    <div class="izin-card">
                        <div class="izin-header">
                            <div class="izin-date">{{ date("d M Y", strtotime($d->tgl_izin)) }}</div>
                            @if($d->status_approved == "0")
                                <div class="izin-status-badge status-pending">Pending</div>
                            @elseif($d->status_approved == "1")
                                <div class="izin-status-badge status-approved">Approved</div>
                            @else
                                <div class="izin-status-badge status-decline">Declined</div>
                            @endif
                        </div>
                        <div class="izin-body">
                            <div class="izin-type">{{ $d->status == "s" ? "Sakit" : "Izin" }}</div>
                            <div class="izin-ket">{{ $d->keterangan }}</div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    <a href="/presensi/buatizin" class="fab-btn-custom">
        <ion-icon name="add"></ion-icon>
    </a>

@endsection