@extends('layouts.siswa')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">

    {{-- ================= HEADER ================= --}}
<div class="relative overflow-hidden
            bg-gradient-to-r
            from-blue-600 via-indigo-500 to-blue-500
            rounded-[28px]
            px-6 py-5
            shadow-lg text-white">

    {{-- BACKGROUND ICON --}}
    <div class="absolute right-4 top-1/2
                -translate-y-1/2
                opacity-10 text-7xl">

        📚

    </div>

    {{-- CONTENT --}}
    <div class="relative z-10
                flex items-center gap-4">

        {{-- ICON --}}
        <div class="w-11 h-11 rounded-2xl
                    bg-white/20 backdrop-blur-md
                    flex items-center justify-center
                    text-xl">

            ✔

        </div>

        {{-- TEXT --}}
        <div>

            <p class="text-xs text-blue-100
                      uppercase tracking-wide">

                Riwayat Kehadiran Siswa

            </p>

            <h1 class="text-xl md:text-2xl
                       font-bold mt-1">

                Absensi Saya

            </h1>

            <p class="text-sm text-blue-100 mt-1">

                Pantau kehadiran dan aktivitas belajar

            </p>

        </div>

    </div>

</div>

    {{-- ================= STATISTIK ================= --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-5">

        {{-- HADIR --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Hadir
                    </p>

                    <h2 class="text-3xl font-bold text-green-600 mt-2">
                        {{ $hadir }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                    ✅
                </div>

            </div>

        </div>

        {{-- IZIN --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Izin
                    </p>

                    <h2 class="text-3xl font-bold text-yellow-600 mt-2">
                        {{ $izin }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-yellow-100 flex items-center justify-center text-2xl">
                    📝
                </div>

            </div>

        </div>

        {{-- SAKIT --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Sakit
                    </p>

                    <h2 class="text-3xl font-bold text-blue-600 mt-2">
                        {{ $sakit }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                    🤒
                </div>

            </div>

        </div>

        {{-- ALPHA --}}
        <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Alpha
                    </p>

                    <h2 class="text-3xl font-bold text-red-600 mt-2">
                        {{ $alpha }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-red-100 flex items-center justify-center text-2xl">
                    ❌
                </div>

            </div>

        </div>

    </div>

    {{-- ================= PROGRESS ================= --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between mb-4">

            <div>

                <h2 class="text-lg font-bold text-gray-800">
                    Progress Kehadiran
                </h2>

                <p class="text-sm text-gray-500">
                    Persentase kehadiran belajar kamu
                </p>

            </div>

            <div class="text-2xl font-bold text-green-600">
                {{ $persentase }}%
            </div>

        </div>

        <div class="w-full bg-gray-200 rounded-full h-3 overflow-hidden">

            <div class="bg-green-500 h-3 rounded-full transition-all duration-500"
                 style="width: {{ $persentase }}%">
            </div>

        </div>

        <div class="mt-3 text-sm text-gray-500">

            @if($persentase >= 80)

                Kehadiran kamu sangat baik 🎉

            @elseif($persentase >= 60)

                Tingkatkan lagi kehadiran kamu 💪

            @else

                Kehadiran kamu perlu diperbaiki ⚠️

            @endif

        </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

        <form method="GET"
              action="{{ route('siswa.absensi') }}">

            <div class="flex flex-col md:flex-row gap-4">

                {{-- BULAN --}}
                <select name="bulan"
                        class="border border-gray-200 rounded-2xl px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-200">

                    <option value="">
                        Semua Bulan
                    </option>

                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>

                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                        </option>
                    @endfor

                </select>

                {{-- TAHUN --}}
                <select name="tahun"
                        class="border border-gray-200 rounded-2xl px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-200">

                    <option value="">
                        Semua Tahun
                    </option>

                    @for($tahun = now()->year; $tahun >= now()->year - 3; $tahun--)
                        <option value="{{ $tahun }}"
                            {{ request('tahun') == $tahun ? 'selected' : '' }}>

                            {{ $tahun }}

                        </option>
                    @endfor

                </select>

                {{-- STATUS --}}
                <select name="status"
                        class="border border-gray-200 rounded-2xl px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-blue-200">

                    <option value="">
                        Semua Status
                    </option>

                    <option value="Hadir"
                        {{ request('status') == 'Hadir' ? 'selected' : '' }}>
                        Hadir
                    </option>

                    <option value="Izin"
                        {{ request('status') == 'Izin' ? 'selected' : '' }}>
                        Izin
                    </option>

                    <option value="Sakit"
                        {{ request('status') == 'Sakit' ? 'selected' : '' }}>
                        Sakit
                    </option>

                    <option value="Alpha"
                        {{ request('status') == 'Alpha' ? 'selected' : '' }}>
                        Alpha
                    </option>

                </select>

                <button
                    class="bg-blue-600 hover:bg-blue-700 transition
                        text-white px-6 py-3 rounded-2xl
                        text-sm font-semibold">

                    Filter

                </button>

            </div>

        </form>

    </div>

    {{-- ================= RIWAYAT ABSENSI ================= --}}
    <div class="space-y-4">

        @forelse($absensi as $a)

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                {{-- LEFT --}}
                <div class="flex gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl shrink-0">

                        📚

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-gray-800">

                            {{ $a->jadwal->mataPelajaran->nama_mapel }}

                        </h2>

                        <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500">

                            <span>
                                👨‍🏫
                                {{ $a->jadwal->tentor->nama }}
                            </span>

                            <span>
                                📅
                                {{ \Carbon\Carbon::parse($a->tanggal)->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                </div>

                {{-- STATUS --}}
                <div>

                    @if($a->status == 'Hadir')

                        <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full text-sm font-semibold">

                            ✅ Hadir

                        </span>

                    @elseif($a->status == 'Izin')

                        <span class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full text-sm font-semibold">

                            📝 Izin

                        </span>

                    @elseif($a->status == 'Sakit')

                        <span class="bg-blue-100 text-blue-700 px-5 py-2 rounded-full text-sm font-semibold">

                            🤒 Sakit

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-5 py-2 rounded-full text-sm font-semibold">

                            ❌ Alpha

                        </span>

                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="bg-white rounded-3xl p-14 shadow-sm border border-gray-100 text-center">

            <div class="text-6xl mb-4">
                📅
            </div>

            <h2 class="text-xl font-bold text-gray-700">
                Belum Ada Data Absensi
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Riwayat absensi kamu akan muncul di sini.
            </p>

        </div>

        @endforelse
        @if($absensi->hasPages())
            <div class="mt-6">
                {{ $absensi->links() }}
            </div>
        @endif
    </div>

</div>

@endsection