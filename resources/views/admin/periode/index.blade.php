@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h2 class="text-2xl font-bold text-gray-800">
                Manajemen Periode Jadwal
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola periode jadwal mingguan yang aktif digunakan siswa dan tentor
            </p>

        </div>

        <a href="{{ url('/admin/jadwal') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl transition text-sm">

            ← Kembali ke Jadwal

        </a>

    </div>

    {{-- ================= FORM ================= --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-2xl p-6">

        <div class="mb-5">

            <h3 class="font-semibold text-gray-800">
                Tambah Periode Baru
            </h3>

            <p class="text-sm text-gray-500 mt-1">
                Buat periode jadwal untuk minggu baru
            </p>

        </div>

        <form action="{{ route('periode.store') }}"
              method="POST"
              class="grid md:grid-cols-5 gap-4">

            @csrf

            {{-- TAHUN AJARAN --}}
            <div>

                <label class="text-sm text-gray-600 mb-1 block">
                    Tahun Ajaran
                </label>

                <input type="text"
                       name="tahun_ajaran"
                       placeholder="2025/2026"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm"
                       required>

            </div>

            {{-- SEMESTER --}}
            <div>

                <label class="text-sm text-gray-600 mb-1 block">
                    Semester
                </label>

                <select name="semester"
                        class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm"
                        required>

                    <option value="">Pilih Semester</option>
                    <option value="Ganjil">Ganjil</option>
                    <option value="Genap">Genap</option>

                </select>

            </div>

            {{-- MULAI --}}
            <div>

                <label class="text-sm text-gray-600 mb-1 block">
                    Tanggal Mulai
                </label>

                <input type="date"
                       name="tanggal_mulai"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm"
                       required>

            </div>

            {{-- SELESAI --}}
            <div>

                <label class="text-sm text-gray-600 mb-1 block">
                    Tanggal Selesai
                </label>

                <input type="date"
                       name="tanggal_selesai"
                       class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm"
                       required>

            </div>

            {{-- BUTTON --}}
            <div class="flex items-end">

                <button class="w-full bg-blue-600 hover:bg-blue-700 text-white rounded-xl px-4 py-3 text-sm font-medium transition">

                    Simpan

                </button>

            </div>

        </form>

    </div>

    {{-- ================= TABLE ================= --}}
    <div class="bg-white shadow-sm border border-gray-200 rounded-2xl overflow-hidden">

        <div class="px-6 py-4 border-b border-gray-200">

            <h3 class="font-semibold text-gray-800">
                Data Periode
            </h3>

        </div>

        <div class="overflow-x-auto">

            <table class="w-full text-sm">

                <thead class="bg-gray-50 text-gray-700">

                    <tr>

                        <th class="p-4 text-left">
                            Tahun Ajaran
                        </th>

                        <th class="p-4 text-left">
                            Semester
                        </th>

                        <th class="p-4 text-left">
                            Tanggal
                        </th>

                        <th class="p-4 text-center">
                            Status
                        </th>

                        <th class="p-4 text-center">
                            Aksi
                        </th>

                    </tr>

                </thead>

                <tbody>

                    @forelse($periode as $p)

                        <tr class="border-t border-gray-100 hover:bg-gray-50 transition">

                            {{-- TAHUN --}}
                            <td class="p-4 font-semibold text-gray-800">

                                {{ $p->tahun_ajaran }}

                            </td>

                            {{-- SEMESTER --}}
                            <td class="p-4">

                                <span class="px-3 py-1 rounded-full text-xs font-medium
                                    {{ $p->semester == 'Ganjil'
                                        ? 'bg-blue-100 text-blue-700'
                                        : 'bg-green-100 text-green-700' }}">

                                    {{ $p->semester }}

                                </span>

                            </td>

                            {{-- TANGGAL --}}
                            <td class="p-4 text-gray-600">

                                {{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}

                                -

                                {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }}

                            </td>

                            {{-- STATUS --}}
                            <td class="p-4 text-center">

                                @if($p->is_active)

                                    <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                                        Aktif

                                    </span>

                                @else

                                    <span class="bg-gray-100 text-gray-500 px-3 py-1 rounded-full text-xs">

                                        Tidak Aktif

                                    </span>

                                @endif

                            </td>

                            {{-- AKSI --}}
                            <td class="p-4">

                                <div class="flex justify-center gap-2">

                                    @if(!$p->is_active)

                                        <a href="{{ route('periode.aktifkan', $p->id) }}"
                                           onclick="return confirm('Aktifkan periode ini?')"
                                           class="bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded-lg text-xs transition">

                                            Aktifkan

                                        </a>

                                    @endif

                                    <form action="{{ route('periode.copy', $p->id) }}"
                                        method="POST">

                                        @csrf

                                        <button type="submit"
                                                onclick="return confirm('Salin jadwal ke periode ini?')"
                                                class="bg-green-500 hover:bg-green-600 text-white px-3 py-2 rounded-lg text-xs">

                                            Copy Jadwal

                                        </button>

                                    </form>

                                    {{-- DELETE --}}
                                    <form action="{{ route('periode.destroy', $p->id) }}"
                                          method="POST">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit"
                                                onclick="return confirm('Hapus periode ini?')"
                                                class="bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded-lg text-xs transition">

                                            Hapus

                                        </button>

                                    </form>

                                </div>

                            </td>

                        </tr>

                    @empty

                        <tr>

                            <td colspan="5"
                                class="text-center p-10 text-gray-500">

                                Belum ada data periode

                            </td>

                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

    </div>

</div>

@endsection