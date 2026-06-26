@extends('layouts.admin')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-5">
        Laporan Quiz
    </h2>

    <form method="GET">

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label>Kelas</label>

                <select
                    name="kelas_id"
                    class="w-full border rounded p-2">

                    <option value="">
                        Pilih Kelas
                    </option>

                    @foreach($kelas as $k)

                        <option
                            value="{{ $k->id }}"
                            {{ request('kelas_id') == $k->id ? 'selected' : '' }}>

                            {{ $k->nama_kelas }}

                        </option>

                    @endforeach

                </select>
            </div>

            <div>
                <label>Bulan</label>

                <input
                    type="month"
                    name="bulan"
                    value="{{ request('bulan') }}"
                    class="w-full border rounded p-2">
            </div>

            <div>
                <label>Minggu Ke</label>

                <select
                    name="minggu_ke"
                    class="w-full border rounded p-2">

                    <option value="">
                        Semua Minggu
                    </option>

                    @for($i = 1; $i <= 5; $i++)

                        <option
                            value="{{ $i }}"
                            {{ request('minggu_ke') == $i ? 'selected' : '' }}>

                            Minggu Ke-{{ $i }}

                        </option>

                    @endfor

                </select>
            </div>

            <div class="flex items-end">

                <button
                    class="bg-blue-500 text-white px-4 py-2 rounded">

                    Tampilkan

                </button>

            </div>

        </div>

    </form>

    @if(request('kelas_id') && request('bulan'))

            <div class="mt-4">

                <a href="{{ route('laporan.quiz.pdf', [
                    'kelas_id' => request('kelas_id'),
                    'bulan' => request('bulan'),
                    'minggu_ke' => request('minggu_ke')
                ]) }}"
                target="_blank"
                class="bg-red-500 text-white px-4 py-2 rounded">

                    Cetak PDF

                </a>

            </div>

            @endif

    @if($quiz->count())

    <div class="grid md:grid-cols-3 gap-4 mt-5">

        <div class="bg-blue-50 border border-blue-200 p-4 rounded">

            <h4 class="font-semibold text-blue-700">
                Rata-Rata Kelas
            </h4>

            <p class="text-2xl font-bold">
                {{ $rataKelas }}
            </p>

        </div>

        <div class="bg-green-50 border border-green-200 p-4 rounded">

            <h4 class="font-semibold text-green-700">
                Nilai Tertinggi
            </h4>

            <p class="text-2xl font-bold">
                {{ $nilaiTertinggi }}
            </p>

        </div>

        <div class="bg-red-50 border border-red-200 p-4 rounded">

            <h4 class="font-semibold text-red-700">
                Nilai Terendah
            </h4>

            <p class="text-2xl font-bold">
                {{ $nilaiTerendah }}
            </p>

        </div>

    </div>

    @endif

    @if($siswa->count())

    <div class="overflow-x-auto mt-5">

        <table class="min-w-full border">

            <thead>

                <tr>

                    <th class="border p-2">
                        No
                    </th>

                    <th class="border p-2">
                        Nama Siswa
                    </th>

                    @foreach($quiz as $q)

                        <th class="border p-2">

                            Quiz {{ $loop->iteration }}

                        </th>

                    @endforeach

                    <th class="border p-2">
                        Rata-Rata
                    </th>

                </tr>

            </thead>

            <tbody>

                @foreach($siswa as $item)

                <tr>

                    <td class="border p-2">
                        {{ $loop->iteration }}
                    </td>

                    <td class="border p-2">
                        {{ $item->nama }}
                    </td>

                    @php
                        $totalNilai = 0;
                        $jumlahQuiz = 0;
                    @endphp

                    @foreach($quiz as $q)

                        @php

                            $nilai = $nilaiQuiz
                                ->where('quiz_id', $q->id)
                                ->where('siswa_id', $item->id)
                                ->first();

                            if ($nilai) {
                                $totalNilai += $nilai->nilai;
                                $jumlahQuiz++;
                            }

                        @endphp

                        <td class="border p-2 text-center">

                            {{ $nilai ? $nilai->nilai : '-' }}

                        </td>

                    @endforeach

                    <td class="border p-2 text-center">

                        {{ $jumlahQuiz > 0 ? round($totalNilai / $jumlahQuiz, 2) : '-' }}

                    </td>

                </tr>

                @endforeach

            </tbody>

        </table>

    </div>

    @endif

    @if($quiz->count())

    <div class="mt-5 bg-gray-50 border rounded p-4">

        <h4 class="font-semibold mb-2">
            Keterangan Quiz
        </h4>

        @foreach($quiz as $q)

            <p>

                Quiz {{ $loop->iteration }}
                =
                {{ $q->judul }}

                ({{ \Carbon\Carbon::parse($q->tanggal)->format('d-m-Y') }})

            </p>

        @endforeach

    </div>

    @endif
</div>

@endsection