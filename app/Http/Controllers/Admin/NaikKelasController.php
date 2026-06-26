<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Kelas;
use Illuminate\Support\Facades\DB;

class NaikKelasController extends Controller
{
    /**
     * FORM NAIK KELAS
     */
    public function index(Request $request)
    {
        // 🔥 pakai withCount biar ada jumlah siswa
        $kelas = Kelas::withCount('siswa')->get();

        $kelas_asal = $request->kelas_asal;

        return view('admin.kelas.naik_kelas', compact('kelas', 'kelas_asal'));
    }

    public function getSiswa(Kelas $kelas)
    {
        return response()->json(
            $kelas->siswa
        );
    }

    /**
     * PROSES NAIK KELAS
     */
    public function proses(Request $request)
    {
        $request->validate([

            'kelas_asal'   => 'required|exists:kelas,id',

            'kelas_tujuan' => 'required|exists:kelas,id|different:kelas_asal',

            'siswa_id'     => 'required|array'

        ]);

        DB::beginTransaction();

        try {

            $siswaDipilih = Siswa::whereIn(
                'id',
                $request->siswa_id
            )->get();

            if ($siswaDipilih->isEmpty()) {

                return back()->withErrors(
                    'Tidak ada siswa dipilih!'
                );

            }

            foreach ($siswaDipilih as $siswa) {

                /*
                |--------------------------------------------------------------------------
                | HAPUS KELAS LAMA
                |--------------------------------------------------------------------------
                */
                $siswa->kelas()->detach(
                    $request->kelas_asal
                );

                /*
                |--------------------------------------------------------------------------
                | TAMBAH KELAS BARU
                |--------------------------------------------------------------------------
                */
                $siswa->kelas()->syncWithoutDetaching([

                    $request->kelas_tujuan

                ]);

            }

            DB::commit();

            return back()->with(
                'success',
                'Siswa berhasil naik kelas'
            );

        } catch (\Exception $e) {

            DB::rollBack();

            return back()->withErrors(
                'Terjadi kesalahan: ' . $e->getMessage()
            );

        }
    }
}