<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\MataPelajaran;

class MataPelajaranController extends Controller
{
    // 📋 Tampilkan data
    public function index()
    {
        $mata_pelajaran = MataPelajaran::oldest()->get();

        return view('admin.mata_pelajaran.index', compact('mata_pelajaran'));
    }

    // ➕ Form tambah
    public function create()
    {
        return view('admin.mata_pelajaran.create');
    }

    // 💾 Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'singkatan'  => 'required|max:10',
        ]);

        MataPelajaran::create([
            'nama_mapel' => $request->nama_mapel,
            'singkatan'  => strtoupper($request->singkatan),
        ]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil ditambahkan');
    }

    // ✏️ Form edit
    public function edit($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);

        return view('admin.mata_pelajaran.edit', compact('mata_pelajaran'));
    }

    // 🔄 Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_mapel' => 'required',
            'singkatan'  => 'required|max:10',
        ]);

        $mata_pelajaran = MataPelajaran::findOrFail($id);

        $mata_pelajaran->update([
            'nama_mapel' => $request->nama_mapel,
            'singkatan'  => strtoupper($request->singkatan),
        ]);

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil diupdate');
    }

    // ❌ Hapus data
    public function destroy($id)
    {
        $mata_pelajaran = MataPelajaran::findOrFail($id);

        $mata_pelajaran->delete();

        return redirect()->route('admin.mata_pelajaran.index')
            ->with('success', 'Mata pelajaran berhasil dihapus');
    }
}