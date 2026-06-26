@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-5 flex-wrap gap-3">

    <div>

        <h2 class="text-xl font-bold text-gray-700">
            Kelola User
        </h2>

        <p class="text-sm text-gray-500">
            Manajemen akun admin, tentor, dan siswa
        </p>

    </div>
</div>

<!-- SEARCH -->
<form method="GET"
      action="/admin/users"
      class="mb-4">

    <div class="flex flex-wrap gap-2">

        <!-- INPUT -->
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama, email, ..."
               class="border rounded-lg px-4 py-2 w-full md:w-1/3">

        <!-- BUTTON -->
        <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">

            Cari

        </button>

        <!-- RESET -->
        <a href="/admin/users"
           class="bg-gray-200 hover:bg-gray-300 px-4 py-2 rounded-lg">

            Reset

        </a>

    </div>

</form>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow border overflow-x-auto">

    <table class="min-w-full text-sm">

        <!-- HEADER -->
        <thead class="bg-gray-100 text-gray-600">

            <tr>

                <th class="p-3 text-left">
                    No
                </th>

                <th class="p-3 text-left">
                    Nama
                </th>

                <th class="p-3 text-left">
                    Email
                </th>

                <th class="p-3 text-left">
                    Role
                </th>

                <th class="p-3 text-center">
                    Aksi
                </th>

            </tr>

        </thead>

        <!-- BODY -->
        <tbody>

            @forelse($users as $user)

            <tr class="border-t hover:bg-gray-50 transition">

                <!-- NO -->
                <td class="p-3 text-gray-500">
                    {{ $loop->iteration }}
                </td>

                <!-- NAMA -->
                <td class="p-3">

                    <div class="font-semibold text-gray-700">
                        {{ $user->name }}
                    </div>

                </td>

                <!-- EMAIL -->
                <td class="p-3 text-gray-600">
                    {{ $user->email }}
                </td>

                <!-- ROLE -->
                <td class="p-3">

                    @if($user->role == 'admin')

                        <span class="px-3 py-1 text-xs rounded-full bg-red-100 text-red-600">
                            Admin
                        </span>

                    @elseif($user->role == 'tentor')

                        <span class="px-3 py-1 text-xs rounded-full bg-green-100 text-green-600">
                            Tentor
                        </span>

                    @else

                        <span class="px-3 py-1 text-xs rounded-full bg-blue-100 text-blue-600">
                            Siswa
                        </span>

                    @endif

                </td>

                <!-- AKSI -->
                <td class="p-3">

                    <div class="flex justify-center gap-2 flex-wrap">


                        <!-- EDIT -->
                        <a href="{{ route('users.edit', $user->id) }}"
                           class="text-blue-600 hover:text-blue-800 text-sm">

                            Edit

                        </a>

                        <!-- RESET -->
                        <a href="{{ route('admin.users.reset-password', $user->id) }}"
                           onclick="return confirm('Reset password user ini?')"
                           class="text-yellow-600 hover:text-yellow-800 text-sm">

                            Reset

                        </a>


                    </div>

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5"
                    class="p-6 text-center text-gray-500">

                    Data user belum tersedia

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

</div>

@endsection