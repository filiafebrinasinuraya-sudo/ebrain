@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto">

    <!-- HEADER -->
    <div class="mb-6">

        <h2 class="text-2xl font-bold text-gray-700">
            Edit User
        </h2>

        <p class="text-sm text-gray-500 mt-1">
            Ubah data akun pengguna E-Brain
        </p>

    </div>

    <!-- ERROR -->
    @if ($errors->any())

        <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-5">

            <ul class="list-disc pl-5 space-y-1">

                @foreach ($errors->all() as $error)

                    <li>{{ $error }}</li>

                @endforeach

            </ul>

        </div>

    @endif

    <!-- CARD -->
    <div class="bg-white rounded-2xl shadow border p-6">

        <!-- FORM -->
        <form action="{{ route('users.update', $user->id) }}"
              method="POST"
              class="space-y-5">

            @csrf
            @method('PUT')

            <!-- NAMA -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Nama

                </label>

                <input type="text"
                       name="name"
                       value="{{ old('name', $user->name) }}"
                       required
                       class="w-full border border-gray-300 rounded-xl px-4 py-3
                              focus:ring-2 focus:ring-blue-500
                              focus:border-blue-500 outline-none transition">

            </div>

            <!-- EMAIL -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Email

                </label>

                <input type="email"
                       name="email"
                       value="{{ old('email', $user->email) }}"
                       required
                       class="w-full border border-gray-300 rounded-xl px-4 py-3
                              focus:ring-2 focus:ring-blue-500
                              focus:border-blue-500 outline-none transition">

            </div>

            <!-- ROLE -->
            <div>

                <label class="block text-sm font-medium text-gray-700 mb-2">

                    Role

                </label>

                <select name="role"
                        required
                        class="w-full border border-gray-300 rounded-xl px-4 py-3
                               focus:ring-2 focus:ring-blue-500
                               focus:border-blue-500 outline-none transition">

                    <option value="">
                        -- Pilih Role --
                    </option>

                    <option value="admin"
                        {{ $user->role == 'admin' ? 'selected' : '' }}>

                        Admin

                    </option>

                    <option value="tentor"
                        {{ $user->role == 'tentor' ? 'selected' : '' }}>

                        Tentor

                    </option>

                    <option value="siswa"
                        {{ $user->role == 'siswa' ? 'selected' : '' }}>

                        Siswa

                    </option>

                </select>

            </div>

            <!-- BUTTON -->
            <div class="flex items-center gap-3 pt-3">

                <button type="submit"
                        class="bg-blue-600 hover:bg-blue-700
                               text-white px-6 py-3 rounded-xl transition">

                    Update User

                </button>

                <a href="/admin/users"
                   class="bg-gray-200 hover:bg-gray-300
                          text-gray-700 px-6 py-3 rounded-xl transition">

                    Kembali

                </a>

            </div>

        </form>

    </div>

</div>

@endsection