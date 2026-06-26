@extends('layouts.tentor')

@section('content')

<div class="max-w-5xl mx-auto space-y-6">
@if(session('success'))
    <div class="bg-green-100 border border-green-300
                text-green-700 px-4 py-3 rounded-xl">
        {{ session('success') }}
    </div>
@endif

@if(session('error'))
    <div class="bg-red-100 border border-red-300
                text-red-700 px-4 py-3 rounded-xl">
        {{ session('error') }}
    </div>
@endif

@if($errors->any())
    <div class="bg-red-100 border border-red-300
                text-red-700 px-4 py-3 rounded-xl">
        <ul class="list-disc pl-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif


    {{-- ================= HEADER ================= --}}
    <div class="bg-gradient-to-r from-blue-600 to-blue-500
                rounded-2xl p-5 shadow text-white">

        <div class="flex flex-col lg:flex-row
                    lg:items-center lg:justify-between gap-4">

            <div>

                <p class="text-orange-100 text-sm">

                    Input Nilai Quiz

                </p>

                <h1 class="text-3xl font-bold mt-1">

                    {{ $quiz->judul ?? 'Quiz ' . $jadwal->mataPelajaran->nama_mapel }}

                </h1>

            </div>

            <div class="bg-white/15 rounded-2xl px-5 py-4">

                <div class="text-xs text-orange-100">

                    Tanggal Quiz

                </div>

                <div class="font-bold mt-1">

                    {{ \Carbon\Carbon::parse($tanggal)->format('d M Y') }}

                </div>

            </div>

        </div>

    </div>

    {{-- ALERT JIKA SUDAH ADA QUIZ --}}
    @if($sudahQuiz)
        <div class="bg-yellow-50 border border-yellow-200
                    text-yellow-700 rounded-2xl
                    px-4 py-3 text-sm shadow-sm">

            Nilai quiz pada tanggal ini sudah pernah diinput.
            Anda dapat memperbarui nilai quiz siswa.

        </div>
    @endif

    {{-- ================= INFO ================= --}}
    <div class="bg-white rounded-3xl p-5
                shadow-sm border border-gray-100">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            {{-- MAPEL --}}
            <div>

                <div class="text-sm text-gray-500">

                    Mata Pelajaran

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $jadwal->mataPelajaran->nama_mapel }}

                </div>

            </div>

            {{-- KELAS --}}
            <div>

                <div class="text-sm text-gray-500">

                    Kelas

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $jadwal->kelas->nama_kelas }}

                </div>

            </div>

            {{-- TENTOR --}}
            <div>

                <div class="text-sm text-gray-500">

                    Tentor

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $jadwal->tentor->nama }}

                </div>

            </div>

        </div>

    </div>

    {{-- ================= FORM ================= --}}
    <form method="POST"
          action="{{ route('tentor.quiz.store', $jadwal->id) }}">

        @csrf

        {{-- ================= TANGGAL QUIZ ================= --}}
        <div class="bg-white rounded-2xl p-4
                    border border-gray-100 shadow-sm">

            <div class="flex flex-col md:flex-row
                        md:items-center md:justify-between gap-4">

                <div>

                    <h3 class="font-semibold text-gray-800">

                        Tanggal Quiz

                    </h3>

                    <p class="text-sm text-gray-500 mt-1">

                        Sesuaikan dengan tanggal pertemuan belajar

                    </p>

                </div>

                <div>

                    <input type="date"
                           name="tanggal"
                           value="{{ $tanggal }}"
                           onchange="window.location.href='?tanggal=' + this.value"
                           class="border border-gray-300
                                  rounded-xl px-4 py-2.5">

                </div>

            </div>

        </div>

        {{-- ================= TABLE NILAI ================= --}}
        <div class="bg-white rounded-3xl shadow-sm
                    border border-gray-100 overflow-hidden">

            <div class="overflow-x-auto">

                <table class="w-full text-sm">

                    <thead class="bg-gray-50">

                        <tr>

                            <th class="px-5 py-4 text-left">

                                Nama Siswa

                            </th>

                            <th class="px-5 py-4 text-left">

                                Nilai

                            </th>

                        </tr>

                    </thead>

                    <tbody>

                        @foreach($siswa as $s)

                        @php

                            $nilai = $nilaiQuiz
                                ->get($s->id)
                                ->nilai ?? null;

                        @endphp

                        <tr class="border-t border-gray-100">

                            {{-- NAMA SISWA --}}
                            <td class="px-5 py-4">

                                <div class="flex items-center gap-3">

                                    {{-- AVATAR --}}
                                    <div class="w-10 h-10 rounded-xl
                                                bg-orange-100 text-orange-600
                                                flex items-center justify-center
                                                font-bold text-sm">

                                        {{ strtoupper(substr($s->nama, 0, 1)) }}

                                    </div>

                                    {{-- INFO --}}
                                    <div>

                                        <div class="font-semibold text-gray-800">

                                            {{ $s->nama }}

                                        </div>

                                        <div class="text-xs text-gray-500">

                                            Siswa

                                        </div>

                                    </div>

                                </div>

                            </td>

                            {{-- INPUT NILAI --}}
                            <td class="px-5 py-4">

                                <input type="hidden"
                                       name="nilai[{{ $loop->index }}][siswa_id]"
                                       value="{{ $s->id }}">

                                <input type="number"
                                       name="nilai[{{ $loop->index }}][nilai]"
                                       value="{{ $nilai }}"
                                       min="0"
                                       max="100"
                                       placeholder="0 - 100"
                                       class="w-32 border border-gray-200
                                              rounded-2xl px-4 py-2
                                              focus:ring-2 focus:ring-orange-200
                                              focus:border-orange-400
                                              outline-none transition-all">

                            </td>

                        </tr>

                        @endforeach

                    </tbody>

                </table>

            </div>

        </div>

        
        {{-- ================= BUTTON ================= --}}
        <div class="flex justify-end gap-3 mt-6">

            {{-- KEMBALI --}}
            <a href="{{ route('tentor.jadwal') }}"
            class="bg-gray-100 hover:bg-gray-200
                    text-gray-700 px-6 py-3 rounded-2xl
                    font-semibold transition-all">

                ← Kembali

            </a>

            {{-- SIMPAN / UPDATE --}}
            <button type="submit"
                    class="bg-orange-500 hover:bg-orange-600
                        text-white px-6 py-3 rounded-2xl
                        font-semibold shadow-lg transition-all">

                {{ $sudahQuiz ? 'Update Nilai Quiz' : 'Simpan Nilai Quiz' }}

            </button>

        </div>

    </form>

</div>

@endsection