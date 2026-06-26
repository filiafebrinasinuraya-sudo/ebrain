@extends('layouts.admin')

@section('content')

<div class="space-y-6 max-w-6xl mx-auto">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm p-6">

        <div class="flex flex-col lg:flex-row
                    lg:items-center
                    lg:justify-between gap-5">

            {{-- LEFT --}}
            <div class="flex items-center gap-4">

                {{-- AVATAR --}}
                <div class="w-16 h-16 rounded-3xl
                            bg-blue-100 text-blue-600
                            flex items-center justify-center
                            text-2xl font-bold shrink-0">

                    {{ strtoupper(substr($siswa->nama, 0, 1)) }}

                </div>

                {{-- INFO --}}
                <div>

                    <p class="text-sm text-gray-500">

                        Laporan Perkembangan Siswa

                    </p>

                    <h1 class="text-3xl font-bold
                               text-gray-800 mt-1">

                        {{ $siswa->nama }}

                    </h1>

                    <div class="flex flex-wrap gap-2 mt-3">

                        @foreach($siswa->kelas as $k)

                        <span class="bg-blue-50
                                     text-blue-700
                                     border border-blue-100
                                     px-3 py-1 rounded-xl
                                     text-xs font-medium">

                            {{ $k->nama_kelas }}

                        </span>

                        @endforeach

                    </div>

                </div>

            </div>

            {{-- BUTTON --}}
            <div class="flex items-center gap-3">

                {{-- PDF --}}
                <a href="{{ route('laporan.siswa.pdf', $siswa->id) }}?bulan={{ request('bulan') }}&kelas_id={{ request('kelas_id') }}"
                    class="bg-red-600 hover:bg-red-700 text-white px-5 py-3 rounded-2xl text-sm font-semibold transition-all">

                    Cetak PDF

                </a>

                {{-- KEMBALI --}}
                <a href="{{ route('laporan.siswa.index') }}"
                class="bg-gray-100 hover:bg-gray-200
                        text-gray-700 px-5 py-3
                        rounded-2xl text-sm
                        font-semibold transition-all">

                    ← Kembali

                </a>

            </div>

        </div>

    </div>

    {{-- ================= RINGKASAN ================= --}}
    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">

        {{-- HADIR --}}
        <div class="bg-green-50 border border-green-100
                    rounded-2xl p-4">

            <p class="text-xs text-green-600 font-medium">

                Hadir

            </p>

            <h2 class="text-2xl font-bold
                    text-green-700 mt-1">

                {{ $hadir }}

            </h2>

        </div>

        {{-- IZIN --}}
        <div class="bg-yellow-50 border border-yellow-100
                    rounded-2xl p-4">

            <p class="text-xs text-yellow-600 font-medium">

                Izin

            </p>

            <h2 class="text-2xl font-bold
                    text-yellow-700 mt-1">

                {{ $izin }}

            </h2>

        </div>

        {{-- SAKIT --}}
        <div class="bg-blue-50 border border-blue-100
                    rounded-2xl p-4">

            <p class="text-xs text-blue-600 font-medium">

                Sakit

            </p>

            <h2 class="text-2xl font-bold
                    text-blue-700 mt-1">

                {{ $sakit }}

            </h2>

        </div>

        {{-- ALPHA --}}
        <div class="bg-red-50 border border-red-100
                    rounded-2xl p-4">

            <p class="text-xs text-red-600 font-medium">

                Alpha

            </p>

            <h2 class="text-2xl font-bold
                    text-red-700 mt-1">

                {{ $alpha }}

            </h2>

        </div>

        {{-- RATA QUIZ --}}
        <div class="bg-purple-50 border border-purple-100
                    rounded-2xl p-4">

            <p class="text-xs text-purple-600 font-medium">

                Rata Quiz

            </p>

            <h2 class="text-2xl font-bold
                    text-purple-700 mt-1">

                {{ $rataQuiz ?? 0 }}

            </h2>

        </div>

        {{-- PERSENTASE KEHADIRAN --}}
        <div class="bg-indigo-50 border border-indigo-100
                    rounded-2xl p-4">

            <p class="text-xs text-indigo-600 font-medium">

                Kehadiran

            </p>

            <h2 class="text-2xl font-bold
                    text-indigo-700 mt-1">

                {{ $persentaseKehadiran }}%

            </h2>

        </div>

    </div>

    {{-- ================= TABLE LAPORAN ================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm overflow-hidden">

        {{-- HEADER TABLE --}}
        <div class="px-6 py-5 border-b border-gray-100">

            <div class="flex flex-col lg:flex-row
                        lg:items-center
                        lg:justify-between gap-4">

                {{-- TITLE --}}
                <div>

                    <h2 class="text-xl font-bold text-gray-800">

                        Histori Pertemuan

                    </h2>

                    <p class="text-sm text-gray-500 mt-1">

                        Kehadiran dan nilai quiz siswa

                    </p>

                </div>

                <form method="GET">

                    <div class="flex items-end gap-3 flex-wrap">

                        <div>

                            <label class="text-sm text-gray-600">
                                Kelas
                            </label>

                            <select
                                name="kelas_id"
                                class="mt-2 border border-gray-200 rounded-2xl px-4 py-2.5">

                                <option value="">
                                    Semua Kelas
                                </option>

                                @foreach($siswa->kelas as $k)

                                    <option
                                        value="{{ $k->id }}"
                                        {{ request('kelas_id') == $k->id ? 'selected' : '' }}>

                                        {{ $k->nama_kelas }}

                                    </option>

                                @endforeach

                            </select>

                        </div>

                        <div>

                            <label class="text-sm text-gray-600">
                                Bulan
                            </label>

                            <input
                                type="month"
                                name="bulan"
                                value="{{ request('bulan') }}"
                                class="mt-2 border border-gray-200 rounded-2xl px-4 py-2.5">

                        </div>

                        <button
                            class="bg-blue-600 hover:bg-blue-700
                                text-white px-5 py-2.5
                                rounded-2xl text-sm
                                font-semibold transition">

                            Filter

                        </button>

                    </div>

                </form>

            </div>

        </div>

        {{-- TABLE --}}
        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left
                                   font-semibold text-gray-600">

                            Tanggal

                        </th>

                        <th class="px-6 py-4 text-left
                                font-semibold text-gray-600">

                            Sesi

                        </th>

                        <th class="px-6 py-4 text-left
                                   font-semibold text-gray-600">

                            Kehadiran

                        </th>

                        <th class="px-6 py-4 text-left
                                   font-semibold text-gray-600">

                            Nilai Quiz

                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($laporan as $item)

                    <tr class="border-t border-gray-100
                               hover:bg-gray-50 transition">

                        {{-- TANGGAL --}}
                        <td class="px-6 py-5 text-gray-700">

                            {{ \Carbon\Carbon::parse($item['tanggal'])->translatedFormat('d F Y') }}

                        </td>

                        <td class="px-6 py-5 text-gray-700">

                            {{ $item['sesi'] }}

                        </td>

                        {{-- STATUS --}}
                        <td class="px-6 py-5">

                            @if($item['status'] == 'Hadir')

                                <span class="bg-green-100 text-green-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Hadir

                                </span>

                            @elseif($item['status'] == 'Izin')

                                <span class="bg-yellow-100 text-yellow-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Izin

                                </span>

                            @elseif($item['status'] == 'Sakit')

                                <span class="bg-blue-100 text-blue-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Sakit

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Alpha

                                </span>

                            @endif

                        </td>

                        {{-- NILAI --}}
                        <td class="px-6 py-5">

                            <span class="bg-purple-100 text-purple-700
                                         px-3 py-1 rounded-xl
                                         text-xs font-semibold">

                                {{ $item['nilai'] }}

                            </span>

                        </td>

                    </tr>

                    @empty

                    {{-- EMPTY --}}
                    <tr>

                        <td colspan="3"
                            class="py-16 text-center">

                            <div class="text-6xl mb-4">

                                📘

                            </div>

                            <h2 class="text-xl font-bold
                                       text-gray-700">

                                Belum Ada Laporan

                            </h2>

                            <p class="text-gray-500 mt-2">

                                Data absensi dan quiz akan tampil di sini.

                            </p>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection