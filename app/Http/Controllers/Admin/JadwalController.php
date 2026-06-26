<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\Jadwal;
use App\Models\Kelas;
use App\Models\Tentor;
use App\Models\Ruangan;
use App\Models\PeriodeJadwal;
use App\Models\MataPelajaran;
use App\Models\Sesi;

class JadwalController extends Controller
{
    /*
    |-----------------------------------------
    | INDEX
    |-----------------------------------------
    */
    public function index(Request $request)
    {
        $query = Jadwal::with([
            'periode',
            'kelas',
            'mataPelajaran',
            'tentor',
            'ruangan',
            'sesi'
        ]);

        if ($request->kelas_id) {

            $query->where('kelas_id', $request->kelas_id);

        }

        if ($request->hari) {

            $query->where('hari', $request->hari);

        }

        if ($request->periode_id) {

            $query->where(
                'periode_id',
                $request->periode_id
            );

        }

        if ($request->search) {

            $search = $request->search;

            $query->where(function ($q) use ($search) {

                $q->where('hari', 'like', "%{$search}%")

                ->orWhereHas('mataPelajaran', function ($q2) use ($search) {

                    $q2->where('singkatan', 'like', "%{$search}%")
                    ->orWhere('nama_mapel', 'like', "%{$search}%");

                })

                ->orWhereHas('tentor', function ($q3) use ($search) {

                    $q3->where('nama', 'like', "%{$search}%");

                })

                ->orWhereHas('kelas', function ($q4) use ($search) {

                    $q4->where('nama_kelas', 'like', "%{$search}%");

                })

                ->orWhereHas('ruangan', function ($q5) use ($search) {

                    $q5->where('nama_ruangan', 'like', "%{$search}%");

                })

                ->orWhereHas('sesi', function ($q6) use ($search) {

                    $q6->where('nama_sesi', 'like', "%{$search}%");

                });

            });
        }
        
        return view('admin.jadwal.index', [

            'jadwal' => $query

                // URUT HARI
                ->orderByRaw("
                    FIELD(hari,
                    'Senin',
                    'Selasa',
                    'Rabu',
                    'Kamis',
                    'Jumat',
                    'Sabtu')
                ")

                // URUT SESI
                ->orderBy('sesi_id')

                ->get(),

            // FILTER KELAS
            'kelas' => Kelas::orderBy('nama_kelas')->get(),
            'periode' => PeriodeJadwal::orderBy(
                'tanggal_mulai',
                'desc'
            )->get(),

            // PERIODE AKTIF
           'periodeAktif' => PeriodeJadwal::where(
                'is_active',
                true
            )->first(),

        ]);
    }

    /*
    |-----------------------------------------
    | MATRIX TIMETABLE
    |-----------------------------------------
    */
    public function matrix()
    {
        $hari = [
            'Senin',
            'Selasa',
            'Rabu',
            'Kamis',
            'Jumat',
            'Sabtu'
        ];

        $ruangan = Ruangan::orderBy('id', 'asc')->get();

        $sesi = Sesi::orderBy('jam_mulai')->get();

        $periodeAktif = PeriodeJadwal::where(
            'is_active',
            true
        )->first();

        // CEK JIKA BELUM ADA PERIODE
        if (!$periodeAktif) {

            return redirect()
                ->route('jadwal.index')
                ->with('error', 'Belum ada periode aktif');

        }

        $jadwal = Jadwal::with([
                'kelas',
                'tentor',
                'mataPelajaran',
                'ruangan',
                'sesi'
            ])

            ->where('periode_id', $periodeAktif->id)

            // URUT HARI
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

            // URUT SESI
            ->orderBy('sesi_id')

            ->get();

        return view('admin.jadwal.matrix', compact(
            'hari',
            'ruangan',
            'sesi',
            'jadwal',
            'periodeAktif'
        ));
    }

    /*
    |-----------------------------------------
    | CREATE
    |-----------------------------------------
    */
    public function create()
    {
        return view('admin.jadwal.create', [
            'periodeAktif' => PeriodeJadwal::where(
                'is_active',
                true
            )->first(),
            'periode' => PeriodeJadwal::orderBy('created_at', 'desc')->get(),
            'kelas' => Kelas::orderBy('nama_kelas')->get(),
            'mapel' => MataPelajaran::orderBy('nama_mapel')->get(),
            'tentor' => Tentor::orderBy('nama')->get(),
            'ruangan' => Ruangan::orderBy('nama_ruangan')->get(),
            'sesi' => Sesi::orderBy('jam_mulai')->get(),
        ]);
    }

    /*
    |-----------------------------------------
    | STORE
    |-----------------------------------------
    */
    public function store(Request $request)
    {
        $periodeAktif = PeriodeJadwal::where('is_active', true)->first();

        if (!$periodeAktif) {
            return back()->with('error', 'Belum ada periode aktif');
        }

        $request->validate([
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'tentor_id' => 'required',
            'ruangan_id' => 'required',
            'hari' => 'required',
            'sesi_id' => 'required'
        ]);

        // CEK RUANGAN
        $cekRuangan = Jadwal::where('periode_id', $periodeAktif->id)
            ->where('hari', $request->hari)
            ->where('ruangan_id', $request->ruangan_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekRuangan) {
            return back()->withInput()
                ->with('error', 'Ruangan sudah dipakai di sesi ini');
        }

        // CEK TENTOR
        $cekTentor = Jadwal::where('periode_id', $periodeAktif->id)
            ->where('hari', $request->hari)
            ->where('tentor_id', $request->tentor_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekTentor) {
            return back()->withInput()
                ->with('error', 'Tentor bentrok di sesi ini');
        }

        // CEK KELAS
        $cekKelas = Jadwal::where('periode_id', $periodeAktif->id)
            ->where('hari', $request->hari)
            ->where('kelas_id', $request->kelas_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekKelas) {
            return back()->withInput()
                ->with('error', 'Kelas sudah ada jadwal di sesi ini');
        }

        Jadwal::create([
            'periode_id' => $periodeAktif->id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tentor_id' => $request->tentor_id,
            'ruangan_id' => $request->ruangan_id,
            'hari' => $request->hari,
            'sesi_id' => $request->sesi_id
        ]);

        return redirect()->route('jadwal.matrix')
            ->with('success', 'Jadwal berhasil ditambahkan');
    }

    /*
    |-----------------------------------------
    | JADWAL MINGGUAN FORM
    |-----------------------------------------
    */
    public function jadwalmingguanCreate()
    {
        $kelas = Kelas::all();

        $ruangan = Ruangan::all();

        $tentor = Tentor::orderBy('nama')->get();

        $mapel = MataPelajaran::orderBy('nama_mapel')->get();

        $sesi = Sesi::orderBy('jam_mulai')->get();

        $periode = PeriodeJadwal::orderBy(
            'tanggal_mulai',
            'desc'
        )->get();

        return view('admin.jadwal.jadwalmingguan', compact(
            'kelas',
            'ruangan',
            'tentor',
            'mapel',
            'sesi',
            'periode'
        ));
    }

    /*
    |-----------------------------------------
    | STORE MINGGUAN
    |-----------------------------------------
    */
    public function jadwalmingguanStore(Request $request)
    {
        $request->validate([
            'periode_id' => 'required'
        ]);

        foreach ($request->jadwal as $data) {

            if (
                empty($data['kelas_id']) ||
                empty($data['ruangan_id']) ||
                empty($data['tentor_id']) ||
                empty($data['sesi_id'])
            ) {
                continue;
            }

            // CEK RUANGAN
            if (
                Jadwal::where('periode_id', $request->periode_id)
                    ->where('hari', $data['hari'])
                    ->where('ruangan_id', $data['ruangan_id'])
                    ->where('sesi_id', $data['sesi_id'])
                    ->exists()
            ) {

                return back()->withInput()
                    ->with(
                        'error',
                        'Ruangan sudah dipakai pada '
                        . $data['hari']
                    );

            }

            // CEK TENTOR
            if (
                Jadwal::where('periode_id', $request->periode_id)
                    ->where('hari', $data['hari'])
                    ->where('tentor_id', $data['tentor_id'])
                    ->where('sesi_id', $data['sesi_id'])
                    ->exists()
            ) {

                return back()->withInput()
                    ->with(
                        'error',
                        'Tentor bentrok pada '
                        . $data['hari']
                    );

            }

            // CEK KELAS
            if (
                Jadwal::where('periode_id', $request->periode_id)
                    ->where('hari', $data['hari'])
                    ->where('kelas_id', $data['kelas_id'])
                    ->where('sesi_id', $data['sesi_id'])
                    ->exists()
            ) {

                return back()->withInput()
                    ->with(
                        'error',
                        'Kelas sudah memiliki jadwal pada '
                        . $data['hari']
                    );

            }

            Jadwal::create([
                'periode_id' => $request->periode_id,
                'kelas_id' => $data['kelas_id'],
                'ruangan_id' => $data['ruangan_id'],
                'tentor_id' => $data['tentor_id'],
                'mata_pelajaran_id' => $data['mata_pelajaran_id'] ?? null,
                'hari' => $data['hari'],
                'sesi_id' => $data['sesi_id'],
            ]);
        }

        return redirect()->route('jadwal.index')
            ->with('success', 'Jadwal berhasil disimpan');
    }

    /*
    |-----------------------------------------
    | EDIT
    |-----------------------------------------
    */
    public function edit($id)
    {
        $jadwal = Jadwal::findOrFail($id);

        return view('admin.jadwal.edit', [
            'jadwal' => $jadwal,
            'periode' => PeriodeJadwal::all(),
            'kelas' => Kelas::all(),
            'mapel' => MataPelajaran::all(),
            'tentor' => Tentor::all(),
            'ruangan' => Ruangan::all(),
            'sesi' => Sesi::orderBy('jam_mulai')->get(),
        ]);
    }

    /*
    |-----------------------------------------
    | UPDATE
    |-----------------------------------------
    */
    public function update(Request $request, $id)
    {
        $jadwal = Jadwal::findOrFail($id);

        $request->validate([
            'periode_id' => 'required',
            'kelas_id' => 'required',
            'mata_pelajaran_id' => 'required',
            'tentor_id' => 'required',
            'ruangan_id' => 'required',
            'hari' => 'required',
            'sesi_id' => 'required'
        ]);

        // CEK RUANGAN
        $cekRuangan = Jadwal::where('id', '!=', $id)
            ->where('periode_id', $request->periode_id)
            ->where('hari', $request->hari)
            ->where('ruangan_id', $request->ruangan_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekRuangan) {
            return back()->withInput()
                ->with('error', 'Ruangan sudah dipakai di sesi ini');
        }

        // CEK TENTOR
        $cekTentor = Jadwal::where('id', '!=', $id)
            ->where('periode_id', $request->periode_id)
            ->where('hari', $request->hari)
            ->where('tentor_id', $request->tentor_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekTentor) {
            return back()->withInput()
                ->with('error', 'Tentor bentrok di sesi ini');
        }

        // CEK KELAS
        $cekKelas = Jadwal::where('id', '!=', $id)
            ->where('periode_id', $request->periode_id)
            ->where('hari', $request->hari)
            ->where('kelas_id', $request->kelas_id)
            ->where('sesi_id', $request->sesi_id)
            ->exists();

        if ($cekKelas) {
            return back()->withInput()
                ->with('error', 'Kelas sudah ada jadwal di sesi ini');
        }

        $jadwal->update([
            'periode_id' => $request->periode_id,
            'kelas_id' => $request->kelas_id,
            'mata_pelajaran_id' => $request->mata_pelajaran_id,
            'tentor_id' => $request->tentor_id,
            'ruangan_id' => $request->ruangan_id,
            'hari' => $request->hari,
            'sesi_id' => $request->sesi_id,
        ]);

        return redirect()->route('jadwal.matrix')
            ->with('success', 'Jadwal berhasil diupdate');
    }

    /*
    |-----------------------------------------
    | DELETE
    |-----------------------------------------
    */
    public function destroy($id)
    {
        Jadwal::findOrFail($id)->delete();

        return back()->with('success', 'Jadwal berhasil dihapus');
    }
}