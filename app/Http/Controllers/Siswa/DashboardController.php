<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

use App\Models\Jadwal;
use App\Models\PeriodeJadwal;
use App\Models\Absensi;

class DashboardController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        // PERIODE AKTIF
        $periodeAktif = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        // JADWAL SISWA
        $kelasIds = $siswa->kelas->pluck('id');

        $jadwal = Jadwal::with([
                'mataPelajaran',
                'tentor',
                'ruangan',
                'sesi'
            ])
            ->whereIn('kelas_id', $kelasIds)
            ->where(
                'periode_id',
                $periodeAktif->id ?? null
            )
            ->get();

        // TOTAL JADWAL
        $totalJadwal = $jadwal->count();

        // HARI INI
        $hariIni = now()->locale('id')->dayName;

        // JADWAL HARI INI
        $jadwalToday = $jadwal
            ->where('hari', $hariIni);

        // ABSENSI
        $totalAbsensi = Absensi::where(
            'siswa_id',
            $siswa->id
        )->count();

        $hadir = Absensi::where(
            'siswa_id',
            $siswa->id
        )
        ->where(
            'status',
            'Hadir'
        )
        ->count();

        // PERSENTASE KEHADIRAN
        $persentaseKehadiran = $totalAbsensi > 0
            ? round(($hadir / $totalAbsensi) * 100)
            : 0;

        return view('siswa.dashboard', compact(
            'siswa',
            'periodeAktif',
            'totalJadwal',
            'persentaseKehadiran',
            'jadwalToday'
        ));
    }
}