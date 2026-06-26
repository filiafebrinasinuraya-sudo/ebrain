@extends('layouts.admin')

@section('content')

<div class="space-y-5">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">

                Data Kelas

            </h2>

            <p class="text-sm text-gray-500 mt-1">

                Kelola data kelas dan hari belajar

            </p>

        </div>

        <div class="flex flex-wrap gap-2">

            {{-- TAMBAH --}}
            <a href="/admin/kelas/create"
               class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition">

                + Tambah Kelas

            </a>

            {{-- NAIK KELAS --}}
            <a href="/admin/kelas/naik-kelas"
               class="bg-green-600 hover:bg-green-700 text-white px-4 py-2 rounded-xl text-sm font-medium transition">

                ⬆ Naik Kelas

            </a>

        </div>

    </div>

    {{-- ================= ERROR ================= --}}
    @if($errors->any())

        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl text-sm">

            {{ $errors->first() }}

        </div>

    @endif

    {{-- ================= TABLE ================= --}}
    <div class="bg-white border border-gray-200 rounded-2xl shadow-sm overflow-hidden">

        <div class="overflow-auto">

            <table class="w-full min-w-[900px] text-sm border-collapse">

                {{-- HEADER --}}
                <thead class="bg-gray-50 border-b border-gray-200">

                    <tr>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            No
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Program
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Nama Kelas
                        </th>

                        <th class="px-4 py-3 text-left text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Hari Belajar
                        </th>

                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-gray-600 border-r border-gray-200">
                            Jumlah Siswa
                        </th>

                        <th class="px-4 py-3 text-center text-xs font-bold uppercase tracking-wide text-gray-600">
                            Aksi
                        </th>

                    </tr>

                </thead>

                {{-- BODY --}}
                <tbody>

                    @forelse($kelas as $key => $k)

                        <tr class="border-b border-gray-200 hover:bg-gray-50 transition">

                            {{-- NO --}}
                            <td class="px-4 py-4 border-r border-gray-200 text-gray-500">

                                {{ $key + 1 }}

                            </td>

                            {{-- PROGRAM --}}
                            <td class="px-4 py-4 border-r border-gray-200">

                                <span class="px-2 py-1 bg-indigo-100 text-indigo-700 rounded-lg text-xs font-medium">

                                    {{ $k->program->nama_program ?? '-' }}

                                </span>

                            </td>

                            {{-- KELAS --}}
                            <td class="px-4 py-4 border-r border-gray-200">

                                <div class="font-semibold text-gray-800">

                                    {{ $k->nama_kelas }}

                                </div>

                            </td>

                            {{-- HARI BELAJAR --}}
                            <td class="px-4 py-4 border-r border-gray-200">

                                @if($k->hari_belajar)

                                    <div class="flex flex-wrap gap-1">

                                        @foreach(explode(',', $k->hari_belajar) as $hari)

                                            <span class="px-2 py-1 bg-blue-100 text-blue-700 rounded-md text-xs font-medium">

                                                {{ $hari }}

                                            </span>

                                        @endforeach

                                    </div>

                                @else

                                    <span class="text-xs text-gray-400 italic">

                                        Belum diatur

                                    </span>

                                @endif

                            </td>

                            {{-- JUMLAH SISWA --}}
                            <td class="px-4 py-4 border-r border-gray-200 text-center">

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-lg text-xs font-semibold">

                                    {{ $k->siswa_count ?? 0 }} siswa

                                </span>

                            </td>

                            {{-- AKSI --}}
                            <td class="px-4 py-4">

                                <div class="flex justify-center gap-2 flex-wrap">

                                    {{-- SISWA --}}
                                    <a href="/admin/kelas/{{ $k->id }}/laporan"
                                       class="bg-green-100 hover:bg-green-200 text-green-700 px-3 py-2 rounded-lg text-xs font-medium transition">

                                        📄 Lihat Siswa

                                    </a>

                                    {{-- EDIT --}}
                                    <a href="/admin/kelas/{{ $k->id }}/edit"
                                       class="bg-yellow-100 hover:bg-yellow-200 text-yellow-700 px-3 py-2 rounded-lg text-xs font-medium transition">

                                        ✏ Edit

                                    </a>

                                    {{-- DELETE --}}
                                    <form action="/admin/kelas/{{ $k->id }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Yakin hapus kelas ini?')"
                                                class="bg-red-100 hover:bg-red-200 text-red-700 px-3 py-2 rounded-lg text-xs font-medium transition">

                                            🗑 Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="6"
                                class="text-center py-10 text-sm text-gray-500">

                                Belum ada data kelas

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection