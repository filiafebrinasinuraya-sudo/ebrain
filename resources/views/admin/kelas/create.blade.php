@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto ">

    {{-- HEADER --}}
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-800">

            Tambah Kelas

        </h2>

        <p class="text-sm text-gray-500 mt-1">

            Tambahkan data kelas dan  hari belajar

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

    {{-- FORM --}}
    <form action="/admin/kelas"
          method="POST"
          class="bg-white border border-gray-200 rounded-2xl shadow-sm p-6 space-y-5">

        @csrf

        {{-- PROGRAM --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-2">

                Program

            </label>

            <select name="program_id"
                    class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                    required>

                <option value="">
                    -- Pilih Program --
                </option>

                @foreach($program as $p)

                    <option value="{{ $p->id }}"
                        {{ old('program_id') == $p->id ? 'selected' : '' }}>

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
                   value="{{ old('nama_kelas') }}"
                   class="w-full border border-gray-300 rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-blue-500 focus:outline-none"
                   placeholder=""
                   required>

        </div>

        {{-- HARI BELAJAR --}}
        <div>

            <label class="block text-sm font-semibold text-gray-700 mb-3">

                Hari Belajar 

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

                               {{ is_array(old('hari_belajar')) && in_array($h, old('hari_belajar')) ? 'checked' : '' }}>

                        <span class="text-sm text-gray-700">

                            {{ $h }}

                        </span>

                    </label>

                @endforeach

            </div>

        </div>

        {{-- BUTTON --}}
        <div class="flex justify-end gap-3 pt-2">

            <a href="/admin/kelas"
               class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-5 py-3 rounded-xl text-sm font-medium transition">

                Kembali

            </a>

            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl text-sm font-medium transition">

                Simpan 

            </button>

        </div>

    </form>

</div>

@endsection