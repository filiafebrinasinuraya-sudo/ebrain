@extends('layouts.admin')

@section('content')

<div class="p-6 space-y-6">

    <!-- HEADER -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between">
        <div>
            <h1 class="text-2xl font-bold text-gray-800">Dashboard Admin</h1>
            <p class="text-gray-500 text-sm">
                Sistem Informasi Manajemen Sekolah Bimbel E-Brain
            </p>
        </div>

        <div class="mt-3 md:mt-0 text-sm text-gray-600">
            👋 Selamat datang, <span class="font-semibold">{{ auth()->user()->name }}</span>
        </div>
    </div>

    <!-- STATISTIK CARDS -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5">

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">
                Total Siswa
            </p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $totalSiswa ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">
                Total Tentor
            </p>

            <h2 class="text-3xl font-bold text-purple-600 mt-2">
                {{ $totalGuru ?? 0 }}
            </h2>
        </div>

        <div class="bg-white p-5 rounded-2xl shadow-sm border border-gray-100">
            <p class="text-gray-500 text-sm">
                Total Kelas
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $totalKelas ?? 0 }}
            </h2>
        </div>

    </div>


    <!-- SISWA TERBARU -->
    <div class="bg-white rounded-xl shadow border p-5">

        <div class="flex justify-between items-center mb-4">
            <h2 class="text-lg font-semibold text-gray-700">
                Siswa Terbaru
            </h2>
        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-100 text-gray-600">
                    <tr>
                        <th class="p-3 text-left">Nama</th>
                        <th class="p-3 text-left">Sekolah</th>
                        <th class="p-3 text-left">Tanggal Daftar</th>
                        <th class="p-3 text-left">Status</th>
                    </tr>
                </thead>

                <tbody>

                @forelse($siswaTerbaru ?? [] as $s)
                <tr class="border-t hover:bg-gray-50">

                    <td class="p-3 font-medium">
                        {{ $s->nama }}
                    </td>

                    <td class="p-3 text-gray-600">
                        {{ $s->asal_sekolah }}
                    </td>

                    <td class="p-3 text-gray-500">
                        {{ $s->tanggal_daftar?->format('d M Y') }}
                    </td>

                    <td class="p-3">
                        <span class="px-2 py-1 text-xs rounded-full 
                        {{ $s->status == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                            {{ $s->status }}
                        </span>
                    </td>

                </tr>
                @empty
                <tr>
                    <td colspan="4" class="p-4 text-center text-gray-400">
                        Belum ada data siswa
                    </td>
                </tr>
                @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection