<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PeriodeJadwal;
use App\Models\Jadwal;
use Illuminate\Http\Request;

class PeriodeJadwalController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $periode = PeriodeJadwal::latest()->get();

        return view('admin.periode.index', compact('periode'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        return view('admin.periode.create');
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([
            'tahun_ajaran'    => 'required',
            'semester'        => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        PeriodeJadwal::create([
            'tahun_ajaran'    => $request->tahun_ajaran,
            'semester'        => $request->semester,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect('/admin/periode')
            ->with('success', 'Periode berhasil ditambahkan');
    }

    public function copyJadwal($id)
    {
        // PERIODE TUJUAN
        $periodeTujuan = PeriodeJadwal::findOrFail($id);

        // PERIODE SUMBER (AKTIF)
        $periodeAsal = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        // JIKA TIDAK ADA PERIODE AKTIF
        if (!$periodeAsal) {

            return back()->with(
                'error',
                'Tidak ada periode aktif sebagai sumber jadwal'
            );

        }

        // JANGAN COPY KE PERIODE YANG SAMA
        if ($periodeAsal->id == $periodeTujuan->id) {

            return back()->with(
                'error',
                'Tidak dapat menyalin jadwal ke periode yang sama'
            );

        }

        // CEK APAKAH PERIODE TUJUAN SUDAH PUNYA JADWAL
        if (
            Jadwal::where(
                'periode_id',
                $periodeTujuan->id
            )->exists()
        ) {

            return back()->with(
                'error',
                'Periode tujuan sudah memiliki jadwal'
            );

        }

        // AMBIL SEMUA JADWAL DARI PERIODE AKTIF
        $jadwalLama = Jadwal::where(
            'periode_id',
            $periodeAsal->id
        )->get();

        // JIKA TIDAK ADA JADWAL
        if ($jadwalLama->count() == 0) {

            return back()->with(
                'error',
                'Tidak ada jadwal yang dapat disalin'
            );

        }

        // COPY JADWAL
        foreach ($jadwalLama as $j) {

            Jadwal::create([

                'periode_id'         => $periodeTujuan->id,
                'kelas_id'           => $j->kelas_id,
                'mata_pelajaran_id'  => $j->mata_pelajaran_id,
                'tentor_id'          => $j->tentor_id,
                'ruangan_id'         => $j->ruangan_id,
                'hari'               => $j->hari,
                'sesi_id'            => $j->sesi_id,

            ]);
        }

        return back()->with(
            'success',
            'Jadwal berhasil disalin dari periode aktif'
        );
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $periode = PeriodeJadwal::findOrFail($id);

        return view('admin.periode.edit', compact('periode'));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([
            'tahun_ajaran'    => 'required',
            'semester'        => 'required',
            'tanggal_mulai'   => 'required|date',
            'tanggal_selesai' => 'required|date',
        ]);

        $periode = PeriodeJadwal::findOrFail($id);

        $periode->update([
            'tahun_ajaran'    => $request->tahun_ajaran,
            'semester'        => $request->semester,
            'tanggal_mulai'   => $request->tanggal_mulai,
            'tanggal_selesai' => $request->tanggal_selesai,
        ]);

        return redirect('/admin/periode')
            ->with('success', 'Periode berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $periode = PeriodeJadwal::findOrFail($id);

        $periode->delete();

        return redirect('/admin/periode')
            ->with('success', 'Periode berhasil dihapus');
    }

    /*Aktifkan Periode*/
    public function aktifkan($id)
    {
        // NONAKTIFKAN SEMUA PERIODE
        PeriodeJadwal::query()->update([
            'is_active' => false
        ]);

        // AKTIFKAN YANG DIPILIH
        $periode = PeriodeJadwal::findOrFail($id);

        $periode->update([
            'is_active' => true
        ]);

        return redirect('/admin/periode')
            ->with('success', 'Periode berhasil diaktifkan');
    }
}

