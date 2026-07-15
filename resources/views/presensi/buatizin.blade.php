@extends('layouts.presensi')

@section('header')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <style>
        .appHeader.bg-primary {
            background: #0ea5e9 !important;
            /* Lighter blue like screenshot */
            border: none;
            box-shadow: none;
        }

        .form-container {
            padding: 70px 20px 100px 20px;
            background: #f8fafc;
            min-height: 100vh;
        }

        .rule-card {
            background: #f0f9ff;
            border: 1px solid #e0f2fe;
            border-radius: 16px;
            padding: 16px;
            margin-bottom: 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .rule-text {
            font-size: 0.85rem;
            color: #0369a1;
            font-weight: 600;
            line-height: 1.4;
        }

        .rule-badge {
            background: #e0f2fe;
            color: #0284c7;
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .input-card {
            background: white;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.03);
            margin-bottom: 20px;
        }

        .calendar-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
        }

        .calendar-title {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
            margin-bottom: 2px;
        }

        .calendar-subtitle {
            font-size: 0.8rem;
            color: #64748b;
        }

        .calendar-info {
            color: #0284c7;
            font-size: 0.85rem;
            font-weight: 600;
        }

        /* Removed Flatpickr Overrides since it breaks core flatpickr flexbox styling */

        /* Form Inputs */
        .selected-date-card {
            background: #f8fafc;
            border-radius: 16px;
            padding: 15px;
            margin-bottom: 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .selected-date-title {
            font-size: 0.75rem;
            color: #64748b;
            margin-bottom: 4px;
        }

        .selected-date-value {
            font-size: 1.1rem;
            font-weight: 700;
            color: #1e293b;
        }

        .status-badge {
            background: #dcfce7;
            color: #16a34a;
            padding: 6px 12px;
            border-radius: 12px;
            font-size: 0.75rem;
            font-weight: 700;
        }

        .custom-label {
            font-size: 0.85rem;
            font-weight: 700;
            color: #334155;
            margin-bottom: 8px;
            display: block;
        }

        .custom-input {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            padding: 14px 16px;
            font-size: 0.95rem;
            width: 100%;
            color: #334155;
            font-weight: 500;
            transition: all 0.2s;
        }

        .custom-input:focus {
            outline: none;
            border-color: #0ea5e9;
            background: white;
            box-shadow: 0 0 0 3px rgba(14, 165, 233, 0.1);
        }

        .sisa-cuti-wrapper {
            display: flex;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 14px;
            align-items: center;
            padding-right: 8px;
        }

        .sisa-cuti-input {
            border: none;
            background: transparent;
            flex: 1;
            padding: 14px 16px;
            font-size: 0.95rem;
            color: #1e293b;
            font-weight: 700;
            pointer-events: none;
        }

        .btn-submit {
            background: #0ea5e9;
            color: white;
            border-radius: 16px;
            padding: 16px;
            font-weight: 700;
            font-size: 1.05rem;
            width: 100%;
            border: none;
            box-shadow: 0 8px 15px rgba(14, 165, 233, 0.25);
            margin-top: 10px;
            transition: all 0.2s;
        }

        .btn-submit:active {
            transform: scale(0.98);
        }
    </style>

    <div class="appHeader bg-primary text-light">
        <div class="left">
            <a href="/presensi/izin" class="headerButton">
                <ion-icon name="chevron-back-outline"></ion-icon>
            </a>
        </div>
        <div class="pageTitle">Pengajuan Cuti</div>
        <div class="right"></div>
    </div>
@endsection

@section('content')
    <div class="form-container">
        <form method="POST" action="/presensi/storeizin" id="frmIzin">
            @csrf
            <input type="hidden" id="tgl_izin" name="tgl_izin">
            <input type="hidden" id="tgl_selesai_izin" name="tgl_selesai_izin">

            <!-- Aturan Card -->
            <div class="rule-card">
                <div class="rule-text">
                    Aturan Pengajuan Cuti<br>
                    <span style="font-size:0.75rem; color:#64748b; font-weight:500;">Minimal H-3, Maksimal 3 Hari.</span>
                </div>
                <div class="rule-badge">H+3</div>
            </div>

            <!-- Calendar Card -->
            <div class="input-card">
                <div class="calendar-header">
                    <div>
                        <div class="calendar-title">Pilih Tanggal Cuti</div>
                        <div class="calendar-subtitle">Hari ini: <span id="today-text"></span></div>
                    </div>
                    <div class="calendar-info">Batas 3 Hari</div>
                </div>

                <input type="text" id="inlinePicker" class="d-none">
            </div>

            <!-- Result Card -->
            <div class="selected-date-card">
                <div>
                    <div class="selected-date-title">Tanggal dipilih</div>
                    <div class="selected-date-value" id="display-date">Belum memilih</div>
                </div>
                <div class="status-badge" id="display-badges">-</div>
            </div>

            <!-- Inputs Card -->
            <div class="input-card" style="padding-bottom:10px;">
                <div class="row mb-3">
                    <div class="col-6 pr-2">
                        <label class="custom-label">Jenis Cuti</label>
                        <select name="status" id="status" class="custom-input">
                            <option value="i">Izin</option>
                            <option value="s">Sakit</option>
                            <option value="c">Cuti Tahunan</option>
                            <option value="m">Cuti Melahirkan</option>
                            <option value="cl">Cuti Lainnya</option>
                        </select>
                    </div>
                    <div class="col-6 pl-2">
                        <label class="custom-label">Sisa Cuti</label>
                        <div class="sisa-cuti-wrapper">
                            <input type="text" class="sisa-cuti-input" value="{{ $sisa_cuti ?? 0 }} Hari" readonly>
                            <div class="status-badge" style="padding: 4px 10px;">
                                {{ ($sisa_cuti ?? 0) > 0 ? 'Tersedia' : 'Habis' }}
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group mb-2">
                    <label class="custom-label">Keterangan</label>
                    <input type="text" name="keterangan" id="keterangan" class="custom-input"
                        placeholder="Alasan pengajuan singkat..." autocomplete="off">
                </div>
            </div>

            <button type="submit" class="btn-submit">Kirim Pengajuan</button>
        </form>
    </div>
@endsection

@push('myscript')
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script>
        $(document).ready(function () {
            var today = new Date();
            var hPlus3 = new Date(today);
            hPlus3.setDate(hPlus3.getDate() + 3);

            var todayStr = flatpickr.formatDate(today, "d M Y");
            $('#today-text').text(todayStr);

            var picker = flatpickr("#inlinePicker", {
                inline: true,
                minDate: hPlus3,
                mode: "range",
                showMonths: 1,
                dateFormat: "Y-m-d",
                disable: [
                    function (date) {
                        return (date.getDay() === 0 || date.getDay() === 6);
                    },
                    @isset($disabled_dates)
                        @foreach($disabled_dates as $dd)
                            "{{ $dd }}",
                        @endforeach
                    @endisset
                                        ],
                onChange: function (selectedDates, dateStr, instance) {
                    if (selectedDates.length > 0) {
                        // Max 3 Days check
                        if (selectedDates.length === 2) {
                            var diffTime = Math.abs(selectedDates[1] - selectedDates[0]);
                            var diffDays = Math.ceil(diffTime / (1000 * 60 * 60 * 24)) + 1;
                            if (diffDays > 3) {
                                Swal.fire('Batas Melampaui', 'Cuti maksimal hanya 3 hari berturut-turut.', 'warning');
                                instance.clear();
                                $('#display-date').text("Belum memilih");
                                $('#display-badges').text("-");
                                return;
                            }
                        }

                        // Set text
                        var displayStr = flatpickr.formatDate(selectedDates[0], "d M Y");
                        if (selectedDates.length == 2 && selectedDates[0].getTime() !== selectedDates[1].getTime()) {
                            displayStr += " - " + flatpickr.formatDate(selectedDates[1], "d M Y");
                            $('#display-badges').text("Range");
                        } else {
                            $('#display-badges').text("Weekday");
                        }
                        $('#display-date').text(displayStr);

                        // Set hidden inputs
                        var startFmt = flatpickr.formatDate(selectedDates[0], "Y-m-d");
                        $('#tgl_izin').val(startFmt);
                        if (selectedDates.length == 2) {
                            var endFmt = flatpickr.formatDate(selectedDates[1], "Y-m-d");
                            $('#tgl_selesai_izin').val(endFmt);
                        } else {
                            $('#tgl_selesai_izin').val(""); // empty if single day
                        }
                    } else {
                        $('#display-date').text("Belum memilih");
                        $('#display-badges').text("-");
                        $('#tgl_izin').val("");
                        $('#tgl_selesai_izin').val("");
                    }
                }
            });

            $('#status').change(function () {
                var status = $(this).val();
                picker.clear();
                if (status == 's') { // Sakit, bisa diajukan hari H
                    picker.set('minDate', today);
                } else { // Izin, require H+3
                    picker.set('minDate', hPlus3);
                }
            });

            $('#frmIzin').submit(function (e) {
                if ($('#tgl_izin').val() == '') {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Tanggal mulai harus dipilih pada kalender',
                        icon: 'warning'
                    });
                    return false;
                }

                if ($('#keterangan').val().trim() == '') {
                    e.preventDefault();
                    Swal.fire({
                        title: 'Oops!',
                        text: 'Keterangan harus diisi',
                        icon: 'warning'
                    });
                    return false;
                }
            });
        });
    </script>
@endpush