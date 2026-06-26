<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Ruangan;

class RuanganController extends Controller
{
    // 📋 Tampilkan semua data
    public function index()
    {
        $ruangan = Ruangan::all();
        return view('admin.ruangan.index', compact('ruangan'));
    }

    // ➕ Form tambah
    public function create()
    {
        return view('admin.ruangan.create');
    }

    // 💾 Simpan data
    public function store(Request $request)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas' => 'nullable|integer',
        ]);

        Ruangan::create([
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil ditambahkan');
    }

    // ✏️ Form edit
    public function edit($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        return view('admin.ruangan.edit', compact('ruangan'));
    }

    // 🔄 Update data
    public function update(Request $request, $id)
    {
        $request->validate([
            'nama_ruangan' => 'required',
            'kapasitas' => 'nullable|integer',
        ]);

        $ruangan = Ruangan::findOrFail($id);

        $ruangan->update([
            'nama_ruangan' => $request->nama_ruangan,
            'kapasitas' => $request->kapasitas,
        ]);

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil diupdate');
    }

    // ❌ Hapus data
    public function destroy($id)
    {
        $ruangan = Ruangan::findOrFail($id);
        $ruangan->delete();

        return redirect()->route('admin.ruangan.index')
            ->with('success', 'Ruangan berhasil dihapus');
    }
}