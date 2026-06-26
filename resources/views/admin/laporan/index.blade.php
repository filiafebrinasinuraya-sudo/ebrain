@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm p-6">

        <div class="flex flex-col lg:flex-row
                    lg:items-center
                    lg:justify-between gap-4">

            <div>

                <p class="text-sm text-gray-500">

                    Monitoring perkembangan siswa

                </p>

                <h1 class="text-3xl font-bold
                           text-gray-800 mt-1">

                    Laporan Perkembangan Siswa

                </h1>

            </div>

            {{-- TOTAL --}}
            <div class="bg-blue-50
                        border border-blue-100
                        rounded-2xl px-5 py-4">

                <p class="text-sm text-blue-600">

                    Total Siswa

                </p>

                <h2 class="text-2xl font-bold
                           text-blue-700 mt-1">

                    {{ $siswa->count() }}

                </h2>

            </div>

        </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm p-5">

        <form method="GET">

            <div class="flex flex-col md:flex-row
                        md:items-end gap-4">

                {{-- KELAS --}}
                <div class="w-full md:w-64">

                    <label class="text-sm text-gray-600">

                        Filter Kelas

                    </label>

                    <select name="kelas_id"
                            class="w-full mt-2 border border-gray-200
                                rounded-2xl px-4 py-3">

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

                </div>

                {{-- BUTTON --}}
                <div>

                    <button class="bg-blue-600 hover:bg-blue-700
                                text-white px-6 py-3
                                rounded-2xl text-sm
                                font-semibold transition">

                        Filter

                    </button>

                </div>

            </div>

        </form>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white rounded-3xl
                border border-gray-100
                shadow-sm overflow-hidden">

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                {{-- HEAD --}}
                <thead class="bg-gray-50">

                    <tr>

                        <th class="px-6 py-4 text-left
                                   font-semibold text-gray-600">

                            Nama Siswa

                        </th>

                        <th class="px-6 py-4 text-left
                                   font-semibold text-gray-600">

                            Kelas

                        </th>

                        <th class="px-6 py-4 text-center
                                   font-semibold text-gray-600">

                            Laporan

                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($siswa as $s)

                    <tr class="border-t border-gray-100
                               hover:bg-gray-50 transition">

                        {{-- NAMA --}}
                        <td class="px-6 py-5">

                            <div class="flex items-center gap-4">

                                {{-- AVATAR --}}
                                <div class="w-11 h-11 rounded-2xl
                                            bg-blue-100 text-blue-600
                                            flex items-center justify-center
                                            font-bold text-sm shrink-0">

                                    {{ strtoupper(substr($s->nama, 0, 1)) }}

                                </div>

                                {{-- INFO --}}
                                <div>

                                    <h2 class="font-semibold
                                               text-gray-800">

                                        {{ $s->nama }}

                                    </h2>

                                    <p class="text-xs text-gray-500 mt-1">

                                        ID Siswa :
                                        {{ $s->id }}

                                    </p>

                                </div>

                            </div>

                        </td>

                        {{-- KELAS --}}
                        <td class="px-6 py-5">

                            <div class="flex flex-wrap gap-2">

                                @forelse($s->kelas as $k)

                                <span class="bg-blue-50
                                             text-blue-700
                                             border border-blue-100
                                             px-3 py-1 rounded-xl
                                             text-xs font-medium">

                                    {{ $k->nama_kelas }}

                                </span>

                                @empty

                                <span class="text-gray-400 text-sm">

                                    Belum ada kelas

                                </span>

                                @endforelse

                            </div>

                        </td>

                        {{-- BUTTON --}}
                        <td class="px-6 py-5 text-center">

                            <a href="{{ route('laporan.siswa.detail', $s->id) }}"
                               class="inline-flex items-center
                                      justify-center
                                      bg-blue-600 hover:bg-blue-700
                                      text-white text-xs
                                      px-5 py-2.5 rounded-xl
                                      font-semibold
                                      transition-all duration-300">

                                Lihat Laporan

                            </a>

                        </td>

                    </tr>

                    @empty

                    {{-- EMPTY --}}
                    <tr>

                        <td colspan="3"
                            class="py-16 text-center">

                            <div class="text-6xl mb-4">

                                👨‍🎓

                            </div>

                            <h2 class="text-xl font-bold
                                       text-gray-700">

                                Belum Ada Data Siswa

                            </h2>

                            <p class="text-gray-500 mt-2">

                                Data siswa akan tampil di sini.

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