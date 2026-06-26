<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Jadwal;
use App\Models\PeriodeJadwal;

class JadwalController extends Controller
{
    public function index()
    {
        $tentor = auth()->user()->tentor;

        $periodeAktif = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        if (!$periodeAktif) {

            return back()->with(
                'error',
                'Belum ada periode aktif'
            );

        }

        $jadwal = Jadwal::with([
                'kelas',
                'mataPelajaran',
                'ruangan',
                'sesi',
                'absensi'

            ])

            ->where('tentor_id', $tentor->id)

            ->where('periode_id', $periodeAktif->id)

            ->orderByRaw("
                FIELD(
                    hari,
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu'
                )
            ")

            ->orderBy('sesi_id')

            ->get();

        return view('tentor.jadwal.index', compact(
            'jadwal',
            'periodeAktif'
        ));
    }
}
