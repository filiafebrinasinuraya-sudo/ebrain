@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-5">
    <div>
        <h2 class="text-xl font-bold text-gray-700">Data Siswa</h2>
        <p class="text-sm text-gray-500">Kelola semua data siswa E-Brain</p>
    </div>

    <a href="/admin/siswa/create"
       class="bg-orange-500 text-white px-4 py-2 rounded-lg hover:bg-orange-600 transition">
        + Tambah Siswa
    </a>
</div>

<!-- 🔍 SEARCH + FILTER -->
<form method="GET" action="/admin/siswa" class="mb-4">
    <div class="flex flex-wrap gap-2">

        <!-- SEARCH -->
        <input type="text"
               name="search"
               value="{{ request('search') }}"
               placeholder="Cari nama / email..."
               class="p-2 border rounded-lg w-full md:w-1/3">

        <!-- FILTER KELAS -->
        <select name="kelas" class="p-2 border rounded-lg">
            <option value="">Semua Kelas</option>
            @foreach($kelas as $k)
                <option value="{{ $k->id }}"
                    {{ request('kelas') == $k->id ? 'selected' : '' }}>
                    {{ $k->nama_kelas }}
                </option>
            @endforeach
        </select>

        <!-- BUTTON -->
        <button class="px-4 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600">
            Filter
        </button>

        <!-- RESET -->
        <a href="/admin/siswa"
           class="px-4 py-2 bg-gray-200 rounded-lg hover:bg-gray-300">
            Reset
        </a>

    </div>
</form>

<!-- TABLE -->
<div class="bg-white rounded-xl shadow border overflow-x-auto">

<table class="min-w-full text-sm">

    <thead class="bg-gray-100 text-gray-600">
        <tr>
            <th class="p-3">Siswa</th>
            <th class="p-3">Kontak</th>
            <th class="p-3">Sekolah</th>
            <th class="p-3">Kelas</th>
            <th class="p-3">Orang Tua</th>
            <th class="p-3">Status</th>
            <th class="p-3 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>

    @forelse($siswa as $s)
    <tr class="border-t hover:bg-gray-50 transition">

        <!-- SISWA -->
        <td class="p-3">
            <div class="font-semibold text-gray-700">
                {{ $s->nama }}
            </div>
            <div class="text-xs text-gray-500">
                {{ $s->jenis_kelamin }} • {{ $s->agama }}
            </div>
            <div class="text-xs text-gray-400">
                {{ $s->tempat_lahir }}, {{ $s->tanggal_lahir?->format('d-m-Y') }}
            </div>
        </td>

        <!-- KONTAK -->
        <td class="p-3">
            <div>{{ $s->no_hp }}</div>
            <div class="text-xs text-gray-400">
                {{ $s->user->email ?? '-' }}
            </div>
        </td>

        <!-- SEKOLAH -->
        <td class="p-3">
            <div>{{ $s->asal_sekolah }}</div>
            <div class="text-xs text-gray-500">
                {{ $s->kurikulum ?? '-' }}
            </div>
        </td>

        <!-- KELAS -->
        <td class="p-3">
            <div class="text-xs text-gray-600">
                Sekolah: {{ $s->kelas_sekolah ?? '-' }}
            </div>

            <div class="mt-1 flex flex-wrap gap-1">
                @if($s->kelas->count())
                    @foreach($s->kelas as $k)
                        <span class="px-2 py-1 text-xs bg-blue-100 text-blue-600 rounded">
                            {{ $k->nama_kelas }}
                        </span>
                    @endforeach
                @else
                    <span class="text-xs text-gray-400">Belum assign</span>
                @endif
            </div>

            <div class="text-xs text-gray-500 mt-1">
                Ranking: {{ $s->ranking ?? '-' }}
            </div>
        </td>

        <!-- ORANG TUA -->
        <td class="p-3 text-xs">
            <div><b>Ayah:</b> {{ $s->nama_ayah }}</div>
            <div class="text-gray-500">{{ $s->pekerjaan_ayah }}</div>

            <div class="mt-1"><b>Ibu:</b> {{ $s->nama_ibu }}</div>
            <div class="text-gray-500">{{ $s->pekerjaan_ibu }}</div>
        </td>

        <!-- STATUS -->
        <td class="p-3">
            <span class="px-2 py-1 text-xs rounded-full
                {{ $s->status == 'Aktif' ? 'bg-green-100 text-green-600' : 'bg-red-100 text-red-600' }}">
                {{ $s->status }}
            </span>
        </td>

        <!-- AKSI -->
        <td class="p-3 text-center space-y-1">

            <a href="/admin/siswa/{{ $s->id }}"
               class="text-gray-700 hover:underline block">
                Detail
            </a>

            <a href="/admin/siswa/{{ $s->id }}/edit"
               class="text-blue-600 hover:underline block">
                Edit
            </a>

            <form action="/admin/siswa/{{ $s->id }}" method="POST">
                @csrf
                @method('DELETE')

                <button onclick="return confirm('Yakin hapus?')"
                    class="text-red-600 hover:underline">
                    Hapus
                </button>
            </form>

        </td>

    </tr>

    @empty
    <tr>
        <td colspan="7" class="p-6 text-center text-gray-500">
            Data siswa tidak ditemukan
        </td>
    </tr>
    @endforelse

    </tbody>

</table>

</div>

<!-- PAGINATION -->
<div class="mt-4">
    {{ $siswa->links() }}
</div>

@endsection