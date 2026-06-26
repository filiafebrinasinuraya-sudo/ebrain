@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-3xl font-bold text-gray-800">

                Monitoring Quiz

            </h1>

            <p class="text-sm text-gray-500 mt-1">

                Monitoring nilai quiz siswa bimbel

            </p>

        </div>

    </div>

    {{-- FILTER --}}
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

        <form method="GET"
              action="{{ route('quiz.index') }}">

            <div class="flex flex-col lg:flex-row gap-4">

                <select name="kelas_id"
                        class="border border-gray-200
                               rounded-2xl px-4 py-3 text-sm">

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

                <button class="bg-blue-600 hover:bg-blue-700
                               text-white px-5 py-3 rounded-2xl
                               text-sm font-semibold transition">

                    Filter

                </button>

            </div>

        </form>

    </div>

    {{-- TABLE QUIZ --}}
    <div class="bg-white rounded-3xl shadow-sm
                border border-gray-100 overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-5 py-4 text-left">
                            Quiz
                        </th>

                        <th class="px-5 py-4 text-left">
                            Kelas
                        </th>

                        <th class="px-5 py-4 text-left">
                            Mata Pelajaran
                        </th>

                        <th class="px-5 py-4 text-left">
                            Tentor
                        </th>

                        <th class="px-5 py-4 text-left">
                            Tanggal
                        </th>

                        <th class="px-5 py-4 text-left">
                            Rata-rata
                        </th>

                        <th class="px-5 py-4 text-left">
                            Detail
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($quiz as $q)

                    @php

                        $avg = round(
                            $q->nilaiQuiz->avg('nilai'),
                            1
                        );

                    @endphp

                    <tr class="border-t border-gray-100 hover:bg-gray-50 transition">

                        {{-- JUDUL QUIZ --}}
                        <td class="px-5 py-4">

                            <div class="font-semibold text-gray-800">

                                {{ $q->judul }}

                            </div>

                        </td>

                        {{-- KELAS --}}
                        <td class="px-5 py-4 text-gray-700">

                            {{ $q->jadwal->kelas->nama_kelas }}

                        </td>

                        {{-- MAPEL --}}
                        <td class="px-5 py-4 text-gray-700">

                            {{ $q->jadwal->mataPelajaran->nama_mapel }}

                        </td>

                        {{-- TENTOR --}}
                        <td class="px-5 py-4 text-gray-700">

                            {{ $q->jadwal->tentor->nama }}

                        </td>

                        {{-- TANGGAL --}}
                        <td class="px-5 py-4 text-gray-700">

                            {{ \Carbon\Carbon::parse($q->tanggal)->format('d M Y') }}

                        </td>

                        {{-- RATA-RATA --}}
                        <td class="px-5 py-4">

                            @if($avg >= 85)

                                <span class="bg-green-100 text-green-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    {{ $avg }}

                                </span>

                            @elseif($avg >= 70)

                                <span class="bg-yellow-100 text-yellow-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    {{ $avg }}

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    {{ $avg }}

                                </span>

                            @endif

                        </td>

                        {{-- BUTTON DETAIL --}}
                        <td class="px-5 py-4">

                            <a href="{{ route('quiz.detail', $q->id) }}"
                               class="bg-orange-100 hover:bg-orange-200
                                      text-orange-700 px-4 py-2 rounded-xl
                                      text-xs font-semibold transition">

                                Detail

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="7"
                            class="text-center py-16">

                            <div class="text-6xl mb-4">
                                📘
                            </div>

                            <div class="text-lg font-semibold text-gray-700">

                                Belum Ada Data Quiz

                            </div>

                            <div class="text-sm text-gray-500 mt-2">

                                Quiz yang dibuat tentor akan muncul di sini

                            </div>

                        </td>

                    </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection