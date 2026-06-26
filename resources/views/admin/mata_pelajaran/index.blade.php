@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-700">
                Data Mata Pelajaran
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola data mata pelajaran 
            </p>
        </div>

        <!-- BUTTON TAMBAH -->
        <a href="{{ route('admin.mata_pelajaran.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">

            <span class="text-lg">+</span>
            <span>Tambah Mata Pelajaran</span>

        </a>

    </div>

    <!-- CARD TABLE -->
    <div class="bg-white shadow-lg rounded-2xl overflow-hidden">

        <div class="overflow-x-auto">

            <table class="min-w-full text-sm">

                <!-- HEADER TABLE -->
                <thead class="bg-gray-100 text-gray-600">

                    <tr>
                        <th class="p-3 text-left w-16">No</th>
                        <th class="p-3 text-left">Nama Mata Pelajaran</th>
                        <th class="p-3 text-left">Singkatan</th>
                        <th class="p-3 text-center">Aksi</th>
                    </tr>

                </thead>

                <!-- BODY -->
                <tbody class="divide-y divide-gray-100">

                    @forelse($mata_pelajaran as $m)

                    <tr class="hover:bg-gray-50 transition">

                        <!-- NO -->
                        <td class="p-3">
                            {{ $loop->iteration }}
                        </td>

                        <!-- NAMA MAPEL -->
                        <td class="p-3 font-medium text-gray-700">
                            {{ $m->nama_mapel }}
                        </td>

                        <!-- SINGKATAN -->
                        <td class="p-3">

                            <span class="bg-blue-100 text-blue-700 px-2 py-1 rounded text-xs">
                                {{ $m->singkatan }}
                            </span>

                        </td>

                        <!-- AKSI -->
                        <td class="p-3 text-center">

                            <div class="flex justify-center gap-2">

                                <!-- EDIT -->
                                <a href="{{ route('admin.mata_pelajaran.edit', $m->id) }}"
                                   class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition shadow-sm">

                                    Edit

                                </a>

                                <!-- HAPUS -->
                                <form action="{{ route('admin.mata_pelajaran.destroy', $m->id) }}"
                                      method="POST"
                                      class="inline">

                                    @csrf
                                    @method('DELETE')

                                    <button type="submit"
                                            onclick="return confirm('Yakin hapus data ini?')"
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

                        <td colspan="4"
                            class="p-10 text-center">

                            <div class="text-5xl mb-3">
                                📚
                            </div>

                            <div class="font-semibold text-gray-600">
                                Belum ada data mata pelajaran
                            </div>

                            <div class="text-sm text-gray-400 mt-1">
                                Silahkan tambahkan data mata pelajaran baru
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