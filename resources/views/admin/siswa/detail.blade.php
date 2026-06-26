@extends('layouts.admin')

@section('content')

<!-- HEADER -->
<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-2xl font-bold text-gray-800">Detail Siswa</h2>
        <p class="text-sm text-gray-500">Informasi lengkap data siswa</p>
    </div>

    <a href="/admin/siswa"
       class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
        ← Kembali
    </a>
</div>

<!-- ========================= -->
<!-- CARD IDENTITAS UTAMA -->
<!-- ========================= -->
<div class="bg-white shadow rounded-xl p-6 mb-6">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between">

        <div>
            <h3 class="text-xl font-bold text-gray-800">
                {{ $siswa->nama }}
            </h3>

            <p class="text-gray-500 text-sm">
                {{ $siswa->tempat_lahir }}, {{ $siswa->tanggal_lahir?->format('d M Y') }}
            </p>
        </div>

        <div class="mt-3 md:mt-0">
            <span class="px-3 py-1 text-sm rounded-full 
                {{ $siswa->status == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $siswa->status }}
            </span>
        </div>

    </div>

</div>

<!-- ========================= -->
<!-- GRID DATA -->
<!-- ========================= -->
<div class="grid md:grid-cols-2 gap-6">

    <!-- BIODATA -->
    <div class="bg-white shadow rounded-xl p-5">
        <h3 class="font-semibold text-gray-700 mb-4">👤 Biodata</h3>

        <div class="space-y-2 text-sm">

            <p><b>Email:</b> {{ $siswa->user->email ?? '-' }}</p>
            <p><b>No HP:</b> {{ $siswa->no_hp ?? '-' }}</p>
            <p><b>Agama:</b> {{ $siswa->agama ?? '-' }}</p>
            <p><b>Jenis Kelamin:</b> {{ $siswa->jenis_kelamin ?? '-' }}</p>
            <p><b>Alamat:</b> {{ $siswa->alamat ?? '-' }}</p>

        </div>
    </div>

    <!-- SEKOLAH -->
    <div class="bg-white shadow rounded-xl p-5">
        <h3 class="font-semibold text-gray-700 mb-4">🏫 Data Sekolah</h3>

        <div class="space-y-2 text-sm">

            <p><b>Asal Sekolah:</b> {{ $siswa->asal_sekolah ?? '-' }}</p>
            <p><b>Kelas Sekolah:</b> {{ $siswa->kelas_sekolah ?? '-' }}</p>
            <p><b>Ranking:</b> {{ $siswa->ranking ?? '-' }}</p>
            <p><b>Kurikulum:</b> {{ $siswa->kurikulum ?? '-' }}</p>

        </div>
    </div>

    <!-- ORANG TUA -->
    <div class="bg-white shadow rounded-xl p-5">
        <h3 class="font-semibold text-gray-700 mb-4">👨‍👩‍👧 Orang Tua</h3>

        <div class="space-y-2 text-sm">

            <p><b>Nama Ayah:</b> {{ $siswa->nama_ayah ?? '-' }}</p>
            <p><b>Pekerjaan Ayah:</b> {{ $siswa->pekerjaan_ayah ?? '-' }}</p>
            <p><b>No HP Ayah:</b> {{ $siswa->no_hp_ayah ?? '-' }}</p>

            <hr class="my-2">

            <p><b>Nama Ibu:</b> {{ $siswa->nama_ibu ?? '-' }}</p>
            <p><b>Pekerjaan Ibu:</b> {{ $siswa->pekerjaan_ibu ?? '-' }}</p>
            <p><b>No HP Ibu:</b> {{ $siswa->no_hp_ibu ?? '-' }}</p>

        </div>
    </div>

    <!-- ADMINISTRASI -->
    <div class="bg-white shadow rounded-xl p-5">
        <h3 class="font-semibold text-gray-700 mb-4">📌 Administrasi</h3>

        <div class="space-y-2 text-sm">

            <p><b>Tanggal Daftar:</b> {{ $siswa->tanggal_daftar?->format('d M Y') }}</p>

            <p><b>Kelas E-Brain:</b></p>

            @if($siswa->kelas && $siswa->kelas->count())
                <div class="flex flex-wrap gap-2 mt-1">
                    @foreach($siswa->kelas as $k)
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded">
                            {{ $k->nama_kelas }}
                        </span>
                    @endforeach
                </div>
            @else
                <span class="text-gray-400 text-sm">Belum di-assign</span>
            @endif

        </div>
    </div>

</div>

@endsection