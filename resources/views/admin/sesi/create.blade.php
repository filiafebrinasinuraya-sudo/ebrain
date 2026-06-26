@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-700">
            Tambah Sesi
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan sesi pembelajaran baru untuk jadwal bimbingan belajar
        </p>
    </div>

    <!-- CARD -->
    <div class="bg-white shadow-lg rounded-2xl p-8">

        <form action="{{ route('admin.sesi.store') }}" method="POST">
        @csrf

            <!-- NAMA SESI -->
            <div class="mb-5">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nama Sesi
                </label>

                <input type="text"
                       name="nama_sesi"
                       value="{{ old('nama_sesi') }}"
                       placeholder="Contoh: Sesi 1"
                       class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>

            </div>

            <!-- JAM MULAI -->
            <div class="mb-5">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Jam Mulai
                </label>

                <input type="time"
                       name="jam_mulai"
                       value="{{ old('jam_mulai') }}"
                       class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>

            </div>

            <!-- JAM SELESAI -->
            <div class="mb-6">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Jam Selesai
                </label>

                <input type="time"
                       name="jam_selesai"
                       value="{{ old('jam_selesai') }}"
                       class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('admin.sesi.index') }}"
                   class="px-5 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition font-medium">
                    Batal
                </a>

                <button type="submit"
                    class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition shadow-md font-medium">
                    Simpan
                </button>

            </div>

        </form>

    </div>

</div>

@endsection