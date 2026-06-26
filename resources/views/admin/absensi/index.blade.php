@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="relative overflow-hidden
                bg-gradient-to-r
                from-blue-600 via-indigo-500 to-blue-500
                rounded-[28px]
                px-6 py-5
                shadow-lg text-white">

        {{-- BG ICON --}}
        <div class="absolute right-4 top-1/2
                    -translate-y-1/2
                    opacity-10 text-7xl">

            📚

        </div>

        {{-- CONTENT --}}
        <div class="relative z-10 flex items-center gap-4">

            {{-- ICON --}}
            <div class="w-11 h-11 rounded-2xl
                        bg-white/20 backdrop-blur-md
                        flex items-center justify-center
                        text-xl">

                ✔

            </div>

            {{-- TEXT --}}
            <div>

                <h1 class="text-xl md:text-2xl
                           font-bold mt-1">

                    Monitoring Absensi Siswa

            </div>

        </div>

    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-5 gap-4">

        {{-- HADIR --}}
        <div class="bg-white rounded-[24px]
                    border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Hadir
                    </p>

                    <h2 class="text-3xl font-bold
                               text-gray-800 mt-2">

                        {{ $absensi->where('status', 'Hadir')->count() }}

                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl
                            bg-green-100 text-green-600
                            flex items-center justify-center">

                    ✔

                </div>

            </div>

        </div>

        {{-- IZIN --}}
        <div class="bg-white rounded-[24px]
                    border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Izin
                    </p>

                    <h2 class="text-3xl font-bold
                               text-gray-800 mt-2">

                        {{ $absensi->where('status', 'Izin')->count() }}

                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl
                            bg-yellow-100 text-yellow-600
                            flex items-center justify-center">

                    🟡

                </div>

            </div>

        </div>

        {{-- SAKIT --}}
        <div class="bg-white rounded-[24px]
                    border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Sakit
                    </p>

                    <h2 class="text-3xl font-bold
                               text-gray-800 mt-2">

                        {{ $absensi->where('status', 'Sakit')->count() }}

                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl
                            bg-blue-100 text-blue-600
                            flex items-center justify-center">

                    💊

                </div>

            </div>

        </div>

        {{-- ALPHA --}}
        <div class="bg-white rounded-[24px]
                    border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Alpha
                    </p>

                    <h2 class="text-3xl font-bold
                               text-gray-800 mt-2">

                        {{ $absensi->where('status', 'Alpha')->count() }}

                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl
                            bg-red-100 text-red-600
                            flex items-center justify-center">

                    ✖

                </div>

            </div>

        </div>

        {{-- TOTAL --}}
        <div class="bg-white rounded-[24px]
                    border border-gray-100
                    shadow-sm p-5">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">
                        Total
                    </p>

                    <h2 class="text-3xl font-bold
                               text-gray-800 mt-2">

                        {{ $absensi->count() }}

                    </h2>

                </div>

                <div class="w-12 h-12 rounded-2xl
                            bg-gray-100 text-gray-600
                            flex items-center justify-center">

                    📋

                </div>

            </div>

        </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <div class="bg-white rounded-[28px]
                border border-gray-100
                shadow-sm p-5">

        <form method="GET"
              action="{{ route('absensi.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                {{-- TANGGAL --}}
                <div>

                    <label class="text-sm text-gray-600 mb-2 block">

                        Tanggal

                    </label>

                    <input type="date"
                           name="tanggal"
                           value="{{ request('tanggal') }}"
                           class="w-full border border-gray-200
                                  rounded-2xl px-4 py-2.5 text-sm">

                </div>

                {{-- KELAS --}}
                <div>

                    <label class="text-sm text-gray-600 mb-2 block">

                        Kelas

                    </label>

                    <select name="kelas_id"
                            class="w-full border border-gray-200
                                   rounded-2xl px-4 py-2.5 text-sm">

                        <option value="">
                            Semua Kelas
                        </option>

                        @foreach($kelas as $k)

                        <option value="{{ $k->id }}"
                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>

                            {{ $k->nama_kelas }}

                        </option>

                        @endforeach

                    </select>

                </div>

                {{-- STATUS --}}
                <div>

                    <label class="text-sm text-gray-600 mb-2 block">

                        Status

                    </label>

                    <select name="status"
                            class="w-full border border-gray-200
                                   rounded-2xl px-4 py-2.5 text-sm">

                        <option value="">
                            Semua Status
                        </option>

                        <option value="Hadir">Hadir</option>
                        <option value="Izin">Izin</option>
                        <option value="Sakit">Sakit</option>
                        <option value="Alpha">Alpha</option>

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="flex items-end">

                    <button class="w-full bg-blue-600
                                   hover:bg-blue-700
                                   text-white rounded-2xl
                                   px-5 py-2.5 text-sm transition">

                        Filter Data

                    </button>

                </div>

            </div>

        </form>

    </div>

        {{-- ================= CARD KELAS ================= --}}
        <div class="grid lg:grid-cols-2 gap-5">

            @forelse($groupedAbsensi as $group)

            <div class="bg-white rounded-[28px]
                        border border-gray-100
                        shadow-sm overflow-hidden
                        hover:shadow-md transition">

                {{-- TOP --}}
                <div class="p-5">

                    <div class="flex items-start justify-between gap-4">

                        {{-- LEFT --}}
                        <div class="flex items-start gap-4">

                            {{-- ICON --}}
                            <div class="w-14 h-14 rounded-2xl
                                        bg-blue-100 text-blue-600
                                        flex items-center justify-center
                                        text-2xl shrink-0">

                                📚

                            </div>

                            {{-- INFO --}}
                            <div>

                                <h2 class="text-lg font-bold text-gray-800">

                                    {{ $group['kelas'] }}

                                </h2>

                                <div class="flex flex-wrap gap-2 mt-3">

                                    <span class="bg-blue-100 text-blue-700
                                                px-3 py-1 rounded-full
                                                text-xs font-medium">

                                        {{ $group['mapel'] }}

                                    </span>

                                    <span class="bg-orange-100 text-orange-700
                                                px-3 py-1 rounded-full
                                                text-xs font-medium">

                                        👨‍🏫 {{ $group['tentor'] }}

                                    </span>

                                    <span class="bg-gray-100 text-gray-700
                                                px-3 py-1 rounded-full
                                                text-xs font-medium">

                                        ⏰ {{ $group['sesi'] }}

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- TOTAL --}}
                        <div class="bg-gray-100
                                    rounded-2xl px-4 py-3
                                    text-center min-w-[90px]">

                            <p class="text-xs text-gray-500">

                                Siswa

                            </p>

                            <h2 class="text-xl font-bold
                                    text-gray-800 mt-1">

                                {{ count($group['siswa']) }}

                            </h2>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div class="grid grid-cols-4 gap-3 mt-5">

                        <div class="bg-green-50 rounded-2xl p-3 text-center">

                            <div class="text-xs text-green-600">

                                Hadir

                            </div>

                            <div class="font-bold text-green-700 mt-1">

                                {{ $group['hadir'] }}

                            </div>

                        </div>

                        <div class="bg-yellow-50 rounded-2xl p-3 text-center">

                            <div class="text-xs text-yellow-600">

                                Izin

                            </div>

                            <div class="font-bold text-yellow-700 mt-1">

                                {{ $group['izin'] }}

                            </div>

                        </div>

                        <div class="bg-blue-50 rounded-2xl p-3 text-center">

                            <div class="text-xs text-blue-600">

                                Sakit

                            </div>

                            <div class="font-bold text-blue-700 mt-1">

                                {{ $group['sakit'] }}

                            </div>

                        </div>

                        <div class="bg-red-50 rounded-2xl p-3 text-center">

                            <div class="text-xs text-red-600">

                                Alpha

                            </div>

                            <div class="font-bold text-red-700 mt-1">

                                {{ $group['alpha'] }}

                            </div>

                        </div>

                    </div>

                </div>

                {{-- FOOTER --}}
                <div class="border-t border-gray-100 p-5">

                    <div class="grid grid-cols-2 gap-3">

                        <a href="{{ route('absensi.detail', $group['jadwal_id']) }}"
                        class="text-center
                            bg-blue-600 hover:bg-blue-700
                            text-white rounded-xl
                            py-2 text-sm font-medium transition">

                            Detail

                        </a>

                        <form
                            action="{{ route('absensi.destroy', $group['jadwal_id']) }}"
                            method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus data absensi ini?')">

                            @csrf
                            @method('DELETE')

                            <button
                                type="submit"
                                class="w-full
                                    bg-red-600 hover:bg-red-700
                                    text-white rounded-xl
                                    py-2 text-sm font-medium transition">

                                Hapus

                            </button>

                        </form>

                    </div>

                </div>

            </div>

            @empty

            {{-- EMPTY --}}
            <div class="col-span-full
                        bg-white rounded-[28px]
                        border border-gray-100
                        p-12 text-center">

                <div class="text-6xl mb-4">

                    📅

                </div>

                <h2 class="text-xl font-bold text-gray-700">

                    Belum Ada Data Absensi

                </h2>

                <p class="text-gray-500 mt-2">

                    Data absensi akan muncul di sini

                </p>

            </div>

            @endforelse

        </div>

     
        {{-- EMPTY --}}
        <div class="bg-white rounded-[28px]
                    border border-gray-100
                    p-12 text-center">

            <div class="text-6xl mb-4">
                📅
            </div>

            <h2 class="text-xl font-bold text-gray-700">

                Belum Ada Data Absensi

            </h2>

            <p class="text-gray-500 mt-2">

                Data absensi akan muncul di sini

            </p>

        </div>

    </div>

</div>

@endsection