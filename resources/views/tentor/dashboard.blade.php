@extends('layouts.tentor')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-500
                rounded-3xl p-6 shadow-lg text-white">

        <div class="flex flex-col lg:flex-row
                    lg:items-center lg:justify-between gap-6">

            {{-- LEFT --}}
            <div>

                <p class="text-sm text-blue-100 tracking-wide">

                    Dashboard Tentor

                </p>

                <h1 class="text-3xl font-bold mt-2">

                    Halo, {{ auth()->user()->name }} 👋

                </h1>

                <p class="text-sm text-blue-100 mt-2">

                    Selamat datang kembali di sistem akademik E-Brain

                </p>

            </div>

            {{-- RIGHT --}}
            @if($periodeAktif)

                <div class="bg-white/15 backdrop-blur-md
                            rounded-3xl px-6 py-5">

                    <div class="text-sm text-blue-100">

                        Periode Aktif

                    </div>

                    <div class="text-lg font-bold mt-2">

                        {{ $periodeAktif->tahun_ajaran }}

                    </div>

                    <div class="text-sm text-blue-100 mt-1">

                        {{ $periodeAktif->semester }}

                    </div>

                </div>

            @endif

        </div>

    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">

        {{-- TOTAL JADWAL --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">

                        Total Jadwal

                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">

                        {{ $totalJadwal }}

                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl
                            bg-blue-100 text-blue-600
                            flex items-center justify-center text-2xl">

                    📅

                </div>

            </div>

        </div>

        {{-- JADWAL HARI INI --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">

                        Jadwal Hari Ini

                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">

                        {{ $jadwalHariIni }}

                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl
                            bg-orange-100 text-orange-600
                            flex items-center justify-center text-2xl">

                    ⏰

                </div>

            </div>

        </div>

        {{-- TOTAL KELAS --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-500">

                        Total Kelas

                    </p>

                    <h2 class="text-3xl font-bold text-gray-800 mt-2">

                        {{ $totalKelas }}

                    </h2>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= JADWAL HARI INI ================= --}}
    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

        <div class="flex items-center justify-between mb-6">

            <div>

                <h2 class="text-xl font-bold text-gray-800">

                    Jadwal Hari Ini

                </h2>

                <p class="text-sm text-gray-500 mt-1">

                    Jadwal mengajar hari
                    {{ now()->locale('id')->dayName }}

                </p>

            </div>

            <a href="{{ route('tentor.jadwal') }}"
               class="text-sm text-blue-600 hover:text-blue-700 font-semibold">

                Lihat Semua →

            </a>

        </div>

        {{-- LIST --}}
        <div class="space-y-4">

            @forelse($jadwalToday as $j)

                <div class="border border-gray-100 rounded-3xl p-5
                            hover:shadow-lg hover:-translate-y-1
                            transition-all duration-300">

                    <div class="flex flex-col lg:flex-row
                                lg:items-center lg:justify-between gap-5">

                        {{-- LEFT --}}
                        <div class="flex items-start gap-4">

                            {{-- JAM --}}
                            <div class="bg-blue-50 text-blue-700
                                        rounded-2xl px-4 py-3
                                        min-w-[110px] text-center">

                                <div class="text-xs font-medium">

                                    {{ $j->sesi->nama_sesi }}

                                </div>

                                <div class="text-sm font-bold mt-2">

                                    {{ \Carbon\Carbon::parse($j->sesi->jam_mulai)->format('H:i') }}
                                    -
                                    {{ \Carbon\Carbon::parse($j->sesi->jam_selesai)->format('H:i') }}

                                </div>

                            </div>

                            {{-- DETAIL --}}
                            <div>

                                <h3 class="text-lg font-bold text-gray-800">

                                    {{ $j->mataPelajaran->nama_mapel }}

                                </h3>

                                <div class="flex flex-wrap gap-2 mt-3">

                                    <span class="bg-blue-100 text-blue-700
                                                 text-xs px-3 py-1 rounded-full font-medium">

                                        👨‍🎓 {{ $j->kelas->nama_kelas }}

                                    </span>

                                    <span class="bg-orange-100 text-orange-700
                                                 text-xs px-3 py-1 rounded-full font-medium">

                                        🏫 {{ $j->ruangan->nama_ruangan }}

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            @empty

                <div class="border border-dashed border-gray-300
                            rounded-3xl p-10 text-center">

                    <div class="text-5xl mb-4">

                        📅

                    </div>

                    <h2 class="text-xl font-bold text-gray-700">

                        Tidak Ada Jadwal Hari Ini

                    </h2>

                    <p class="text-gray-500 mt-2">

                        Tidak ada jadwal mengajar hari ini.

                    </p>

                </div>

            @endforelse

        </div>

    </div>

</div>

@endsection