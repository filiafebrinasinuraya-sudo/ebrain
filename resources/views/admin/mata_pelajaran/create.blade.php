@extends('layouts.admin')

@section('content')

<div class="max-w-xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-xl font-bold mb-1">
        Tambah Mata Pelajaran
    </h2>

    <p class="text-sm text-gray-500 mb-6">
        Isi data mata pelajaran
    </p>

    <form action="{{ route('admin.mata_pelajaran.store') }}"
          method="POST">

        @csrf

        <!-- NAMA -->
        <div class="mb-4">

            <label class="block mb-1 text-sm font-medium text-gray-700">
                Nama Mata Pelajaran
            </label>

            <input type="text"
                   name="nama_mapel"
                   value="{{ old('nama_mapel') }}"
                   class="w-full border p-2 rounded-lg"
                   placeholder=""
                   required>

        </div>

        <!-- SINGKATAN -->
        <div class="mb-4">

            <label class="block mb-1 text-sm font-medium text-gray-700">
                Singkatan
            </label>

            <input type="text"
                   name="singkatan"
                   value="{{ old('singkatan') }}"
                   class="w-full border p-2 rounded-lg"
                   placeholder=""
                   required>

        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-2">

            <a href="{{ route('admin.mata_pelajaran.index') }}"
               class="px-4 py-2 bg-gray-200 rounded-lg">
                Batal
            </a>

            <button type="submit"
                     class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">
                Simpan
            </button>

        </div>

    </form>

</div>

@endsection