@extends('layouts.admin')

@section('content')

<div class="max-w-2xl mx-auto">

    <h2 class="text-2xl font-bold text-gray-700 mb-6">
        Edit Ruangan
    </h2>

    <div class="bg-white shadow rounded-xl p-6">

        <form action="{{ route('admin.ruangan.update', $ruangan->id) }}" method="POST">

            @csrf
            @method('PUT')

            <!-- NAMA RUANGAN -->
            <div class="mb-4">

                <label class="block mb-2 text-sm font-medium text-gray-700">
                    Nama Ruangan
                </label>

                <input type="text"
                       name="nama_ruangan"
                       value="{{ old('nama_ruangan', $ruangan->nama_ruangan) }}"
                       class="w-full border rounded-lg p-3"
                       placeholder="Masukkan nama ruangan"
                       required>

            </div>

            <!-- KAPASITAS -->
            <div class="mb-6">

                <label class="block mb-2 text-sm font-medium text-gray-700">
                    Kapasitas
                </label>

                <input type="number"
                       name="kapasitas"
                       value="{{ old('kapasitas', $ruangan->kapasitas) }}"
                       class="w-full border rounded-lg p-3"
                       placeholder="Masukkan kapasitas">

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">

                <a href="{{ route('admin.ruangan.index') }}"
                   class="px-5 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">

                    Kembali

                </a>

                <button type="submit"
                    class="px-5 py-2 bg-orange-500 text-white rounded-lg hover:bg-orange-600">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

@endsection