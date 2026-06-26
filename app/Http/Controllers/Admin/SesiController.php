<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sesi;

class SesiController extends Controller
{
    public function index()
    {
        $sesi = Sesi::all();
        return view('admin.sesi.index', compact('sesi'));
    }

    public function create()
    {
        return view('admin.sesi.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama_sesi' => 'required',
            'jam_mulai' => 'required',
            'jam_selesai' => 'required',
        ]);

        Sesi::create([
            'nama_sesi' => $request->nama_sesi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('admin.sesi.index')
            ->with('success', 'Sesi berhasil ditambah');
    }

    public function edit($id)
    {
        $sesi = Sesi::findOrFail($id);

        return view('admin.sesi.edit', compact('sesi'));
    }

    public function update(Request $request, $id)
    {
        $sesi = Sesi::findOrFail($id);

        $sesi->update([
            'nama_sesi' => $request->nama_sesi,
            'jam_mulai' => $request->jam_mulai,
            'jam_selesai' => $request->jam_selesai,
        ]);

        return redirect()->route('admin.sesi.index')
            ->with('success', 'Sesi diupdate');
    }

    public function destroy($id)
    {
        Sesi::findOrFail($id)->delete();

        return back()->with('success', 'Sesi dihapus');
    }
}