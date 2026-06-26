@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-700">
            Edit Program
        </h2>

    </div>

    <!-- CARD -->
    <div class="bg-white shadow-lg rounded-2xl p-8">

        <form action="/admin/program/{{ $program->id }}" method="POST">

        @csrf
        @method('PUT')

            <!-- NAMA PROGRAM -->
            <div class="mb-6">

                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nama Program
                </label>

                <input type="text"
                       name="nama_program"
                       value="{{ old('nama_program', $program->nama_program) }}"
                       placeholder="Masukkan nama program"
                       class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                       required>

            </div>

            <!-- BUTTON -->
            <div class="flex justify-end gap-3">

                <!-- KEMBALI -->
                <a href="/admin/program"
                   class="px-5 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition font-medium">

                    Kembali

                </a>

                <!-- UPDATE -->
                <button type="submit"
                    class="px-6 py-3 bg-orange-500 hover:bg-orange-600 text-white rounded-xl transition shadow-md font-medium">

                    Update

                </button>

            </div>

        </form>

    </div>

</div>

@endsection