@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <div class="bg-white rounded-3xl shadow-sm border border-gray-100 p-6">

        <h1 class="text-2xl font-bold text-gray-800 mb-6">
            Edit Nilai Quiz
        </h1>

        <form action="{{ route('quiz.update', $nilai->id) }}"
              method="POST">

            @csrf
            @method('PUT')

            {{-- Nama Siswa --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Siswa
                </label>

                <input type="text"
                       value="{{ $nilai->siswa->nama }}"
                       class="w-full rounded-xl border-gray-300 bg-gray-100"
                       readonly>

            </div>

            {{-- Quiz --}}
            <div class="mb-5">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Quiz
                </label>

                <input type="text"
                       value="{{ $nilai->quiz->judul }}"
                       class="w-full rounded-xl border-gray-300 bg-gray-100"
                       readonly>

            </div>

            {{-- Nilai --}}
            <div class="mb-6">

                <label class="block text-sm font-medium text-gray-700 mb-2">
                    Nilai
                </label>

                <input type="number"
                       name="nilai"
                       value="{{ $nilai->nilai }}"
                       min="0"
                       max="100"
                       class="w-full rounded-xl border-gray-300">

                @error('nilai')
                    <p class="text-red-500 text-sm mt-2">
                        {{ $message }}
                    </p>
                @enderror

            </div>

            <div class="flex gap-3">

                <a href="{{ url()->previous() }}"
                   class="px-5 py-3 rounded-xl bg-gray-200 text-gray-700 font-semibold">

                    Kembali

                </a>

                <button type="submit"
                        class="px-5 py-3 rounded-xl bg-blue-600 text-white font-semibold">

                    Simpan Perubahan

                </button>

            </div>

        </form>

    </div>

</div>

@endsection