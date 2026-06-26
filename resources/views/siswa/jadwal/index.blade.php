@extends('layouts.siswa')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
<div class="bg-gradient-to-r
            from-blue-600 to-blue-500
            rounded-[28px]
            px-6 py-5
            shadow-lg text-white relative overflow-hidden">

    {{-- BACKGROUND ICON --}}
    <div class="absolute right-4 top-1/2
                -translate-y-1/2
                opacity-10 text-7xl">

        📚

    </div>

    <div class="relative z-10
                flex items-center gap-4">

        {{-- ICON --}}
        <div class="w-11 h-11 rounded-2xl
                    bg-white/20 backdrop-blur-md
                    flex items-center justify-center
                    text-xl">

            📅

        </div>

        {{-- TEXT --}}
        <div>

            <p class="text-xs text-blue-100 uppercase tracking-wide">

                E-Brain Siswa

            </p>

            <h1 class="text-xl md:text-2xl font-bold mt-1">

                Jadwal Belajar

            </h1>

            <p class="text-sm text-blue-100 mt-1">

                Jadwal berdasarkan periode aktif

            </p>

        </div>

    </div>

</div>

    {{-- PERIODE --}}
    @if($periodeAktif)

    <div class="bg-white border border-blue-100 rounded-2xl p-5 shadow-sm">

        <div class="flex items-center gap-3">

            <div class="w-12 h-12 rounded-2xl
                        bg-blue-100 text-blue-600
                        flex items-center justify-center text-xl">

                📅

            </div>

            <div>

                <div class="text-sm text-gray-500">

                    Periode Aktif

                </div>

                <div class="font-bold text-gray-800">

                    {{ $periodeAktif->tahun_ajaran }}
                    -
                    Semester {{ $periodeAktif->semester }}

                </div>

                <div class="text-sm text-gray-500 mt-1">

                    {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }}
                    -
                    {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}

                </div>

            </div>

        </div>

    </div>

    @endif

    {{-- GROUP HARI --}}
    @php
        $grouped = $jadwal->groupBy('hari');
    @endphp

    <div class="space-y-8">

        @forelse($grouped as $hari => $items)

        <div>

            {{-- HARI --}}
            <div class="flex items-center gap-3 mb-4">

                <div class="w-3 h-3 rounded-full bg-orange-500"></div>

                <h2 class="text-xl font-bold text-gray-800">

                    {{ $hari }}

                </h2>

                <div class="flex-1 h-[1px] bg-gray-200"></div>

            </div>

            {{-- TIMELINE --}}
            <div class="relative pl-5 border-l-2 border-blue-100 space-y-5">

                @foreach($items as $j)

                <div class="relative">

                    {{-- DOT --}}
                    <div class="absolute -left-[30px] top-7
                                w-4 h-4 rounded-full
                                bg-blue-500 border-4 border-white shadow">
                    </div>

                    {{-- CARD --}}
                    <div class="bg-white border border-gray-100
                                rounded-3xl p-5 shadow-sm
                                hover:shadow-lg transition-all duration-300">

                        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                            {{-- LEFT --}}
                            <div class="flex items-start gap-4">

                                {{-- JAM --}}
                                <div class="bg-blue-50 text-blue-700
                                            rounded-2xl px-4 py-3
                                            text-center min-w-[95px]">

                                    <div class="text-xs font-medium">

                                        {{ $j->sesi->nama_sesi ?? '-' }}

                                    </div>

                                    <div class="text-xl font-bold mt-1">

                                        {{ \Carbon\Carbon::parse($j->sesi->jam_mulai)->format('H:i') }}

                                    </div>

                                </div>

                                {{-- DETAIL --}}
                                <div>

                                    <h3 class="text-lg font-bold text-gray-800">

                                        {{ $j->mataPelajaran->nama_mapel ?? '-' }}

                                    </h3>

                                    <div class="flex flex-wrap gap-2 mt-3">

                                        <span class="bg-blue-100 text-blue-700
                                                    text-xs px-3 py-1 rounded-full font-medium">

                                            {{ $j->kelas->nama_kelas ?? '-' }}

                                        </span>

                                    </div>

                                    <div class="flex flex-wrap gap-4 mt-4 text-sm text-gray-500">

                                        <div class="flex items-center gap-2">

                                            👨
                                            {{ $j->tentor->nama ?? '-' }}

                                        </div>

                                        <div class="flex items-center gap-2">

                                            📍
                                            {{ $j->ruangan->nama_ruangan ?? '-' }}

                                        </div>

                                    </div>

                                </div>

                            </div>

                            {{-- STATUS --}}
                            <div>

                                <span class="bg-orange-500 text-white
                                             text-xs px-4 py-2 rounded-xl font-semibold">

                                    Belajar

                                </span>

                            </div>

                        </div>

                    </div>

                </div>

                @endforeach

            </div>

        </div>

        @empty

        <div class="bg-white border border-dashed border-gray-300
                    rounded-3xl p-14 text-center">

            <div class="text-6xl mb-4">
                📅
            </div>

            <h2 class="text-2xl font-bold text-gray-700">

                Belum Ada Jadwal

            </h2>

            <p class="text-gray-500 mt-2">

                Jadwal belajar belum tersedia pada periode aktif.

            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection