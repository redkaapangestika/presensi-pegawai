<?php

namespace Tests\Feature;

use App\Models\User;
use App\Models\Pegawai;
use Tests\TestCase;
use Illuminate\Support\Facades\DB;

class AllEndpointsCheckTest extends TestCase
{
    /** Guest Endpoints (No Auth Required) */
    public function test_guest_endpoints()
    {
        $this->get('/')->assertStatus(200);
        $this->get('/login')->assertStatus(200);
        $this->get('/panel')->assertStatus(200);
    }

    /** Ensure Protections exist (Middleware works) */
    public function test_unauthenticated_users_are_redirected()
    {
        // Pegawai zones
        $this->get('/dashboard')->assertRedirect('/login');
        $this->get('/presensi/create')->assertRedirect('/login');

        // Admin zones
        $this->get('/panel/dashboardadmin')->assertRedirect('/login');
    }

    /** Penetration Test: Pegawai Endpoints */
    public function test_pegawai_can_access_their_endpoints()
    {
        $pegawai = Pegawai::where('id_pegawai', 'L0001')->first();
        if (!$pegawai) {
            $this->markTestSkipped('Pegawai L0001 (Lurah) not found. Seeding issues?');
        }

        // Login as Pegawai (using the 'pegawai' guard config)
        $this->actingAs($pegawai, 'pegawai');

        // Check standard views
        $this->get('/dashboard')->assertStatus(200);
        $this->get('/presensi/create')->assertStatus(200);
        $this->get('/presensi/izin')->assertStatus(200);
        $this->get('/presensi/histori')->assertStatus(200);
        $this->get('/editprofile')->assertStatus(200);
    }

    /** Penetration Test: Admin System Endpoints */
    public function test_admin_can_access_all_panel_endpoints()
    {
        $admin = User::where('email', 'admin@condongcatur.id')->first();
        if (!$admin) {
            $this->markTestSkipped('Admin account not found in DB.');
        }

        $this->actingAs($admin, 'user');

        // Admin Dashboard
        $this->get('/panel/dashboardadmin')->assertStatus(200);

        // Data Master Checks
        $this->get('/pegawai')->assertStatus(200);
        $this->get('/departemen')->assertStatus(200);
        $this->get('/users')->assertStatus(200);

        // Notifications & Settings
        $this->get('/panel/settings')->assertStatus(200);
        $this->get('/panel/profile')->assertStatus(200);
    }

    /** Penetration Test: Laporan & Petugas Routes */
    public function test_petugas_can_access_log_and_reports()
    {
        $petugas = User::where('email', 'petugas@condongcatur.id')->first();
        if (!$petugas) {
            $this->markTestSkipped('Petugas account not found in DB.');
        }

        $this->actingAs($petugas, 'user');

        // As Petugas
        $this->get('/petugas/jadwal')->assertStatus(200);
        $this->get('/petugas/verifikasi-cuti')->assertStatus(200);
        $this->get('/petugas/validasi-presensi')->assertStatus(200);
        $this->get('/presensi/monitoring')->assertStatus(200);
    }
}
