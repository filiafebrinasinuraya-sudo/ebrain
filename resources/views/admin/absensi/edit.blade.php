@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm
                border border-gray-100 p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">

            Edit Absensi

        </h1>

        <div class="space-y-4 mb-6">

            <div>

                <div class="text-sm text-gray-500">
                    Nama Siswa
                </div>

                <div class="font-semibold text-gray-800">

                    {{ $absensi->siswa->nama }}

                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">
                    Mata Pelajaran
                </div>

                <div class="font-semibold text-gray-800">

                    {{ $absensi->jadwal->mataPelajaran->nama_mapel }}

                </div>

            </div>

            <div>

                <div class="text-sm text-gray-500">
                    Tanggal
                </div>

                <div class="font-semibold text-gray-800">

                    {{ \Carbon\Carbon::parse($absensi->tanggal)->format('d M Y') }}

                </div>

            </div>

        </div>

        <form method="POST"
              action="{{ route('absensi.update', $absensi->id) }}">

            @csrf
            @method('PUT')

            <div>

                <label class="text-sm text-gray-600 block mb-2">

                    Status Kehadiran

                </label>

                <select name="status"
                        class="w-full border border-gray-200
                               rounded-2xl px-4 py-3">

                    <option value="Hadir"
                        {{ $absensi->status == 'Hadir' ? 'selected' : '' }}>

                        Hadir

                    </option>

                    <option value="Izin"
                        {{ $absensi->status == 'Izin' ? 'selected' : '' }}>

                        Izin

                    </option>

                    <option value="Sakit"
                        {{ $absensi->status == 'Sakit' ? 'selected' : '' }}>

                        Sakit

                    </option>

                    <option value="Alpha"
                        {{ $absensi->status == 'Alpha' ? 'selected' : '' }}>

                        Alpha

                    </option>

                </select>

            </div>

            <div class="mt-6 flex justify-end">

                <button class="bg-blue-600 hover:bg-blue-700
                               text-white px-6 py-3 rounded-2xl">

                    Update Absensi

                </button>

            </div>

        </form>

    </div>

</div>

@endsection