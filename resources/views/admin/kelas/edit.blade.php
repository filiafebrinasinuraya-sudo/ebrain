@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    {{-- HEADER --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">

            Edit Kelas

        </h2>

        <p class="text-sm text-gray-500 mt-1">

            Update data kelas dan hari belajar

        </p>

    </div>

    {{-- ERROR --}}
    @if ($errors->any())

        <div class="bg-red-100 border border-red-200 text-red-700 px-4 py-3 rounded-xl mb-4">

            <ul class="list-disc ml-5 text-sm">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    @php

        $hariTerpilih = $kelas->hari_belajar
            ? explode(',', $kelas->hari_belajar)
            : [];

    @endphp

    {{-- FORM --}}
    <form action="/admin/kelas/{{ $kelas->id }}"
          method="POST"
          class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-5">

        @csrf
        @method('PUT')

        {{-- PROGRAM --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">

                Program

            </label>

            <select name="program_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>

                @foreach($program as $p)

                    <option value="{{ $p->id }}"
                        {{ old('program_id', $kelas->program_id) == $p->id ? 'selected' : '' }}>

                        {{ $p->nama_program }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- NAMA KELAS --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">

                Nama Kelas

            </label>

            <input type="text"
                   name="nama_kelas"
                   value="{{ old('nama_kelas', $kelas->nama_kelas) }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   required>

        </div>

        {{-- HARI BELAJAR --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">

                Hari Belajar Default

            </label>

            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">

                @php

                    $hari = [
                        'Senin',
                        'Selasa',
                        'Rabu',
                        'Kamis',
                        'Jumat',
                        'Sabtu'
                    ];

                @endphp

                @foreach($hari as $h)

                    <label class="flex items-center gap-3 border border-gray-200 rounded-xl px-4 py-3 hover:bg-gray-50 transition cursor-pointer">

                        <input type="checkbox"
                               name="hari_belajar[]"
                               value="{{ $h }}"
                               class="rounded border-gray-300 text-blue-600 focus:ring-blue-500"

                               {{ in_array($h, old('hari_belajar', $hariTerpilih)) ? 'checked' : '' }}>

                        <span class="text-sm text-gray-700">

                            {{ $h }}

                        </span>

                    </label>

                @endforeach

            </div>

            <p class="text-xs text-gray-400 mt-2">

                Hari belajar ini hanya sebagai default/rekomendasi jadwal kelas.

            </p>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-2">

            <a href="/admin/kelas"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl text-sm font-medium transition">

                Kembali

            </a>

            <button type="submit"
                    class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">
                Update 

            </button>

        </div>

    </form>

</div>

@endsection