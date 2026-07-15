<style>
    .histori-card {
        background: white;
        border-radius: 15px;
        padding: 15px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        margin-bottom: 12px;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.03);
    }

    .histori-date {
        font-weight: 700;
        color: #1f2937;
        font-size: 0.9rem;
        width: 60px;
    }

    .histori-time {
        color: #4b5563;
        font-size: 0.85rem;
        font-weight: 600;
        text-align: center;
        flex: 1;
    }

    .histori-badge {
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 600;
        min-width: 65px;
        text-align: center;
    }

    .badge-on-time {
        background: #d1fae5;
        color: #059669;
    }

    .badge-late {
        background: #fee2e2;
        color: #dc2626;
    }

    .badge-v-valid {
        background: #dbeafe;
        color: #1d4ed8;
    }

    .badge-v-invalid {
        background: #fef2f2;
        color: #b91c1c;
    }

    .badge-v-pending {
        background: #fef3c7;
        color: #d97706;
    }
</style>

@if ($histori->isEmpty())
    <div class="alert alert-warning text-center" style="border-radius:15px;">
        <p class="mb-0">Tidak ada riwayat presensi bulan ini.</p>
    </div>
@else
    @foreach ($histori as $d)
        @php
            $is_late = $d->jam_in > '08:00:00';
        @endphp
        <div class="histori-card">
            <!-- Date -->
            <div class="histori-date">
                {{ date("d M", strtotime($d->tgl_presensi)) }}
            </div>

            <!-- Time In & Out -->
            <div class="histori-time">
                {{ substr($d->jam_in, 0, 5) }}
                <span style="color:#9ca3af; margin:0 5px;">-</span>
                {{ $d->jam_out !== null ? substr($d->jam_out, 0, 5) : '--:--' }}
            </div>

            <!-- Status Badges -->
            <div style="display: flex; flex-direction: column; gap: 4px; align-items: flex-end;">
                <!-- Late / On time -->
                @if($is_late)
                    <div class="histori-badge badge-late">Terlambat</div>
                @else
                    <div class="histori-badge badge-on-time">Tepat Waktu</div>
                @endif

                <!-- Status Validasi -->
                @if($d->status_validasi == 'valid')
                    <div class="histori-badge badge-v-valid">Valid</div>
                @elseif($d->status_validasi == 'invalid')
                    <div class="histori-badge badge-v-invalid">Tidak Valid</div>
                @else
                    <div class="histori-badge badge-v-pending">Menunggu</div>
                @endif
            </div>
        </div>
    @endforeach
@endif