<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Absensi;
use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\PeriodeJadwal;
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
        $tanggal = $request->tanggal
            ?? now()->toDateString();

        /*
        |----------------------------------------------------------------------
        | QUERY ABSENSI
        |----------------------------------------------------------------------
        */
        $query = Absensi::with([
            'siswa',
            'jadwal.kelas',
            'jadwal.tentor',
            'jadwal.mataPelajaran',
            'jadwal.sesi'
        ]);

        // FILTER TANGGAL
        $query->whereDate(
            'tanggal',
            $tanggal
        );

        // FILTER KELAS
        if ($request->kelas_id) {

            $query->whereHas('jadwal', function ($q) use ($request) {

                $q->where(
                    'kelas_id',
                    $request->kelas_id
                );

            });

        }

        // FILTER STATUS
        if ($request->status) {

            $query->where(
                'status',
                $request->status
            );

        }

        $absensi = $query
            ->latest()
            ->get();

        /*
        |----------------------------------------------------------------------
        | GROUPING ABSENSI
        |----------------------------------------------------------------------
        */
        $groupedAbsensi = $absensi
            ->groupBy(function ($item) {

                return $item->jadwal_id . '-' . $item->tanggal;

            })
            ->map(function ($items) {

                $first = $items->first();

                return [

                    'jadwal_id' => $first->jadwal->id,                  

                    'kelas' => $first->jadwal->kelas->nama_kelas,

                    'mapel' => $first->jadwal->mataPelajaran->nama_mapel,

                    'tentor' => $first->jadwal->tentor->nama,

                    'sesi' => $first->jadwal->sesi->nama_sesi,

                    'hadir' => $items
                        ->where('status', 'Hadir')
                        ->count(),

                    'izin' => $items
                        ->where('status', 'Izin')
                        ->count(),

                    'sakit' => $items
                        ->where('status', 'Sakit')
                        ->count(),

                    'alpha' => $items
                        ->where('status', 'Alpha')
                        ->count(),

                    'siswa' => $items->map(function ($a) {

                        return [

                            'id' => $a->id,

                            'nama' => $a->siswa->nama,

                            'status' => $a->status,

                        ];

                    }),

                ];

            });

        /*
        |----------------------------------------------------------------------
        | PERIODE AKTIF
        |----------------------------------------------------------------------
        */
        $periodeAktif = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        /*
        |----------------------------------------------------------------------
        | JADWAL BELUM ABSEN
        |----------------------------------------------------------------------
        */
        $jadwalBelumAbsen = collect();

        if ($periodeAktif) {

            $jadwalHariIni = Jadwal::with([
                    'kelas',
                    'tentor',
                    'mataPelajaran',
                    'sesi',
                    'absensi'
                ])

                ->where(
                    'periode_id',
                    $periodeAktif->id
                )

                ->where(
                    'hari',
                    now()->translatedFormat('l') == 'Monday' ? 'Senin' :
                    (now()->translatedFormat('l') == 'Tuesday' ? 'Selasa' :
                    (now()->translatedFormat('l') == 'Wednesday' ? 'Rabu' :
                    (now()->translatedFormat('l') == 'Thursday' ? 'Kamis' :
                    (now()->translatedFormat('l') == 'Friday' ? 'Jumat' :
                    (now()->translatedFormat('l') == 'Saturday' ? 'Sabtu' : '')))))
                )

                ->get();

            $jadwalBelumAbsen = $jadwalHariIni
                ->filter(function ($j) use ($tanggal) {

                    return !$j->absensi
                        ->where('tanggal', $tanggal)
                        ->count();

                });

        }

        return view('admin.absensi.index', [

            'absensi' => $absensi,

            'groupedAbsensi' => $groupedAbsensi,

            'kelas' => Kelas::orderBy(
                'nama_kelas'
            )->get(),

            'jadwalBelumAbsen' => $jadwalBelumAbsen

        ]);
    }

    public function show(Jadwal $jadwal)
    {
        /*
        |--------------------------------------------------------------------------
        | DATA ABSENSI
        |--------------------------------------------------------------------------
        */
        $absensi = Absensi::with([
                'siswa'
            ])

            ->where(
                'jadwal_id',
                $jadwal->id
            )

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | SUMMARY
        |--------------------------------------------------------------------------
        */
        $hadir = $absensi
            ->where('status', 'Hadir')
            ->count();

        $izin = $absensi
            ->where('status', 'Izin')
            ->count();

        $sakit = $absensi
            ->where('status', 'Sakit')
            ->count();

        $alpha = $absensi
            ->where('status', 'Alpha')
            ->count();

        /*
        |--------------------------------------------------------------------------
        | RETURN VIEW
        |--------------------------------------------------------------------------
        */
        return view('admin.absensi.detail', [

            'jadwal' => $jadwal,

            'absensi' => $absensi,

            'hadir' => $hadir,

            'izin' => $izin,

            'sakit' => $sakit,

            'alpha' => $alpha

        ]);
    }

    /*
    |----------------------------------------------------------------------
    | EDIT
    |----------------------------------------------------------------------
    */
    public function edit(Absensi $absensi)
    {
        return view('admin.absensi.edit', compact(
            'absensi'
        ));
    }

    /*
    |----------------------------------------------------------------------
    | UPDATE
    |----------------------------------------------------------------------
    */
    public function update(Request $request, Absensi $absensi)
    {
        $request->validate([
            'status' => 'required'
        ]);

        $absensi->update([
            'status' => $request->status
        ]);

        return redirect()
            ->route('absensi.index')
            ->with(
                'success',
                'Absensi berhasil diupdate'
            );
    }

    public function destroy(Jadwal $jadwal)
    {
        Absensi::where(
            'jadwal_id',
            $jadwal->id
        )->delete();

        return redirect()
            ->route('absensi.index')
            ->with(
                'success',
                'Data absensi berhasil dihapus'
            );
    }
}