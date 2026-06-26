@extends('layouts.admin')

@section('content')

<div class="max-w-5xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">
        <h2 class="text-2xl font-bold text-gray-700">
            Tambah Data Tentor
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Tambahkan data tentor baru untuk bimbingan belajar E-Brain
        </p>
    </div>

    <!-- ERROR -->
    @if ($errors->any())
    <div class="mb-4 bg-red-100 border border-red-300 text-red-700 px-4 py-3 rounded-lg">
        <ul class="list-disc ml-5 text-sm">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif

    <!-- CARD -->
    <div class="bg-white shadow-lg rounded-2xl p-8">

        <form action="/admin/tentor" method="POST">
        @csrf

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- NAMA -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nama Tentor
                </label>

                <input type="text"
                    name="nama"
                    value="{{ old('nama') }}"
                    placeholder=""
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>
            </div>

            <div>
                <label class="block mb-1">Inisial</label>
                <input type="text"
                    name="inisial"
                    value="{{ old('inisial') }}"
                    class="w-full border rounded-lg p-2"
                    placeholder="">
            </div>
            
            <!-- EMAIL -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Email
                </label>

                <input type="email"
                    name="email"
                    value="{{ old('email') }}"
                    placeholder=""
                    autocomplete="off"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>
            </div>

            <!-- PASSWORD -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Password
                </label>

                <input type="password"
                    name="password"
                    placeholder=""
                    autocomplete="new-password"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>
            </div>

            <!-- NO HP -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Nomor HP
                </label>

                <input type="text"
                    name="no_hp"
                    value="{{ old('no_hp') }}"
                    placeholder=""
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>
            </div>

            <!-- JENIS KELAMIN -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Jenis Kelamin
                </label>

                <select name="jenis_kelamin"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>

                    <option value=""></option>

                    <option value="Laki-laki"
                        {{ old('jenis_kelamin') == 'Laki-laki' ? 'selected' : '' }}>
                        Laki-laki
                    </option>

                    <option value="Perempuan"
                        {{ old('jenis_kelamin') == 'Perempuan' ? 'selected' : '' }}>
                        Perempuan
                    </option>

                </select>
            </div>

            <!-- PENDIDIKAN -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Pendidikan Terakhir
                </label>

                <select name="pendidikan_terakhir"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>

                    <option value="">  </option>

                    <option value="D3" {{ old('pendidikan_terakhir') == 'D3' ? 'selected' : '' }}>
                        D3
                    </option>

                    <option value="D4" {{ old('pendidikan_terakhir') == 'D4' ? 'selected' : '' }}>
                        D4
                    </option>

                    <option value="S1" {{ old('pendidikan_terakhir') == 'S1' ? 'selected' : '' }}>
                        S1
                    </option>

                    <option value="S2" {{ old('pendidikan_terakhir') == 'S2' ? 'selected' : '' }}>
                        S2
                    </option>

                </select>
            </div>

            <!-- JURUSAN -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Jurusan
                </label>

                <input type="text"
                    name="jurusan"
                    value="{{ old('jurusan') }}"
                    placeholder=""
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none">
            </div>

            <!-- STATUS -->
            <div>
                <label class="block mb-2 text-sm font-semibold text-gray-700">
                    Status
                </label>

                <select name="status"
                    class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none"
                    required>

                    <option value=""></option>

                    <option value="1"
                        {{ old('status') == '1' ? 'selected' : '' }}>
                        Aktif
                    </option>

                    <option value="0"
                        {{ old('status') == '0' ? 'selected' : '' }}>
                        Tidak Aktif
                    </option>

                </select>
            </div>

        </div>

        <!-- ALAMAT -->
        <div class="mt-6">
            <label class="block mb-2 text-sm font-semibold text-gray-700">
                Alamat
            </label>

            <textarea name="alamat"
                rows="4"
                placeholder=""
                class="w-full border border-gray-300 rounded-xl p-3 focus:ring-2 focus:ring-orange-400 focus:outline-none">{{ old('alamat') }}</textarea>
        </div>

        <!-- BUTTON -->
        <div class="flex justify-end gap-3 mt-8">

            <!-- BATAL -->
            <a href="/admin/tentor"
            class="inline-flex items-center px-5 py-3 bg-gray-200 text-gray-700 rounded-xl hover:bg-gray-300 transition font-medium">

                Batal
            </a>

            <!-- SIMPAN -->
            <button type="submit"
                class="inline-flex items-center gap-2 px-6 py-3 bg-orange-500 text-white rounded-xl hover:bg-orange-600 transition shadow-md font-medium">

                Simpan Data
            </button>

        </div>

        </form>

    </div>

</div>

@endsection