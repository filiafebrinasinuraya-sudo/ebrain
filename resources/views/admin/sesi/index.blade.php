@extends('layouts.admin')

@section('content')

<div class="max-w-6xl mx-auto">

    <!-- HEADER -->
    <div class="flex justify-between items-center mb-6">

        <div>
            <h2 class="text-2xl font-bold text-gray-700">
                Data Sesi
            </h2>

            <p class="text-sm text-gray-500 mt-1">
                Kelola sesi pembelajaran bimbingan belajar
            </p>
        </div>

        <!-- BUTTON TAMBAH -->
        <a href="{{ route('admin.sesi.create') }}"
           class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">

            <span class="text-lg">+</span>
            <span>Tambah Sesi</span>

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
                        <th class="p-4 text-left">Nama Sesi</th>
                        <th class="p-4 text-left">Jam Pembelajaran</th>
                        <th class="p-4 text-center">Status</th>
                        <th class="p-4 text-center">Aksi</th>
                    </tr>

                </thead>

                <!-- BODY -->
                <tbody>

                    @forelse($sesi as $s)

                    <tr class="border-t hover:bg-gray-50 transition">

                        <!-- NO -->
                        <td class="p-4">
                            {{ $loop->iteration }}
                        </td>

                        <!-- NAMA -->
                        <td class="p-4 font-semibold text-gray-700">
                            {{ $s->nama_sesi }}
                        </td>

                        <!-- JAM -->
                        <td class="p-4 text-gray-600">
                            {{ $s->jam_mulai }} - {{ $s->jam_selesai }}
                        </td>

                        <!-- STATUS -->
                        <td class="p-4 text-center">

                            @if($s->aktif)

                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                                    ● Aktif
                                </span>

                            @else

                                <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                                    ● Nonaktif
                                </span>

                            @endif

                        </td>

                        <!-- AKSI -->
                        <td class="p-4">

                            <div class="flex justify-center gap-2">

                                <!-- EDIT -->
                                <a href="{{ route('admin.sesi.edit', $s->id) }}"
                                   class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition shadow-sm">
                                    Edit
                                </a>

                                <!-- HAPUS -->
                                <form action="{{ route('admin.sesi.destroy', $s->id) }}"
                                      method="POST">

                                    @csrf
                                    @method('DELETE')

                                    <button onclick="return confirm('Yakin ingin menghapus data ini?')"
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
                                ⏰
                            </div>

                            <div class="font-semibold text-gray-600">
                                Data sesi belum tersedia
                            </div>

                            <div class="text-sm text-gray-400 mt-1">
                                Silahkan tambahkan sesi pembelajaran baru
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