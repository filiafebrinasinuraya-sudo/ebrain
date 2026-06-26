@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-700">Edit Data Siswa</h2>

</div>

<form action="/admin/siswa/{{ $siswa->id }}" method="POST" class="space-y-6">
@csrf
@method('PUT')

<!-- DATA PRIBADI -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold mb-4">Data Pribadi</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Nama</label>
            <input type="text" name="nama"
                value="{{ old('nama', $siswa->nama) }}"
                class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label>No HP</label>
            <input type="text" name="no_hp"
                value="{{ old('no_hp', $siswa->no_hp) }}"
                class="w-full p-2 border rounded">
        </div>

        <div class="md:col-span-2">
            <label>Alamat</label>
            <textarea name="alamat"
                class="w-full p-2 border rounded">{{ old('alamat', $siswa->alamat) }}</textarea>
        </div>

        <!-- ✅ EMAIL DARI USER -->
        <div>
            <label>Email</label>
            <input type="email" name="email"
                value="{{ old('email', $siswa->user->email ?? '') }}"
                class="w-full p-2 border rounded" required>
        </div>

        <div>
            <label>Agama</label>
            <select name="agama" class="w-full p-2 border rounded">
                <option {{ $siswa->agama=='Islam'?'selected':'' }}>Islam</option>
                <option {{ $siswa->agama=='Kristen Protestan'?'selected':'' }}>Kristen Protestan</option>
                <option {{ $siswa->agama=='Katolik'?'selected':'' }}>Katolik</option>
                <option {{ $siswa->agama=='Hindu'?'selected':'' }}>Hindu</option>
                <option {{ $siswa->agama=='Budha'?'selected':'' }}>Budha</option>
                <option {{ $siswa->agama=='Konghucu'?'selected':'' }}>Konghucu</option>
            </select>
        </div>

        <div>
            <label>Jenis Kelamin</label>
            <select name="jenis_kelamin" class="w-full p-2 border rounded">
                <option {{ $siswa->jenis_kelamin=='Laki-laki'?'selected':'' }}>Laki-laki</option>
                <option {{ $siswa->jenis_kelamin=='Perempuan'?'selected':'' }}>Perempuan</option>
            </select>
        </div>

        <div>
            <label>Tempat Lahir</label>
            <input type="text" name="tempat_lahir"
                value="{{ old('tempat_lahir', $siswa->tempat_lahir) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Tanggal Lahir</label>
            <input type="date" name="tanggal_lahir"
                value="{{ old('tanggal_lahir', $siswa->tanggal_lahir ? $siswa->tanggal_lahir->format('Y-m-d') : '') }}"
                class="w-full p-2 border rounded">
        </div>

    </div>
</div>

<!-- DATA SEKOLAH -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold mb-4">Data Sekolah</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Asal Sekolah</label>
            <input type="text" name="asal_sekolah"
                value="{{ old('asal_sekolah', $siswa->asal_sekolah) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Kelas</label>
            <input type="text" name="kelas_sekolah"
                value="{{ old('kelas_sekolah', $siswa->kelas_sekolah) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Ranking</label>
            <input type="number" name="ranking"
                value="{{ old('ranking', $siswa->ranking) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Kurikulum</label>
            <select name="kurikulum" class="w-full p-2 border rounded">
                <option {{ $siswa->kurikulum=='KTSP'?'selected':'' }}>KTSP</option>
                <option {{ $siswa->kurikulum=='K13'?'selected':'' }}>K13</option>
                <option {{ $siswa->kurikulum=='K13 Revisi'?'selected':'' }}>K13 Revisi</option>
                <option {{ $siswa->kurikulum=='SKS'?'selected':'' }}>SKS</option>
                <option {{ $siswa->kurikulum=='Lainnya'?'selected':'' }}>Lainnya</option>
            </select>
        </div>

    </div>
</div>

<!-- ORANG TUA -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold mb-4">Data Orang Tua</h3>

    <div class="grid md:grid-cols-2 gap-4">

        <div>
            <label>Nama Ayah</label>
            <input type="text" name="nama_ayah"
                value="{{ old('nama_ayah', $siswa->nama_ayah) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Nama Ibu</label>
            <input type="text" name="nama_ibu"
                value="{{ old('nama_ibu', $siswa->nama_ibu) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>No HP Ayah</label>
            <input type="text" name="no_hp_ayah"
                value="{{ old('no_hp_ayah', $siswa->no_hp_ayah) }}"
                class="w-full p-2 border rounded">
        </div>

         <div>
            <label>No HP Ibu</label>
            <input type="text" name="no_hp_ibu"
                value="{{ old('no_hp_ibu', $siswa->no_hp_ibu) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Pekerjaan Ayah</label>
            <input type="text" name="pekerjaan_ayah"
                value="{{ old('pekerjaan_ayah', $siswa->pekerjaan_ayah) }}"
                class="w-full p-2 border rounded">
        </div>

        <div>
            <label>Pekerjaan Ibu</label>
            <input type="text" name="pekerjaan_ibu"
                value="{{ old('pekerjaan_ibu', $siswa->pekerjaan_ibu) }}"
                class="w-full p-2 border rounded">
        </div>

    </div>
</div>

<!-- DATA ADMIN -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold mb-4">Data Administrasi</h3>

    <div>
        <label>Tanggal Daftar</label>
        <input type="date" name="tanggal_daftar"
            value="{{ old('tanggal_daftar', $siswa->tanggal_daftar ? $siswa->tanggal_daftar->format('Y-m-d') : '') }}"
            class="w-full p-2 border rounded" required>
    </div>
</div>

<div class="mt-4">
    <label>Status Siswa</label>

    <select name="status" class="w-full p-2 border rounded">
        <option value="Aktif" {{ $siswa->status == 'Aktif' ? 'selected' : '' }}>
            Aktif
        </option>

        <option value="Tidak Aktif" {{ $siswa->status == 'Tidak Aktif' ? 'selected' : '' }}>
            Tidak Aktif
        </option>
    </select>
</div>

<!-- KELAS BIMBEL -->
<div class="bg-gray-50 p-5 rounded-xl border">
    <h3 class="font-semibold mb-4">Kelas Bimbel</h3>

    <div class="grid md:grid-cols-2 gap-3">

        @foreach($kelas as $kls)
            <label class="flex items-center gap-2 bg-white p-3 rounded-lg border hover:bg-blue-50 cursor-pointer">

                <input type="checkbox"
                    name="kelas_id[]"
                    value="{{ $kls->id }}"
                    {{ $siswa->kelas->contains($kls->id) ? 'checked' : '' }}>

                <div>
                    <p class="font-medium">{{ $kls->nama_kelas }}</p>
                    <p class="text-xs text-gray-500">
                        {{ $kls->program->nama_program ?? '-' }}
                    </p>
                </div>

            </label>
        @endforeach

    </div>
</div>

<!-- BUTTON -->
<div class="flex justify-end gap-2">
    <a href="/admin/siswa" class="px-4 py-2 bg-gray-200 rounded">Batal</a>

    <button class="px-6 py-2 bg-[#f97316] text-white rounded hover:bg-orange-600">
        Update
    </button>
</div>

</form>

@endsection