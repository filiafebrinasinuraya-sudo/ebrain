<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;

use App\Models\Jadwal;
use App\Models\PeriodeJadwal;

class DashboardController extends Controller
{
    public function index()
    {
        $tentor = auth()->user()->tentor;

        // PERIODE AKTIF
        $periodeAktif = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        // JADWAL TENTOR
        $jadwal = Jadwal::with([
                'kelas',
                'mataPelajaran',
                'ruangan',
                'sesi'
            ])
            ->where('tentor_id', $tentor->id)
            ->where('periode_id', $periodeAktif->id ?? null)
            ->orderBy('sesi_id')
            ->get();

        // TOTAL JADWAL
        $totalJadwal = $jadwal->count();

        // TOTAL KELAS
        $totalKelas = $jadwal
            ->pluck('kelas_id')
            ->unique()
            ->count();

        // HARI INI
        $hariIni = now()->locale('id')->dayName;

        // JADWAL HARI INI
        $jadwalToday = $jadwal
            ->where('hari', $hariIni);

        // TOTAL HARI INI
        $jadwalHariIni = $jadwalToday->count();

        // ABSENSI HARI INI
        $absensiHariIni = 0;

        return view('tentor.dashboard', compact(
            'periodeAktif',
            'totalJadwal',
            'jadwalHariIni',
            'totalKelas',
            'absensiHariIni',
            'jadwalToday'
        ));
    }
}