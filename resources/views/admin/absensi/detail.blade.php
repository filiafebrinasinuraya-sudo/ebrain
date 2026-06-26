@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-[28px]
                border border-gray-100
                shadow-sm p-6">

        <div class="flex flex-col lg:flex-row
                    lg:items-center
                    lg:justify-between gap-5">

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

                    <p class="text-sm text-gray-500">

                        Detail Absensi Kelas

                    </p>

                    <h1 class="text-2xl font-bold
                               text-gray-800 mt-1">

                        {{ $jadwal->kelas->nama_kelas }}

                    </h1>

                    <div class="flex flex-wrap gap-2 mt-3">

                        {{-- MAPEL --}}
                        <span class="bg-blue-100 text-blue-700
                                     px-3 py-1 rounded-full
                                     text-xs font-medium">

                            {{ $jadwal->mataPelajaran->nama_mapel }}

                        </span>

                        {{-- TENTOR --}}
                        <span class="bg-orange-100 text-orange-700
                                     px-3 py-1 rounded-full
                                     text-xs font-medium">

                            👨‍🏫 {{ $jadwal->tentor->nama }}

                        </span>

                        {{-- SESI --}}
                        <span class="bg-gray-100 text-gray-700
                                     px-3 py-1 rounded-full
                                     text-xs font-medium">

                            ⏰ {{ $jadwal->sesi->nama_sesi }}

                        </span>

                        {{-- TANGGAL --}}
                        <span class="bg-green-100 text-green-700
                                     px-3 py-1 rounded-full
                                     text-xs font-medium">

                            📅 {{ \Carbon\Carbon::parse($absensi->first()->tanggal)->translatedFormat('d F Y') }}

                        </span>

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div>

                <a href="{{ route('absensi.index') }}"
                   class="inline-flex items-center gap-2
                          bg-gray-100 hover:bg-gray-200
                          text-gray-700
                          px-5 py-3 rounded-2xl
                          text-sm font-medium transition">

                    ← Kembali

                </a>

            </div>

        </div>

    </div>

    {{-- ================= SUMMARY ================= --}}
    <div class="bg-white rounded-[28px]
                border border-gray-100
                shadow-sm p-5">

        <div class="flex flex-wrap gap-3">

            {{-- HADIR --}}
            <span class="bg-green-100 text-green-700
                         px-4 py-2 rounded-full
                         text-sm font-medium">

                ✔ Hadir : {{ $hadir }}

            </span>

            {{-- IZIN --}}
            <span class="bg-yellow-100 text-yellow-700
                         px-4 py-2 rounded-full
                         text-sm font-medium">

                🟡 Izin : {{ $izin }}

            </span>

            {{-- SAKIT --}}
            <span class="bg-blue-100 text-blue-700
                         px-4 py-2 rounded-full
                         text-sm font-medium">

                💊 Sakit : {{ $sakit }}

            </span>

            {{-- ALPHA --}}
            <span class="bg-red-100 text-red-700
                         px-4 py-2 rounded-full
                         text-sm font-medium">

                ✖ Alpha : {{ $alpha }}

            </span>

        </div>

    </div>

    {{-- ================= DAFTAR SISWA ================= --}}
    <div class="bg-white rounded-[28px]
                border border-gray-100
                shadow-sm overflow-hidden">

        {{-- TITLE --}}
        <div class="p-5 border-b border-gray-100">

            <div class="flex items-center justify-between">

                <div>

                    <h2 class="text-lg font-bold text-gray-800">

                        Daftar Kehadiran Siswa

                    </h2>

                    <p class="text-sm text-gray-500 mt-1">

                        Monitoring detail kehadiran siswa

                    </p>

                </div>

                <div class="bg-gray-100 text-gray-700
                            px-4 py-2 rounded-2xl
                            text-sm font-medium">

                    👥 {{ $absensi->count() }} siswa

                </div>

            </div>

        </div>

        {{-- LIST --}}
        <div class="divide-y divide-gray-100">

            @forelse($absensi as $item)

            <div class="flex flex-col md:flex-row
                        md:items-center
                        md:justify-between
                        gap-4 px-5 py-4
                        hover:bg-gray-50 transition">

                {{-- LEFT --}}
                <div class="flex items-center gap-4">

                    {{-- AVATAR --}}
                    <div class="w-11 h-11 rounded-2xl
                                bg-gradient-to-r
                                from-blue-500 to-indigo-500
                                text-white
                                flex items-center justify-center
                                text-sm font-bold shrink-0">

                        {{ strtoupper(substr($item->siswa->nama, 0, 1)) }}

                    </div>

                    {{-- INFO --}}
                    <div>

                        <h3 class="font-semibold text-gray-800">

                            {{ $item->siswa->nama }}

                        </h3>

                        <p class="text-xs text-gray-400 mt-1">

                            Siswa E-Brain

                        </p>

                    </div>

                </div>

                {{-- RIGHT --}}
                <div class="flex items-center gap-3">

                    {{-- STATUS --}}
                    @if($item->status == 'Hadir')

                        <span class="bg-green-100 text-green-700
                                     text-xs px-3 py-1 rounded-full font-medium">

                            ✔ Hadir

                        </span>

                    @elseif($item->status == 'Izin')

                        <span class="bg-yellow-100 text-yellow-700
                                     text-xs px-3 py-1 rounded-full font-medium">

                            🟡 Izin

                        </span>

                    @elseif($item->status == 'Sakit')

                        <span class="bg-blue-100 text-blue-700
                                     text-xs px-3 py-1 rounded-full font-medium">

                            💊 Sakit

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700
                                     text-xs px-3 py-1 rounded-full font-medium">

                            ✖ Alpha

                        </span>

                    @endif

                    {{-- EDIT --}}
                    <a href="{{ route('absensi.edit', $item->id) }}"
                       class="bg-blue-600 hover:bg-blue-700
                              text-white
                              text-xs px-4 py-2 rounded-xl
                              transition">

                        Edit

                    </a>

                </div>

            </div>

            @empty

            {{-- EMPTY --}}
            <div class="p-12 text-center">

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

    </div>

</div>

@endsection