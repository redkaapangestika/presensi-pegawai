<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Carbon\Carbon;

class CleanupOldPresensiPhotos extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'presensi:cleanup-photos {--days=365}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Pembersihan otomatis file fisik foto usang dari storage untuk menghemat ruang server tanpa menghapus data presensinya.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $days = $this->option('days');
        $dateLimit = Carbon::now()->subDays($days)->format('Y-m-d');

        $oldRecords = DB::table('presensis')->where('tgl_presensi', '<', $dateLimit)->get();
        $disk = env('FILESYSTEM_DISK', 'public');
        $count = 0;

        foreach ($oldRecords as $record) {
            if ($record->foto_in && Storage::disk($disk)->exists('uploads/absensi/' . $record->foto_in)) {
                Storage::disk($disk)->delete('uploads/absensi/' . $record->foto_in);
            }
            if ($record->foto_out && Storage::disk($disk)->exists('uploads/absensi/' . $record->foto_out)) {
                Storage::disk($disk)->delete('uploads/absensi/' . $record->foto_out);
            }

            DB::table('presensis')->where('id_presensi', $record->id_presensi)->update([
                'foto_in' => null,
                'foto_out' => null
            ]);
            $count++;
        }

        $this->info("🧹 BERHASIL! Dihapus " . $count . " data lampiran presensi (umur > " . $days . " hari). Server menjadi lebih lega.");
    }
}
