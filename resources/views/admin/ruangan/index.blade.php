@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-700">
                Data Ruangan
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data ruangan pembelajaran
            </p>
        </div>

        <!-- BUTTON TAMBAH -->
        <a href="{{ route('admin.ruangan.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">

            <span class="text-lg">+</span>
            <span>Tambah Ruangan</span>

        </a>

    </div>

    <!-- CARD TABLE -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <!-- HEADER TABLE -->
                <thead class="bg-gray-100 text-gray-600">

                    <tr>
                        <th class="p-4 text-left">No</th>
                        <th class="p-4 text-left">Nama Ruangan</th>
                        <th class="p-4 text-left">Kapasitas</th>
                        <th class="p-4 text-left">Tanggal Dibuat</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <!-- BODY -->
                <tbody>

                    @forelse($ruangan as $r)

                    <tr class="border-t hover:bg-gray-50 transition">

                        <!-- NO -->
                        <td class="p-4">
                            {{ $loop->iteration }}
                        </td>

                        <!-- NAMA -->
                        <td class="p-4 font-semibold text-gray-700">
                            {{ $r->nama_ruangan }}
                        </td>

                        <!-- KAPASITAS -->
                        <td class="p-4 text-gray-600">
                            {{ $r->kapasitas ?? '-' }} Siswa
                        </td>

                        <!-- CREATED -->
                        <td class="p-4 text-gray-500">
                            {{ $r->created_at->format('d M Y') }}
                        </td>

                        <!-- AKSI -->
                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <!-- EDIT -->
                                <a href="{{ route('admin.ruangan.edit', $r->id) }}"
                                class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition shadow-sm">
                                    Edit
                                </a>

                                <!-- HAPUS -->
                                <form action="{{ route('admin.ruangan.destroy', $r->id) }}"
                                    method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin hapus ruangan ini?')"
                                        class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600 transition shadow-sm">

                                        Hapus

                                    </button>

                                </form>

                            </div>

                        </td>

                    </tr>

                    @empty

                    <!-- EMPTY -->
                    <tr>

                        <td colspan="5" class="p-10 text-center">

                            <div class="text-5xl mb-3">
                                🏫
                            </div>

                            <div class="font-semibold text-gray-600">
                                Belum ada data ruangan
                            </div>

                            <div class="text-sm text-gray-400 mt-1">
                                Silahkan tambahkan data ruangan baru
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