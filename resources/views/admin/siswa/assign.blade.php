@extends('layouts.admin')

@section('content')

<div class="flex justify-between items-center mb-6">
    <h2 class="text-xl font-bold text-gray-700">
        Assign Kelas ke Siswa
    </h2>

    <a href="/admin/siswa"
       class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300">
        ← Kembali
    </a>
</div>

{{-- ===================== --}}
{{-- DATA SISWA --}}
{{-- ===================== --}}
<div class="bg-white p-5 rounded-xl shadow mb-6">
    <h3 class="font-semibold text-gray-700 mb-2">Data Siswa</h3>

    <p><b>Nama:</b> {{ $siswa->nama }}</p>
    <p><b>No HP:</b> {{ $siswa->no_hp }}</p>
    <p><b>Sekolah:</b> {{ $siswa->asal_sekolah }}</p>
</div>

{{-- ===================== --}}
{{-- KELAS YANG SUDAH DIAMBIL --}}
{{-- ===================== --}}
<div class="bg-white p-5 rounded-xl shadow mb-6">
    <h3 class="font-semibold text-gray-700 mb-3">Kelas Yang Sudah Diambil</h3>

    @if($siswa->kelas->count() > 0)
        <ul class="list-disc pl-5">
            @foreach($siswa->kelas as $kls)
                <li>
                    {{ $kls->nama_kelas }}
                </li>
            @endforeach
        </ul>
    @else
        <p class="text-gray-500">Belum ada kelas</p>
    @endif
</div>

{{-- ===================== --}}
{{-- FORM ASSIGN KELAS --}}
{{-- ===================== --}}
<div class="bg-white p-5 rounded-xl shadow">

    <h3 class="font-semibold text-gray-700 mb-4">Tambah Kelas</h3>

    <form action="{{ url('/admin/siswa/'.$siswa->id.'/assign') }}" method="POST">
        @csrf

        <div class="mb-4">
            <label class="block text-sm mb-1">Pilih Kelas</label>

            <select name="kelas_id" class="w-full border p-2 rounded-lg" required>
                <option value="">-- Pilih Kelas --</option>

                @foreach($kelas as $kls)
                    <option value="{{ $kls->id }}">
                        {{ $kls->nama_kelas }}
                    </option>
                @endforeach

            </select>
        </div>

        <button type="submit"
            class="bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">
            Assign Kelas
        </button>

    </form>

</div>

@endsection