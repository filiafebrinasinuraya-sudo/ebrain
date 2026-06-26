@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-700">
        Tambah Data Siswa
    </h2>

</div>

{{-- ERROR --}}
@if ($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4">
        <ul>
            @foreach ($errors->all() as $error)
                <li>- {{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="{{ url('/admin/siswa') }}" method="POST" class="space-y-6">
@csrf

<!-- ========================= -->
<!-- AKUN LOGIN -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold text-gray-600 mb-4">Akun Login</h3>

    <div class="grid md:grid-cols-2 gap-4">
        <div>
            <label>Email</label>
            <input type="email" name="email"
                class="w-full mt-1 p-2 border rounded-lg" required>
        </div>

        <div>
            <label>Password</label>
            <input type="password" name="password"
            autocomplete="new-password"
                class="w-full mt-1 p-2 border rounded-lg" required>
        </div>
    </div>
</div>

<!-- ========================= -->
<!-- DATA PRIBADI -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold text-gray-600 mb-4">Data Pribadi</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Nama</label>
            <input type="text" name="nama" class="w-full mt-1 p-2 border rounded-lg" required>
        </div>

        <div>
            <label>No HP</label>
            <input type="text" name="no_hp" class="w-full mt-1 p-2 border rounded-lg">
        </div>

        <div class="md:col-span-2">
            <label>Alamat</label>
            <textarea name="alamat" class="w-full mt-1 p-2 border rounded-lg"></textarea>
        </div>

        <div>
            <label>Agama</label>
            <select name="agama" class="w-full mt-1 p-2 border rounded-lg">
                <option value="Islam">Islam</option>
                <option value="Kristen Protestan">Kristen Protestan</option>
                <option value="Katolik">Katolik</option>
                <option value="Hindu">Hindu</option>
                <option value="Budha">Budha</option>
                <option value="Konghucu">Konghucu</option>
            </select>
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full mt-1 p-2 border rounded-lg">
                <option value="Laki-laki">Laki-laki</option>
                <option value="Perempuan">Perempuan</option>
            </select>
        </div>

        <div>
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir" class="w-full mt-1 p-2 border rounded-lg">
        </div>

        <div>
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir" class="w-full mt-1 p-2 border rounded-lg">
        </div>

    </div>
</div>

<!-- ========================= -->
<!-- DATA SEKOLAH -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold text-gray-600 mb-4">Data Sekolah</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Asal Sekolah</label>
            <input type="text" name="asal_sekolah" class="w-full mt-1 p-2 border rounded-lg">
        </div>

        <div>
            <label>Kelas Sekolah</label>
            <input type="text" name="kelas_sekolah" class="w-full mt-1 p-2 border rounded-lg">
        </div>

        <div>
            <label>Ranking</label>
            <input type="number" name="ranking" class="w-full mt-1 p-2 border rounded-lg">
        </div>

        <div>
            <label>Kurikulum</label>
            <select name="kurikulum" class="w-full mt-1 p-2 border rounded-lg">
                <option value="KTSP">KTSP</option>
                <option value="K13">K13</option>
                <option value="K13 Revisi">K13 Revisi</option>
                <option value="SKS">SKS</option>
                <option value="Lainnya">Lainnya</option>
            </select>
        </div>

    </div>
</div>

<!-- ========================= -->
<!-- DATA ORANG TUA -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold text-gray-600 mb-4">Data Orang Tua</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <input type="text" name="nama_ayah" placeholder="Nama Ayah" class="border p-2 rounded-lg">
        <input type="text" name="nama_ibu" placeholder="Nama Ibu" class="border p-2 rounded-lg">
        <input type="text" name="no_hp_ayah" placeholder="No HP Ayah" class="border p-2 rounded-lg">
        <input type="text" name="no_hp_ibu" placeholder="No HP Ibu" class="border p-2 rounded-lg">
        <input type="text" name="pekerjaan_ayah" placeholder="Pekerjaan Ayah" class="border p-2 rounded-lg">
        <input type="text" name="pekerjaan_ibu" placeholder="Pekerjaan Ibu" class="border p-2 rounded-lg">

    </div>
</div>

<!-- ========================= -->
<!-- DATA TAMBAHAN -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold text-gray-600 mb-4">Data Tambahan</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Tanggal Daftar</label>
            <input type="date" name="tanggal_daftar" class="w-full mt-1 p-2 border rounded-lg" required>
        </div>

        <div>
            <label>Status</label>
            <select name="status" class="w-full mt-1 p-2 border rounded-lg">
                <option value="Aktif">Aktif</option>
                <option value="Tidak Aktif">Tidak Aktif</option>
            </select>
        </div>

    </div>
</div>

<!-- ========================= -->
<!-- KELAS BIMBEL -->
<!-- ========================= -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <button type="button" onclick="toggleKelas()"
        class="w-full flex justify-between items-center">

        <h3 class="font-semibold text-gray-700">Kelas Bimbel</h3>
        <span id="iconKelas">⌄</span>
    </button>

    <div id="kelasBox" class="hidden mt-4">

        <div class="grid md:grid-cols-2 gap-3">
            @foreach($kelas as $kls)
                <label class="flex items-center gap-2 border p-3 rounded-lg cursor-pointer">
                    <input type="checkbox" name="kelas_id[]" value="{{ $kls->id }}">
                    <div>
                        <p>{{ $kls->nama_kelas }}</p>
                        <small>{{ $kls->program->nama_program ?? '-' }}</small>
                    </div>
                </label>
            @endforeach
        </div>

    </div>
</div>

<!-- BUTTON -->
<div class="flex justify-end gap-2">
    <a href="/admin/siswa" class="px-4 py-2 bg-gray-200 rounded-lg">
        Batal
    </a>

    <button type="submit"
        class="px-6 py-2 bg-orange-500 text-white rounded-lg">
        Simpan
    </button>
</div>

</form>

<script>
function toggleKelas() {
    document.getElementById('kelasBox').classList.toggle('hidden');
}
</script>

@endsection