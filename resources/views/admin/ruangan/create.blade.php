@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-1">Tambah Ruangan</h2>
    <p class="text-sm text-gray-500 mb-6">
        Isi data ruangan untuk jadwal belajar
    </p>

    <form action="{{ route('admin.ruangan.store') }}" method="POST">
        @csrf

        <!-- NAMA RUANGAN -->
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">
                Nama Ruangan
            </label>

            <input type="text"
                   name="nama_ruangan"
                   value="{{ old('nama_ruangan') }}"
                   class="w-full border p-2 rounded-lg focus:ring focus:ring-blue-200"
                   placeholder=""
                   required>

            @error('nama_ruangan')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- KAPASITAS -->
        <div class="mb-4">
            <label class="block mb-1 text-sm font-medium text-gray-700">
                Kapasitas Ruangan
            </label>

            <input type="number"
                   name="kapasitas"
                   value="{{ old('kapasitas') }}"
                   min="1"
                   class="w-full border p-2 rounded-lg focus:ring focus:ring-blue-200"
                   placeholder="">

            @error('kapasitas')
                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-2">

            <a href="{{ route('admin.ruangan.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
                Batal
            </a>

            <button type="submit"
                    class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection