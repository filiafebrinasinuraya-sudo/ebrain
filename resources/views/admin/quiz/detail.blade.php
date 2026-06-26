@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- HEADER --}}
    <div class="bg-gradient-to-r from-orange-500 to-orange-400
                rounded-3xl p-6 text-white shadow-lg">

        <div class="flex flex-col lg:flex-row
                    lg:items-center lg:justify-between gap-5">

            <div>

                <p class="text-orange-100 text-sm">

                    Detail Quiz

                </p>

                <h1 class="text-3xl font-bold mt-1">

                    {{ $quiz->judul }}

                </h1>

            </div>

            <div class="bg-white/15 rounded-2xl px-5 py-4">

                <div class="text-xs text-orange-100">

                    Tanggal Quiz

                </div>

                <div class="font-bold mt-1">

                    {{ \Carbon\Carbon::parse($quiz->tanggal)->format('d M Y') }}

                </div>

            </div>

        </div>

    </div>

    {{-- SUMMARY --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        <div class="bg-white rounded-3xl p-5
                    shadow-sm border border-gray-100">

            <div class="text-sm text-gray-500">

                Rata-rata Nilai

            </div>

            <div class="text-3xl font-bold text-blue-600 mt-2">

                {{ $rataRata }}

            </div>

        </div>

        <div class="bg-white rounded-3xl p-5
                    shadow-sm border border-gray-100">

            <div class="text-sm text-gray-500">

                Nilai Tertinggi

            </div>

            <div class="text-3xl font-bold text-green-600 mt-2">

                {{ $tertinggi }}

            </div>

        </div>

        <div class="bg-white rounded-3xl p-5
                    shadow-sm border border-gray-100">

            <div class="text-sm text-gray-500">

                Nilai Terendah

            </div>

            <div class="text-3xl font-bold text-red-600 mt-2">

                {{ $terendah }}

            </div>

        </div>

    </div>

    {{-- INFO QUIZ --}}
    <div class="bg-white rounded-3xl p-5
                shadow-sm border border-gray-100">

        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

            <div>

                <div class="text-sm text-gray-500">

                    Kelas

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $quiz->jadwal->kelas->nama_kelas }}

                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">

                    Mata Pelajaran

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $quiz->jadwal->mataPelajaran->nama_mapel }}

                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">

                    Tentor

                </div>

                <div class="font-semibold text-gray-800 mt-1">

                    {{ $quiz->jadwal->tentor->nama }}

                </div>

            </div>

        </div>

    </div>

    {{-- TABLE NILAI --}}
    <div class="bg-white rounded-3xl
                shadow-sm border border-gray-100 overflow-hidden">

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

                        <th class="px-5 py-4 text-left">
                            Status
                        </th>

                        <th class="px-5 py-4 text-left">
                            Aksi
                        </th>


                    </tr>

                </thead>

                <tbody>

                    @forelse($quiz->nilaiQuiz as $n)

                    <tr class="border-t border-gray-100 hover:bg-gray-50">

                        {{-- NAMA SISWA --}}
                        <td class="px-5 py-4 font-medium text-gray-800">

                            {{ $n->siswa->nama }}

                        </td>

                        {{-- NILAI --}}
                        <td class="px-5 py-4">

                            <span class="font-semibold text-gray-800">

                                {{ $n->nilai }}

                            </span>

                        </td>

                        {{-- STATUS --}}
                        <td class="px-5 py-4">

                            @if($n->nilai >= 85)

                                <span class="bg-green-100 text-green-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Sangat Baik

                                </span>

                            @elseif($n->nilai >= 70)

                                <span class="bg-yellow-100 text-yellow-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Baik

                                </span>

                            @else

                                <span class="bg-red-100 text-red-700
                                             px-3 py-1 rounded-xl
                                             text-xs font-semibold">

                                    Perlu Evaluasi

                                </span>

                            @endif

                        </td>

                        <td class="px-5 py-4">

                            <a href="{{ route('quiz.edit', $n->id) }}"
                            class="bg-blue-100 hover:bg-blue-200
                                    text-blue-700 px-3 py-2
                                    rounded-xl text-xs font-semibold">

                                Edit

                            </a>

                        </td>

                    </tr>

                    @empty

                    <tr>

                        <td colspan="3"
                            class="text-center py-16">

                            <div class="text-6xl mb-4">
                                📘
                            </div>

                            <div class="text-lg font-semibold text-gray-700">

                                Belum Ada Nilai Quiz

                            </div>

                            <div class="text-sm text-gray-500 mt-2">

                                Nilai siswa akan tampil di sini

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