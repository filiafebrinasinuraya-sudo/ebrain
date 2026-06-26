<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use Illuminate\Http\Request;

class AbsensiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = Absensi::with([
                'jadwal.mataPelajaran',
                'jadwal.tentor'
            ])
            ->where(
                'siswa_id',
                $siswa->id
            );

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereMonth(
                'tanggal',
                $request->bulan
            );
        }

        // FILTER TAHUN
        if ($request->tahun) {
            $query->whereYear(
                'tanggal',
                $request->tahun
            );
        }

        // FILTER STATUS
        if ($request->status) {
            $query->where(
                'status',
                $request->status
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG STATISTIK
        |--------------------------------------------------------------------------
        */
        $allAbsensi = (clone $query)->get();

        $hadir = $allAbsensi
            ->where('status', 'Hadir')
            ->count();

        $izin = $allAbsensi
            ->where('status', 'Izin')
            ->count();

        $sakit = $allAbsensi
            ->where('status', 'Sakit')
            ->count();

        $alpha = $allAbsensi
            ->where('status', 'Alpha')
            ->count();

        $total = max(
            $allAbsensi->count(),
            1
        );

        $persentase = round(
            ($hadir / $total) * 100
        );

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $absensi = $query
            ->latest('tanggal')
            ->paginate(10)
            ->withQueryString();

        return view('siswa.absensi.index', compact(
            'absensi',
            'hadir',
            'izin',
            'sakit',
            'alpha',
            'persentase'
        ));
    }
}