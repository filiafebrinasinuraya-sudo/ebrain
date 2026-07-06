@extends('layouts.admin')

@section('content')

<div class="bg-white p-6 rounded-lg shadow">

    <h2 class="text-xl font-bold mb-5">
        Laporan Absensi Bulanan
    </h2>

    <form method="GET">

        <div class="grid md:grid-cols-4 gap-4">

            <div>
                <label>Kelas</label>

                <select name="kelas_id"
                        class="w-full border rounded p-2">

                    <option value="">
                        Pilih Kelas
                    </option>

                    @foreach($kelas as $k)

                        <option value="{{ $k->id }}">
                            {{ $k->nama_kelas }}
                        </option>

                    @endforeach

                </select>

            </div>

            <div>
                <label>Bulan</label>

                <input type="month"
                       name="bulan"
                       class="w-full border rounded p-2">

            </div>

            <div>
                <label>Minggu Ke</label>

                <select name="minggu_ke"
                        class="w-full border rounded p-2">

                    <option value="">
                        Semua Minggu
                    </option>

                    <option value="1">Minggu Ke-1</option>
                    <option value="2">Minggu Ke-2</option>
                    <option value="3">Minggu Ke-3</option>
                    <option value="4">Minggu Ke-4</option>
                    <option value="5">Minggu Ke-5</option>

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

        <a href="{{ route('laporan.absensi.pdf', [
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

                    @foreach($tanggalPertemuan as $tgl)

                        <th class="border p-2 text-center">

                            {{ \Carbon\Carbon::parse($tgl)->format('d') }}

                        </th>

                    @endforeach
                    
                    <th class="border p-2">
                        % Hadir
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

                    @foreach($tanggalPertemuan as $tgl)

                        @php

                            $absenTanggal = $absensi
                                ->where('siswa_id', $item->id)
                                ->filter(function ($a) use ($tgl) {

                                    return $a->tanggal == $tgl;

                                });

                        @endphp

                        <td class="border p-2 text-center">

                            @if($absenTanggal->count())

                                {{ $absenTanggal->map(function ($a) {

                                    if ($a->status == 'Hadir') {
                                        return 'H';
                                    }

                                    if ($a->status == 'Izin') {
                                        return 'I';
                                    }

                                    if ($a->status == 'Sakit') {
                                        return 'S';
                                    }

                                    if ($a->status == 'Alpha') {
                                        return 'A';
                                    }

                                    return '-';

                                })->implode('/') }}

                            @else

                                -

                            @endif

                        </td>

                    @endforeach

                    @php

                            $totalSesi = $absensi
                                ->where('siswa_id', $item->id)
                                ->count();

                            $totalHadir = $absensi
                                ->where('siswa_id', $item->id)
                                ->where('status', 'Hadir')
                                ->count();

                            $persentase = $totalSesi > 0
                                ? round(($totalHadir / $totalSesi) * 100, 2)
                                : 0;

                        @endphp

                        <td class="border p-2 text-center">
                            {{ $persentase }}%
                        </td>
                </tr>

                @endforeach

            </tbody>

        </table>
        <div class="mt-4 text-sm">
            <p><strong>Keterangan:</strong></p>
            <p>H = Hadir</p>
            <p>I = Izin</p>
            <p>S = Sakit</p>
            <p>A = Alpha</p>
            <p>Format H/H menunjukkan status kehadiran pada dua sesi pembelajaran dalam satu hari (Sesi 1 / Sesi 2).</p>
        </div>

    </div>

    @endif

</div>

@endsection