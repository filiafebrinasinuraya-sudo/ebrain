@extends('layouts.admin')

@section('content')

<div class="bg-white min-h-screen p-4 space-y-4">

    {{-- ================= ALERT ================= --}}
    @if(!$periodeAktif)

        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl">

            Belum ada periode aktif.
            Silakan aktifkan periode terlebih dahulu.

        </div>

    @endif

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        {{-- LEFT --}}
        <div>

            <h1 class="text-2xl font-bold text-gray-800">

                📅 Matrix Jadwal Akademik

            </h1>

            <p class="text-sm text-gray-500 mt-1">

                Jadwal belajar Bimbingan Excellent Brain (E-Brain)

            </p>

            @if($periodeAktif)

                <div class="mt-3 flex flex-wrap items-center gap-2">

                    {{-- PERIODE --}}
                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                        Periode Aktif

                    </span>

                    {{-- TAHUN --}}
                    <span class="bg-blue-100 text-blue-700 px-3 py-1 rounded-full text-xs">

                        {{ $periodeAktif->tahun_ajaran }}
                        •
                        {{ $periodeAktif->semester }}

                    </span>

                    {{-- TANGGAL --}}
                    <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">

                        {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}

                    </span>

                </div>

            @endif

            {{-- STATS --}}
            <div class="mt-3 flex flex-wrap gap-2">

                <span class="bg-indigo-100 text-indigo-700 px-3 py-1 rounded-full text-xs font-semibold">

                    {{ $jadwal->count() }} Jadwal

                </span>

                <span class="bg-gray-100 text-gray-700 px-3 py-1 rounded-full text-xs">

                    {{ $ruangan->count() }} Ruangan

                </span>

                <span class="bg-yellow-100 text-yellow-700 px-3 py-1 rounded-full text-xs">

                    {{ $sesi->count() }} Sesi

                </span>

            </div>

        </div>

        {{-- RIGHT --}}
        <div class="flex flex-wrap gap-2">

            {{-- CETAK PDF --}}
            <a href="{{ route('admin.jadwal.export-pdf') }}"
                target="_blank"
                class="px-4 py-2 text-sm rounded-xl bg-red-500 text-white hover:bg-red-600 transition shadow-sm">
                    Cetak PDF
            </a>

            {{-- LIST --}}
            <a href="{{ route('jadwal.index') }}"
               class="px-4 py-2 text-sm rounded-xl border border-gray-300 text-gray-700 hover:bg-gray-100 transition">

                Kembali Ke jadwal

            </a>



        </div>

    </div>

    {{-- ================= MATRIX ================= --}}
    <div class="border border-gray-300 rounded-2xl overflow-hidden shadow-sm">

        <div class="overflow-auto">

            <table class="w-full border-collapse min-w-[1100px]">

                {{-- ================= HEADER ================= --}}
                <thead class="sticky top-0 z-20 bg-white border-b border-gray-300 shadow-sm">

                    <tr>

                        {{-- HARI / SESI --}}
                        <th class="sticky left-0 z-30 bg-gray-50 border-r border-gray-300 px-3 py-4 text-left min-w-[130px]">

                            <div class="text-[11px] font-bold uppercase tracking-wide text-gray-600">

                                Hari / Sesi

                            </div>

                        </th>

                        {{-- RUANGAN --}}
                        @foreach($ruangan as $r)

                            <th class="border-r border-gray-300 bg-gray-50 px-3 py-4 text-center min-w-[170px]">

                                <div class="text-xs font-bold uppercase tracking-wide text-gray-700">

                                    {{ $r->nama_ruangan }}

                                </div>

                            </th>

                        @endforeach

                    </tr>

                </thead>

                {{-- ================= BODY ================= --}}
                <tbody>

                    @foreach($hari as $h)

                        {{-- ================= HARI ================= --}}
                        <tr>

                            <td colspan="{{ $ruangan->count() + 1 }}"
                                class="px-4 py-3 text-xs font-bold uppercase tracking-wider text-gray-700 bg-gray-100 border-y border-gray-300">

                                {{ $h }}

                            </td>

                        </tr>

                        {{-- ================= SESI ================= --}}
                        @foreach($sesi as $s)

                            <tr class="hover:bg-gray-50 transition">

                                {{-- SESI --}}
                                <td class="sticky left-0 z-10 bg-gray-50 border-r border-b border-gray-300 px-3 py-4 align-top">

                                    <div class="text-xs font-semibold text-gray-800">

                                        {{ $s->nama_sesi }}

                                    </div>

                                    <div class="text-[10px] text-gray-500 mt-1">

                                        {{ $s->jam_mulai }}
                                        -
                                        {{ $s->jam_selesai }}

                                    </div>

                                </td>

                                {{-- ================= RUANGAN ================= --}}
                                @foreach($ruangan as $r)

                                    @php

                                        $item = $jadwal->first(function($j) use ($h, $s, $r) {

                                            return
                                                $j->hari == $h &&
                                                $j->sesi_id == $s->id &&
                                                $j->ruangan_id == $r->id;

                                        });

                                        $color = 'border-l-blue-500 bg-blue-50';

                                        if($item){

                                            $kelas = strtolower($item->kelas->nama_kelas ?? '');

                                            if(str_contains($kelas, 'ips')){

                                                $color = 'border-l-green-500 bg-green-50';

                                            }elseif(str_contains($kelas, 'try')){

                                                $color = 'border-l-orange-500 bg-orange-50';

                                            }elseif(str_contains($kelas, 'intensif')){

                                                $color = 'border-l-indigo-500 bg-indigo-50';

                                            }elseif(str_contains($kelas, 'medis')){

                                                $color = 'border-l-pink-500 bg-pink-50';

                                            }

                                        }

                                    @endphp

                                    <td class="border-b border-r border-gray-300 px-2 py-2 align-top">

                                        @if($item)

                                            <a href="{{ route('jadwal.edit', $item->id) }}"
                                            class="block border-l-4 {{ $color }}
                                            rounded-lg px-3 py-2
                                            hover:shadow-lg
                                            hover:-translate-y-0.5
                                            hover:scale-[1.02]
                                            transition duration-200"

                                                {{-- KELAS --}}
                                                <div class="text-[12px] font-bold text-gray-800 leading-tight">

                                                    {{ $item->kelas->nama_kelas ?? '-' }}

                                                </div>

                                                {{-- MAPEL --}}
                                                <div class="text-[11px] text-gray-600 leading-tight mt-1">

                                                    {{ $item->mataPelajaran->singkatan ?? '-' }}

                                                </div>

                                                {{-- TENTOR --}}
                                                <div class="text-[10px] text-gray-500 leading-tight mt-1">

                                                    👨‍🏫 {{ $item->tentor->nama ?? '-' }}

                                                </div>

                                            </a>

                                        @else

                                            <a href="{{ route('jadwal.create', [

                                                    'hari' => $h,
                                                    'sesi_id' => $s->id,
                                                    'ruangan_id' => $r->id

                                                ]) }}"

                                                class="flex items-center justify-center
                                                    text-[11px]
                                                    text-orange-500
                                                    hover:text-orange-600
                                                    hover:bg-orange-50
                                                    rounded-lg py-4 transition">

                                                ➕ Tambah

                                            </a>

                                        @endif

                                    </td>

                                @endforeach

                            </tr>

                        @endforeach

                    @endforeach

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection