@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <div>
        <h2 class="text-xl font-bold text-gray-700">Data Tentor</h2>
        <p class="text-sm text-gray-500">
            Kelola semua data tentor E-Brain
        </p>
    </div>

    <a href="/admin/tentor/create"
        class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-2.5 rounded-xl hover:bg-orange-600 transition shadow-sm">

            <span>Tambah Tentor</span>

        </a>
</div>

<!-- SEARCH -->
<form method="GET" action="/admin/tentor" class="mb-4">
    <div class="flex gap-2">

        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama / email tentor..."
               class="w-full md:w-1/3 p-2 border rounded-lg">

        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg">
            🔍 Cari
        </button>

        @if(request('search'))
        <a href="/admin/tentor"
           class="px-4 py-2 bg-gray-200 rounded-lg">
            Reset
        </a>
        @endif

    </div>
</form>

<div class="bg-white shadow rounded-lg overflow-x-auto">

    <table class="min-w-full text-sm">

        <thead class="bg-gray-100 text-gray-600">
            <tr>
                <th class="p-3">No</th>
                <th class="p-3">Nama Tentor</th>
                <th class="p-3">Inisial</th>
                <th class="p-3">Kontak</th>
                <th class="p-3">Jenis Kelamin</th>
                <th class="p-3">Pendidikan</th>
                <th class="p-3">Jurusan</th>
                <th class="p-3">Alamat</th>
                <th class="p-3">Status</th>
                <th class="p-3 text-center">Aksi</th>
            </tr>
        </thead>

        <tbody>

        @forelse($tentor as $t)
        <tr class="border-t hover:bg-gray-50">

            <!-- NO -->
            <td class="p-3">
                {{ ($tentor->currentPage() - 1) * $tentor->perPage() + $loop->iteration }}
            </td>

            <!-- TENTOR -->
            <td class="p-3">
                <div class="flex items-center gap-3">

                    <div>
                        <div class="font-semibold text-gray-700">
                            {{ $t->nama }}
                        </div>
                        <div class="text-xs text-gray-400">
                            {{ $t->user->email ?? '-' }}
                        </div>
                    </div>

                </div>
            </td>

            <!-- INISIAL -->
            <td class="p-3">
                {{ $t->inisial ?? '-' }}
            </td>

            <!-- KONTAK -->
            <td class="p-3">
                {{ $t->no_hp }}
            </td>

            <!-- JENIS KELAMIN -->
            <td class="p-3">
                {{ $t->jenis_kelamin }}
            </td>

            <!-- PENDIDIKAN -->
            <td class="p-3">
                {{ $t->pendidikan_terakhir }}
            </td>

            <!-- JURUSAN -->
            <td class="p-3">
                {{ $t->jurusan ?? '-' }}
            </td>

            <!-- ALAMAT -->
            <td class="p-3">
                {{ Str::limit($t->alamat, 40) ?? '-' }}
            </td>

            <!-- STATUS -->
            <td class="p-3">

                @if($t->status)

                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-green-100 text-green-700 font-semibold">
                         Aktif
                    </span>

                @else

                    <span class="inline-flex items-center gap-1 px-3 py-1 text-xs rounded-full bg-red-100 text-red-700 font-semibold">
                        Tidak Aktif
                    </span>

                @endif

            </td>

            <!-- AKSI -->
<td class="p-3 text-center">

    <div class="flex justify-center gap-2">

        <!-- EDIT -->
        <a href="/admin/tentor/{{ $t->id }}/edit"
           class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition shadow-sm">
            Edit
        </a>

        <!-- HAPUS -->
        <form action="/admin/tentor/{{ $t->id }}" method="POST">
            @csrf
            @method('DELETE')

            <button onclick="return confirm('Yakin hapus?')"
                class="px-3 py-1.5 bg-red-500 text-white rounded-lg text-xs hover:bg-red-600 transition shadow-sm">
                Hapus
            </button>
        </form>

    </div>

</td>

        </tr>

        @empty
        <tr>
            <td colspan="10" class="p-10 text-center">

                <div class="text-5xl mb-3">
                    📚
                </div>

                <div class="font-semibold text-gray-600">
                    Data tentor belum tersedia
                </div>

                <div class="text-sm text-gray-400">
                    Silahkan tambahkan data tentor baru
                </div>

            </td>
        </tr>
        @endforelse

        </tbody>

    </table>

</div>

<!-- PAGINATION -->
<div class="mt-4">
    {{ $tentor->links() }}
</div>

@endsection