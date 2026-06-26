<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;

use App\Models\Jadwal;
use App\Models\PeriodeJadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $siswa = auth()->user()->siswa;

        // AMBIL SEMUA KELAS SISWA
        $kelasIds = $siswa->kelas->pluck('id');

        // AMBIL PERIODE AKTIF
        $periodeAktif = PeriodeJadwal::where('is_active', 1)
            ->first();

        // JIKA BELUM ADA PERIODE
        if (!$periodeAktif) {

            return view('siswa.jadwal.index', [
                'jadwal' => collect(),
                'periodeAktif' => null
            ]);
        }

        // AMBIL JADWAL SESUAI PERIODE
        $jadwal = Jadwal::with([
            'kelas',
            'mataPelajaran',
            'tentor',
            'ruangan',
            'sesi'
        ])

        ->whereIn('kelas_id', $kelasIds)

        ->where('periode_id', $periodeAktif->id)

        ->orderByRaw("
            FIELD(hari,
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu')
        ")

        ->orderBy('sesi_id')

        ->get();

        return view('siswa.jadwal.index', compact(
            'jadwal',
            'periodeAktif'
        ));
    }
}