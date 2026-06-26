@extends('layouts.tentor')

@section('content')

<div class="space-y-5 max-w-5xl mx-auto">

    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-500
                rounded-2xl p-5 shadow text-white">

        <div class="flex flex-col lg:flex-row
                    lg:items-center lg:justify-between gap-4">

            <div>

                <p class="text-xs text-blue-100 tracking-wide">
                    Absensi Kelas
                </p>

                <h1 class="text-2xl font-bold mt-1">

                    {{ $jadwal->mataPelajaran->nama_mapel }}

                </h1>

                <div class="flex flex-wrap gap-2 mt-3 text-xs">

                    <span class="bg-white/15 px-3 py-1 rounded-xl">

                        📚 {{ $jadwal->kelas->nama_kelas }}

                    </span>

                    <span class="bg-white/15 px-3 py-1 rounded-xl">

                        🕒 {{ $jadwal->sesi->nama_sesi }}

                    </span>

                    <span class="bg-white/15 px-3 py-1 rounded-xl">

                        📍 {{ $jadwal->ruangan->nama_ruangan }}

                    </span>

                </div>

            </div>

            {{-- INFO TANGGAL --}}
            <div class="bg-white/15 rounded-xl px-4 py-3">

                <div class="text-xs text-blue-100">

                    Hari Ini

                </div>

                <div class="text-sm font-semibold mt-1">

                    {{ \Carbon\Carbon::parse($tanggal)->translatedFormat('d F Y') }}

                </div>

            </div>

        </div>

    </div>

    {{-- ================= ALERT ================= --}}
    @if($sudahAbsen)

    <div class="bg-yellow-50 border border-yellow-200
                text-yellow-700 rounded-2xl
                px-4 py-3 text-sm shadow-sm">

        Absensi pada tanggal ini sudah pernah diinput.
        Anda dapat memperbarui data absensi siswa.

    </div>

    @endif

    {{-- ================= FORM ================= --}}
    <form method="POST"
          action="{{ route('tentor.absensi.store', $jadwal->id) }}">

        @csrf

        {{-- ================= TANGGAL ================= --}}
        <div class="bg-white border border-gray-100
                    rounded-2xl p-4 shadow-sm mb-5">

            <div class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-4">

                <div>

                    <h3 class="font-semibold text-gray-800">

                        Tanggal Absensi

                    </h3>

                    <p class="text-sm text-gray-500 mt-1">

                        Pilih tanggal pertemuan kelas

                    </p>

                </div>

                <div>

                    <input type="date"
                           name="tanggal"
                           onchange="window.location.href='?tanggal=' + this.value"
                           value="{{ request('tanggal', now()->toDateString()) }}"
                           class="border border-gray-300
                                  rounded-xl px-4 py-2.5">

                </div>

            </div>

        </div>

        {{-- ================= LIST SISWA ================= --}}
        <div class="space-y-3">

            @foreach($siswa as $i => $s)

            @php
                $status = $absensiHariIni[$s->id]->status ?? 'Hadir';
            @endphp

            <div class="bg-white border border-gray-100
                        rounded-2xl px-4 py-4 shadow-sm">

                <div class="flex flex-col lg:flex-row
                            lg:items-center
                            lg:justify-between gap-4">

                    {{-- SISWA --}}
                    <div class="flex items-center gap-3">

                        {{-- AVATAR --}}
                        <div class="w-10 h-10 rounded-xl
                                    bg-blue-100 text-blue-600
                                    flex items-center justify-center
                                    text-sm font-bold">

                            {{ strtoupper(substr($s->nama, 0, 1)) }}

                        </div>

                        {{-- INFO --}}
                        <div>

                            <h3 class="font-semibold text-sm text-gray-800">

                                {{ $s->nama }}

                            </h3>

                            <p class="text-xs text-gray-500">

                                Siswa

                            </p>

                        </div>

                    </div>

                    {{-- STATUS --}}
                    <div>

                        <input type="hidden"
                               name="absensi[{{ $i }}][siswa_id]"
                               value="{{ $s->id }}">

                        <div class="flex flex-wrap gap-2">

                            {{-- HADIR --}}
                            <label class="cursor-pointer">

                                <input type="radio"
                                       name="absensi[{{ $i }}][status]"
                                       value="Hadir"
                                       class="hidden peer"
                                       {{ $status == 'Hadir' ? 'checked' : '' }}>

                                <div class="px-3 py-1.5 rounded-xl text-xs
                                            border border-green-200
                                            bg-green-50 text-green-700
                                            peer-checked:bg-green-600
                                            peer-checked:text-white
                                            font-medium transition-all">

                                    Hadir

                                </div>

                            </label>

                            {{-- IZIN --}}
                            <label class="cursor-pointer">

                                <input type="radio"
                                       name="absensi[{{ $i }}][status]"
                                       value="Izin"
                                       class="hidden peer"
                                       {{ $status == 'Izin' ? 'checked' : '' }}>

                                <div class="px-3 py-1.5 rounded-xl text-xs
                                            border border-yellow-200
                                            bg-yellow-50 text-yellow-700
                                            peer-checked:bg-yellow-500
                                            peer-checked:text-white
                                            font-medium transition-all">

                                    Izin

                                </div>

                            </label>

                            {{-- SAKIT --}}
                            <label class="cursor-pointer">

                                <input type="radio"
                                       name="absensi[{{ $i }}][status]"
                                       value="Sakit"
                                       class="hidden peer"
                                       {{ $status == 'Sakit' ? 'checked' : '' }}>

                                <div class="px-3 py-1.5 rounded-xl text-xs
                                            border border-blue-200
                                            bg-blue-50 text-blue-700
                                            peer-checked:bg-blue-600
                                            peer-checked:text-white
                                            font-medium transition-all">

                                    Sakit

                                </div>

                            </label>

                            {{-- ALPHA --}}
                            <label class="cursor-pointer">

                                <input type="radio"
                                       name="absensi[{{ $i }}][status]"
                                       value="Alpha"
                                       class="hidden peer"
                                       {{ $status == 'Alpha' ? 'checked' : '' }}>

                                <div class="px-3 py-1.5 rounded-xl text-xs
                                            border border-red-200
                                            bg-red-50 text-red-700
                                            peer-checked:bg-red-600
                                            peer-checked:text-white
                                            font-medium transition-all">

                                    Alpha

                                </div>

                            </label>

                        </div>

                    </div>

                </div>

            </div>

            @endforeach

        </div>

        {{-- ================= BUTTON ================= --}}
        <div class="mt-6 flex justify-end gap-3">

            {{-- KEMBALI --}}
            <a href="{{ route('tentor.jadwal') }}"
            class="bg-gray-100 hover:bg-gray-200
                    text-gray-700 px-6 py-3 rounded-xl
                    text-sm font-semibold
                    transition-all">

                ← Kembali

            </a>

            {{-- SIMPAN / UPDATE --}}
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700
                        text-white px-6 py-3 rounded-xl
                        text-sm font-semibold
                        shadow transition-all">

                {{ $sudahAbsen ? 'Update Absensi' : 'Simpan Absensi' }}

            </button>

        </div>

    </form>

</div>

@endsection