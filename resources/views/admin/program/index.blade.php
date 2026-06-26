@extends('layouts.admin')

@section('content')

<div class="flex flex-col md:flex-row md:justify-between md:items-center gap-3 mb-6">
    <h2 class="text-xl font-bold text-gray-700">Data Program</h2>

    <a href="{{ url('/admin/program/create') }}"
        class="inline-flex items-center gap-2 bg-orange-500 text-white px-5 py-3 rounded-xl hover:bg-orange-600 transition shadow-md font-medium">
        + Tambah Program
    </a>
</div>

<div class="bg-white rounded-xl shadow overflow-x-auto">

<table class="w-full text-sm">

    <thead class="bg-gray-100 text-gray-700">
        <tr>
            <th class="p-4 text-left">No</th>
            <th class="p-4 text-left">Nama Program</th>
            <th class="p-4 text-center">Aksi</th>
        </tr>
    </thead>

    <tbody>

        @forelse($program as $key => $p)
        <tr class="border-t hover:bg-gray-50 transition">

            <td class="p-4">{{ $key + 1 }}</td>

            <td class="p-4 font-medium text-gray-800">
                {{ $p->nama_program }}
            </td>

            <td class="p-4">
                <div class="flex justify-center gap-2 flex-wrap">

                    <a href="{{ url('/admin/program/'.$p->id.'/edit') }}"
                         class="px-3 py-1.5 bg-blue-500 text-white rounded-lg text-xs hover:bg-blue-600 transition shadow-sm">
                        Edit
                    </a>

                    <form action="{{ url('/admin/program/'.$p->id) }}" method="POST">
                        @csrf
                        @method('DELETE')

                        <button type="submit"
                                onclick="return confirm('Hapus program ini?')"
                                class="bg-red-500 text-white px-3 py-1 rounded text-xs hover:bg-red-600 transition">
                            Hapus
                        </button>
                    </form>

                </div>
            </td>

        </tr>
        @empty
        <tr>
            <td colspan="3" class="text-center p-8 text-gray-500">
                <div class="flex flex-col items-center">
                    <span class="text-3xl">📭</span>
                    <p class="mt-2">Belum ada data program</p>
                </div>
            </td>
        </tr>
        @endforelse

    </tbody>

</table>

</div>

@endsection