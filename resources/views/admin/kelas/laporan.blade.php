@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-700">
        📄 Laporan Siswa - {{ $kelas->nama_kelas }}
    </h2>
    <p class="text-sm text-gray-500">
        Program: {{ $kelas->program->nama_program ?? '-' }}
    </p>
</div>

<div class="mb-4">
    <a href="/admin/kelas"
       class="bg-gray-200 px-4 py-2 rounded hover:bg-gray-300">
        ← Kembali
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="p-3 text-left">No</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left">Email</th>
            <th class="p-3 text-left">No HP</th>
            <th class="p-3 text-left">Asal Sekolah</th>
        </tr>
    </thead>

    <tbody>

        @forelse($kelas->siswa as $key => $siswa)
        <tr class="border-t hover:bg-gray-50">

            <td class="p-3">{{ $key + 1 }}</td>

            <td class="p-3 font-medium">
                {{ $siswa->nama }}
            </td>

            <td class="p-3">
                {{ $siswa->user->email ?? '-' }}
            </td>

            <td class="p-3">
                {{ $siswa->no_hp ?? '-' }}
            </td>

            <td class="p-3">
                {{ $siswa->asal_sekolah ?? '-' }}
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="5" class="text-center p-6 text-gray-500">
                Tidak ada siswa di kelas ini
            </td>
        </tr>
        @endforelse

    </tbody>

</table>

</div>

@endsection