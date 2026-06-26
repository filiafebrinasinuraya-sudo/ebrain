<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Tentor;
use Illuminate\Support\Facades\Hash;

class TentorController extends Controller
{
    // =====================
    // LIST DATA
    // =====================
    public function index(Request $request)
    {
        $query = \App\Models\Tentor::with('user')->latest();

        // 🔍 SEARCH (nama + email)
        if ($request->search) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                ->orWhereHas('user', function ($q) use ($request) {
                    $q->where('email', 'like', '%' . $request->search . '%');
                });
        }

        // 📄 PAGINATION
        $tentor = $query->paginate(10)->withQueryString();

        return view('admin.tentor.index', compact('tentor'));
    }

    // =====================
    // FORM CREATE
    // =====================
    public function create()
    {
        return view('admin.tentor.create');
    }

    // =====================
    // STORE (USER + TENTOR)
    // =====================
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'inisial' => 'required|max:10',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'no_hp' => 'required',
        ]);

        // 1. BUAT USER
        $user = User::create([
            'name' => $request->nama,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'tentor'
        ]);

        // 2. BUAT TENTOR
        Tentor::create([
            'user_id' => $user->id,
            'nama' => $request->nama,
            'inisial' => $request->inisial,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $request->jurusan,
            'status' => true,
            'tanggal_bergabung' => now()
        ]);

        return redirect('/admin/tentor')->with('success', 'Tentor berhasil ditambahkan');
    }

    // =====================
    // EDIT FORM
    // =====================
    public function edit($id)
    {
        $tentor = Tentor::findOrFail($id);
        return view('admin.tentor.edit', compact('tentor'));
    }

    // =====================
    // UPDATE DATA
    // =====================
    public function update(Request $request, $id)
    {
        $tentor = Tentor::findOrFail($id);

        $tentor->update([
            'nama' => $request->nama,
            'inisial' => $request->inisial,
            'jenis_kelamin' => $request->jenis_kelamin,
            'no_hp' => $request->no_hp,
            'alamat' => $request->alamat,
            'pendidikan_terakhir' => $request->pendidikan_terakhir,
            'jurusan' => $request->jurusan,
            'status' => $request->status,
        ]);

        return redirect('/admin/tentor')->with('success', 'Data berhasil diupdate');
    }

    // =====================
    // DELETE DATA
    // =====================
    public function destroy($id)
    {
        $tentor = Tentor::findOrFail($id);

        // hapus user juga
        User::where('id', $tentor->user_id)->delete();

        $tentor->delete();

        return redirect('/admin/tentor')->with('success', 'Data berhasil dihapus');
    }
}