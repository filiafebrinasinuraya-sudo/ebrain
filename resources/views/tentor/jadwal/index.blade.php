@extends('layouts.tentor')

@section('content')

@if(session('success'))
    <div class="mb-4 p-4 rounded-xl bg-green-50 border border-green-200 text-green-700">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="mb-4 p-4 rounded-xl bg-red-50 border border-red-200 text-red-700">
        {{ session('error') }}
    </div>
@endif

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-500
                rounded-3xl p-6 shadow-lg text-white">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

            <div>

                <p class="text-sm text-blue-100 tracking-wide">
                    E-Brain Tentor
                </p>

                <h1 class="text-3xl font-bold mt-1">

                    Halo, {{ auth()->user()->name }} 👋

                </h1>

                <p class="text-sm text-blue-100 mt-2">

                    Jadwal mengajar periode aktif

                </p>

            </div>

            {{-- INFO --}}
            <div class="flex gap-3">

                <div class="bg-white/15 backdrop-blur-md
                            rounded-2xl px-5 py-4 min-w-[110px]">

                    <div class="text-xs text-blue-100">
                        Total Jadwal
                    </div>

                    <div class="text-2xl font-bold mt-1">

                        {{ $jadwal->count() }}

                    </div>

                </div>

                <div class="bg-white/15 backdrop-blur-md
                            rounded-2xl px-5 py-4 min-w-[140px]">

                    <div class="text-xs text-blue-100">
                        Semester
                    </div>

                    <div class="text-sm font-semibold mt-2">

                        {{ $periodeAktif->semester }}

                    </div>

                </div>

            </div>

        </div>

    </div>

    {{-- GROUP JADWAL --}}
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

            {{-- LIST --}}
            <div class="space-y-4">

                @foreach($items as $j)

                <div class="bg-white border border-gray-100
                            rounded-3xl p-5 shadow-sm
                            hover:shadow-lg transition-all duration-300">

                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                        {{-- LEFT --}}
                        <div class="flex items-start gap-4">

                            {{-- JAM --}}
                            <div class="bg-blue-50 text-blue-700
                                        rounded-2xl px-4 py-3
                                        text-center min-w-[90px]">

                                <div class="text-xs font-medium">

                                    {{ $j->sesi->nama_sesi }}

                                </div>

                                <div class="text-lg font-bold mt-1">

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

                                        {{ $j->kelas->nama_kelas }}

                                    </span>

                                    <span class="bg-orange-100 text-orange-600
                                                text-xs px-3 py-1 rounded-full font-medium">

                                        {{ $j->ruangan->nama_ruangan }}

                                    </span>

                                </div>

                            </div>

                        </div>

                        {{-- BUTTON ABSENSI & QUIZ --}}
                        <div class="flex gap-2">

                            @php

                                $sudahAbsen = \App\Models\Absensi::where(
                                        'jadwal_id',
                                        $j->id
                                    )

                                    ->whereDate(
                                        'tanggal',
                                        request('tanggal', now()->toDateString())
                                    )

                                    ->exists();

                            @endphp

                            @if($sudahAbsen)

                            <a href="{{ route('tentor.absensi.create', $j->id) }}"
                            class="bg-green-100 hover:bg-green-200
                                    text-green-700 text-xs
                                    px-4 py-2 rounded-xl
                                    font-semibold transition-all duration-300">

                                ✓ Edit Absensi

                            </a>

                            @else

                                <a href="{{ route('tentor.absensi.create', $j->id) }}"
                                class="bg-orange-500 hover:bg-orange-600
                                text-white text-xs px-4 py-2 rounded-xl font-semibold
                                transition-all duration-300">

                                    Isi Absensi

                                </a>

                            @endif

                            {{-- STATUS QUIZ --}}
                            @php
                                $sudahQuiz = \App\Models\Quiz::where(
                                        'jadwal_id',
                                        $j->id
                                    )
                                    ->whereDate(
                                        'tanggal',
                                        request('tanggal', now()->toDateString())
                                    )
                                    ->exists();
                            @endphp

                            @if($sudahQuiz)

                                <a href="{{ route('tentor.quiz.create', $j->id) }}"
                                class="bg-blue-100 hover:bg-blue-200
                                        text-blue-700 text-xs
                                        px-4 py-2 rounded-xl
                                        font-semibold transition-all duration-300">

                                    ✓ Edit Quiz

                                </a>

                            @else

                                <a href="{{ route('tentor.quiz.create', $j->id) }}"
                                class="bg-blue-100 hover:bg-blue-200
                                        text-blue-700 text-xs
                                        px-4 py-2 rounded-xl
                                        font-semibold transition-all duration-300">

                                    Input Quiz

                                </a>

                            @endif

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

                Jadwal mengajar belum tersedia pada periode aktif.

            </p>

        </div>

        @endforelse

    </div>

</div>

@endsection