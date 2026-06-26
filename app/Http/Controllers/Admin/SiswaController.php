<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Siswa;
use App\Models\User;
use App\Models\Kelas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class SiswaController extends Controller
{
    /**
     * LIST SISWA
     */
    public function index(Request $request)
    {
        $query = Siswa::with('user', 'kelas')->latest();

        // 🔍 SEARCH
        if ($request->search) {
            $query->where(function($q) use ($request) {
                $q->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhereHas('user', function ($q2) use ($request) {
                      $q2->where('email', 'like', '%' . $request->search . '%');
                  });
            });
        }

        // 🎯 FILTER KELAS
        if ($request->kelas) {
            $query->whereHas('kelas', function ($q) use ($request) {
                $q->where('kelas.id', $request->kelas);
            });
        }

        $siswa = $query->paginate(10)->withQueryString();
        $kelas = Kelas::all();

        return view('admin.siswa.index', compact('siswa', 'kelas'));
    }

    /**
     * FORM CREATE
     */
    public function create()
    {
        $kelas = Kelas::with('program')->get();
        return view('admin.siswa.create', compact('kelas'));
    }

    /**
     * STORE SISWA
     */
    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'tanggal_daftar' => 'required|date',

            // ✅ MULTI KELAS
            'kelas_id' => 'nullable|array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        DB::beginTransaction();

        try {

            // USER LOGIN
            $user = User::create([
                'name' => $request->nama,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'role' => 'siswa'
            ]);

            // DATA SISWA
            $siswa = Siswa::create([
                'user_id' => $user->id,
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'asal_sekolah' => $request->asal_sekolah,
                'kelas_sekolah' => $request->kelas_sekolah,
                'ranking' => $request->ranking,
                'kurikulum' => $request->kurikulum,
                'nama_ayah' => $request->nama_ayah,
                'no_hp_ayah' => $request->no_hp_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ibu' => $request->no_hp_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status ?? 'Aktif'
            ]);

            // 🔥 SIMPAN KELAS (PIVOT)
            if ($request->kelas_id) {
                $siswa->kelas()->attach($request->kelas_id);
            }

            DB::commit();

            return redirect('/admin/siswa')->with('success', 'Siswa berhasil ditambahkan');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * FORM EDIT
     */
    public function edit($id)
    {
        $siswa = Siswa::with('user', 'kelas')->findOrFail($id);
        $kelas = Kelas::with('program')->get();

        return view('admin.siswa.edit', compact('siswa', 'kelas'));
    }

    /**
     * UPDATE SISWA
     */
    public function update(Request $request, $id)
    {
        $siswa = Siswa::with('user', 'kelas')->findOrFail($id);

        $request->validate([
            'nama' => 'required',
            'email' => 'required|email|unique:users,email,' . $siswa->user_id,
            'tanggal_daftar' => 'required|date',

            // ✅ MULTI KELAS
            'kelas_id' => 'nullable|array',
            'kelas_id.*' => 'exists:kelas,id',
        ]);

        DB::beginTransaction();

        try {

            // UPDATE SISWA
            $siswa->update([
                'nama' => $request->nama,
                'alamat' => $request->alamat,
                'no_hp' => $request->no_hp,
                'agama' => $request->agama,
                'jenis_kelamin' => $request->jenis_kelamin,
                'tempat_lahir' => $request->tempat_lahir,
                'tanggal_lahir' => $request->tanggal_lahir,
                'asal_sekolah' => $request->asal_sekolah,
                'kelas_sekolah' => $request->kelas_sekolah,
                'ranking' => $request->ranking,
                'kurikulum' => $request->kurikulum,
                'nama_ayah' => $request->nama_ayah,
                'no_hp_ayah' => $request->no_hp_ayah,
                'pekerjaan_ayah' => $request->pekerjaan_ayah,
                'nama_ibu' => $request->nama_ibu,
                'no_hp_ibu' => $request->no_hp_ibu,
                'pekerjaan_ibu' => $request->pekerjaan_ibu,
                'tanggal_daftar' => $request->tanggal_daftar,
                'status' => $request->status,
            ]);

            // UPDATE USER
            $siswa->user->update([
                'name' => $request->nama,
                'email' => $request->email,
            ]);

            // 🔥 UPDATE KELAS (SYNC)
            if ($request->kelas_id) {
                $siswa->kelas()->sync($request->kelas_id);
            } else {
                $siswa->kelas()->detach();
            }

            DB::commit();

            return redirect('/admin/siswa')->with('success', 'Data berhasil diupdate');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * DELETE
     */
    public function destroy($id)
    {
        DB::beginTransaction();

        try {

            $siswa = Siswa::with('user')->findOrFail($id);

            // hapus relasi kelas dulu
            $siswa->kelas()->detach();

            $user = $siswa->user;

            $siswa->delete();

            if ($user) {
                $user->delete();
            }

            DB::commit();

            return redirect('/admin/siswa')->with('success', 'Siswa berhasil dihapus');

        } catch (\Exception $e) {
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    /**
     * DETAIL
     */
    public function detail($id)
    {
        $siswa = Siswa::with('user', 'kelas')->findOrFail($id);

        return view('admin.siswa.detail', compact('siswa'));
    }
}