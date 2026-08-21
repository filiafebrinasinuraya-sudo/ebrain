<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AbsensiController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM ABSENSI
    |--------------------------------------------------------------------------
    */
    public function create(Request $request, Jadwal $jadwal)
    {
        $siswa = $jadwal->kelas->siswa()
            ->where('status', 'Aktif')
            ->orderBy('nama')
            ->get();

        $tanggal = $request->tanggal ?? now()->toDateString();

        $absensiHariIni = Absensi::where('jadwal_id', $jadwal->id)
            ->whereDate('tanggal', $tanggal)
            ->get()
            ->keyBy('siswa_id');

        $sudahAbsen = $absensiHariIni->count() > 0;

        return view('tentor.absensi.create', compact(
            'jadwal',
            'siswa',
            'tanggal',
            'absensiHariIni',
            'sudahAbsen'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN ABSENSI
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Jadwal $jadwal)
    {
        $request->validate([
            'tanggal' => 'required|date',
            'absensi' => 'required|array',
            'absensi.*.siswa_id' => 'required',
            'absensi.*.status' => 'required|in:Hadir,Izin,Sakit,Alpha',
        ]);

        $tanggal = Carbon::parse($request->tanggal);

        // Maksimal 7 hari ke belakang
        if ($tanggal->lt(now()->subDays(7)->startOfDay())) {
            return back()->with(
                'error',
                'Absensi maksimal 7 hari ke belakang'
            );
        }

        // Tidak boleh tanggal masa depan
        if ($tanggal->gt(now()->endOfDay())) {
            return back()->with(
                'error',
                'Tanggal absensi tidak valid'
            );
        }

        foreach ($request->absensi as $data) {

            Absensi::updateOrCreate(
                [
                    'jadwal_id' => $jadwal->id,
                    'siswa_id' => $data['siswa_id'],
                    'tanggal' => $request->tanggal,
                ],
                [
                    'status' => $data['status'],
                ]
            );
        }

        return redirect()
        ->route('tentor.jadwal')
        ->with(
            'success',
            'Absensi berhasil disimpan'
        );
    }
}