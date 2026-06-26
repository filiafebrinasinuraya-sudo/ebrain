@extends('layouts.admin')

@section('content')

<div class="space-y-5">

    {{-- ================= HEADER ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-5">

        <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

            {{-- LEFT --}}
            <div>

                <h1 class="text-2xl font-bold text-gray-800">

                    Jadwal Akademik

                </h1>

                @if($periodeAktif)

                    <p class="text-sm text-gray-500 mt-1">

                        {{ $periodeAktif->tahun_ajaran }}
                        •
                        Semester {{ $periodeAktif->semester }}

                    </p>

                    <div class="mt-3 flex flex-wrap items-center gap-2">

                        {{-- BADGE --}}
                        <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                            Periode Aktif

                        </span>

                        {{-- TANGGAL --}}
                        <span class="text-xs text-gray-500">

                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d M Y') }}
                            -
                            {{ \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d M Y') }}

                        </span>

                    </div>

                @else

                    <p class="text-sm text-red-500 mt-2">

                        Belum ada periode aktif

                    </p>

                @endif

            </div>

            {{-- RIGHT --}}
            <div class="flex flex-wrap gap-2">

                {{-- MATRIX --}}
                <a href="{{ route('jadwal.matrix') }}"
                class="bg-gray-900 hover:bg-black text-white px-4 py-2 rounded-xl text-sm transition">

                    Matrix Jadwal

                </a>

            </div>

        </div>

    </div>

    {{-- ================= ALERT PERIODE ================= --}}
    @if(!$periodeAktif)

        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">

            Belum ada periode aktif.
            Silakan aktifkan periode terlebih dahulu sebelum membuat jadwal.

        </div>

    @endif

    {{-- ================= FILTER ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm p-4">

        <form method="GET"
              action="{{ route('jadwal.index') }}">

            <div class="grid grid-cols-1 md:grid-cols-4 gap-3">

                {{-- SEARCH --}}
                <div>

                    <input type="text"
                           name="search"
                           value="{{ request('search') }}"
                           placeholder="Cari kelas / tentor / mapel..."
                           class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                </div>

                {{-- HARI --}}
                <div>

                    <select name="hari"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <option value="">
                            Semua Hari
                        </option>

                        @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)

                            <option value="{{ $hari }}"
                                {{ request('hari') == $hari ? 'selected' : '' }}>

                                {{ $hari }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- KELAS --}}
                <div>

                    <select name="kelas_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

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

                {{-- PERIODE --}}
                <div>

                    <select name="periode_id"
                            class="w-full border border-gray-300 rounded-xl px-4 py-2 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none">

                        <option value="">
                            Semua Periode
                        </option>

                        @foreach($periode as $p)

                            <option value="{{ $p->id }}"
                                {{ request('periode_id') == $p->id ? 'selected' : '' }}>

                                {{ $p->tahun_ajaran }}
                                -
                                {{ $p->semester }}

                                {{ $p->is_active ? '(Aktif)' : '' }}

                            </option>

                        @endforeach

                    </select>

                </div>

                {{-- BUTTON --}}
                <div class="flex gap-2">

                    <button type="submit"
                            class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm transition w-full">

                        Filter

                    </button>

                    <a href="{{ route('jadwal.index') }}"
                       class="border border-gray-300 hover:bg-gray-100 text-gray-700 px-4 py-2 rounded-xl text-sm transition w-full text-center">

                        Reset

                    </a>

                </div>

            </div>

        </form>

    </div>


    {{-- ================= TABLE ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-auto">

            <table class="w-full border-collapse min-w-[1000px]">

                {{-- HEADER --}}
                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Hari
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Sesi
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Ruangan
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Kelas
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Mapel
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Tentor
                        </th>

                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($jadwal as $j)

                        <tr class="hover:bg-gray-50 transition border-b border-gray-200">

                            {{-- HARI --}}
                            <td class="px-4 py-3 border-r border-gray-200">

                                <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">

                                    {{ $j->hari }}

                                </span>

                            </td>

                            {{-- SESI --}}
                            <td class="px-4 py-3 border-r border-gray-200">

                                <div class="text-sm font-semibold text-gray-800">

                                    {{ $j->sesi->nama_sesi ?? '-' }}

                                </div>

                                <div class="text-xs text-gray-500 mt-1">

                                    {{ $j->sesi->jam_mulai ?? '-' }}
                                    -
                                    {{ $j->sesi->jam_selesai ?? '-' }}

                                </div>

                            </td>

                            {{-- RUANGAN --}}
                            <td class="px-4 py-3 border-r border-gray-200 text-sm text-gray-700">

                                {{ $j->ruangan->nama_ruangan ?? '-' }}

                            </td>

                            {{-- KELAS --}}
                            <td class="px-4 py-3 border-r border-gray-200">

                                <div class="text-sm font-semibold text-gray-800">

                                    {{ $j->kelas->nama_kelas ?? '-' }}

                                </div>

                            </td>

                            {{-- MAPEL --}}
                            <td class="px-4 py-3 border-r border-gray-200">

                                <div class="text-sm text-gray-700">

                                    {{ $j->mataPelajaran->nama_mapel ?? '-' }}

                                </div>

                                <div class="text-xs text-gray-500 mt-1">

                                    {{ $j->mataPelajaran->singkatan ?? '-' }}

                                </div>

                            </td>

                            {{-- TENTOR --}}
                            <td class="px-4 py-3 border-r border-gray-200 text-sm text-gray-700">

                                {{ $j->tentor->nama ?? '-' }}

                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-3">

                                <div class="flex justify-center gap-2">

                                    {{-- EDIT --}}
                                    <a href="{{ route('jadwal.edit', $j->id) }}"
                                       class="px-3 py-1 text-xs rounded-lg bg-yellow-100 text-yellow-700 hover:bg-yellow-200 transition">

                                        Edit

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="{{ route('jadwal.destroy', $j->id) }}"
                                          method="POST"
                                          onsubmit="return confirm('Yakin ingin menghapus jadwal ini?')">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                class="px-3 py-1 text-xs rounded-lg bg-red-100 text-red-700 hover:bg-red-200 transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="7"
                                class="text-center py-10 text-sm text-gray-500">

                                Belum ada data jadwal

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection