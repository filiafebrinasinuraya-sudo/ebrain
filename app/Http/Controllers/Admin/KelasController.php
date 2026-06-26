<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Program;

class KelasController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX
    |--------------------------------------------------------------------------
    */
    public function index()
    {
        $kelas = Kelas::with('program')

            ->withCount([
                'siswa' => function ($q) {

                    $q->where('status', 'Aktif');

                }
            ])

            ->latest()

            ->get();

        return view('admin.kelas.index', compact('kelas'));
    }

    /*
    |--------------------------------------------------------------------------
    | CREATE
    |--------------------------------------------------------------------------
    */
    public function create()
    {
        $program = Program::orderBy('nama_program')->get();

        return view('admin.kelas.create', compact('program'));
    }

    /*
    |--------------------------------------------------------------------------
    | STORE
    |--------------------------------------------------------------------------
    */
    public function store(Request $request)
    {
        $request->validate([

            'program_id' => 'required|exists:programs,id',

            'nama_kelas' => 'required|unique:kelas,nama_kelas',

            'hari_belajar' => 'nullable|array'

        ]);

        Kelas::create([

            'program_id' => $request->program_id,

            'nama_kelas' => $request->nama_kelas,

            // SIMPAN MENJADI STRING
            'hari_belajar' => $request->hari_belajar
                ? implode(',', $request->hari_belajar)
                : null

        ]);

        return redirect('/admin/kelas')

            ->with('success', 'Kelas berhasil ditambahkan');
    }

    /*
    |--------------------------------------------------------------------------
    | EDIT
    |--------------------------------------------------------------------------
    */
    public function edit($id)
    {
        $kelas = Kelas::findOrFail($id);

        $program = Program::orderBy('nama_program')->get();

        return view('admin.kelas.edit', compact(
            'kelas',
            'program'
        ));
    }

    /*
    |--------------------------------------------------------------------------
    | UPDATE
    |--------------------------------------------------------------------------
    */
    public function update(Request $request, $id)
    {
        $request->validate([

            'program_id' => 'required|exists:programs,id',

            'nama_kelas' => 'required|unique:kelas,nama_kelas,' . $id,

            'hari_belajar' => 'nullable|array'

        ]);

        $kelas = Kelas::findOrFail($id);

        $kelas->update([

            'program_id' => $request->program_id,

            'nama_kelas' => $request->nama_kelas,

            // UPDATE HARI BELAJAR
            'hari_belajar' => $request->hari_belajar
                ? implode(',', $request->hari_belajar)
                : null

        ]);

        return redirect('/admin/kelas')

            ->with('success', 'Kelas berhasil diupdate');
    }

    /*
    |--------------------------------------------------------------------------
    | DELETE
    |--------------------------------------------------------------------------
    */
    public function destroy($id)
    {
        $kelas = Kelas::withCount('siswa')

            ->findOrFail($id);

        // CEGAH HAPUS JIKA MASIH ADA SISWA
        if ($kelas->siswa_count > 0) {

            return back()

                ->withErrors(
                    'Kelas tidak bisa dihapus karena masih ada siswa!'
                );
        }

        $kelas->delete();

        return redirect('/admin/kelas')

            ->with('success', 'Kelas berhasil dihapus');
    }

    /*
    |--------------------------------------------------------------------------
    | LAPORAN
    |--------------------------------------------------------------------------
    */
    public function laporan($id)
    {
        $kelas = Kelas::with([

            'program',

            'siswa' => function ($q) {

                $q->where('status', 'Aktif');

            }

        ])->findOrFail($id);

        return view('admin.kelas.laporan', compact('kelas'));
    }
}