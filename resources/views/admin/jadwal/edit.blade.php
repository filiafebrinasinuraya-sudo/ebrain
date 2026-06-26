@extends('layouts.admin')

@section('content')

<div class="max-w-3xl mx-auto bg-white p-6 rounded-xl shadow">

    <h2 class="text-2xl font-bold mb-6 text-gray-700">
        Edit Jadwal
    </h2>
    
    @if($jadwal->periode)

    <div class="mb-5 bg-blue-50 border border-blue-200 rounded-xl p-4">

        <div class="text-sm text-blue-700">

            Periode Jadwal

        </div>

        <div class="font-semibold text-blue-900 mt-1">

            {{ $jadwal->periode->tahun_ajaran }}
            -
            Semester {{ $jadwal->periode->semester }}

        </div>

        <div class="text-sm text-blue-700 mt-1">

            {{ \Carbon\Carbon::parse($jadwal->periode->tanggal_mulai)->format('d M Y') }}
            -
            {{ \Carbon\Carbon::parse($jadwal->periode->tanggal_selesai)->format('d M Y') }}

        </div>

    </div>

@endif

    <form action="{{ route('jadwal.update', $jadwal->id) }}" method="POST">
        @csrf
        @method('PUT')

        <input type="hidden"
        name="periode_id"
        value="{{ $jadwal->periode_id }}">

        <!-- KELAS -->
        <div class="mb-4">

            <label class="block mb-1 font-medium">
                Kelas
            </label>

            <select name="kelas_id"
                    class="w-full border p-2 rounded-lg">

                @foreach($kelas as $k)

                    <option value="{{ $k->id }}"
                        {{ $jadwal->kelas_id == $k->id ? 'selected' : '' }}>

                        {{ $k->nama_kelas }}

                    </option>

                @endforeach

            </select>

            @if($jadwal->kelas)

            <div class="mt-2 text-xs text-blue-600">

                Hari belajar kelas:
                {{ $jadwal->kelas->hari_belajar ?? '-' }}

            </div>

            @endif

        </div>

        <!-- HARI -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Hari</label>
            <select name="hari" class="w-full border p-2 rounded-lg">
                @foreach(['Senin','Selasa','Rabu','Kamis','Jumat','Sabtu'] as $hari)
                    <option value="{{ $hari }}"
                        {{ $jadwal->hari == $hari ? 'selected' : '' }}>
                        {{ $hari }}
                    </option>
                @endforeach
            </select>
        </div>

        <select name="sesi_id" class="w-full border p-2 rounded">

            @foreach($sesi as $s)

                <option value="{{ $s->id }}"
                    {{ $jadwal->sesi_id == $s->id ? 'selected' : '' }}>

                    {{ $s->nama_sesi }}
                    ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})

                </option>

            @endforeach

        </select>

        <!-- MAPEL (RELASI) -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Mata Pelajaran</label>
            <select name="mata_pelajaran_id" class="w-full border p-2 rounded-lg">
                @foreach($mapel as $m)
                    <option value="{{ $m->id }}"
                        {{ $jadwal->mata_pelajaran_id == $m->id ? 'selected' : '' }}>
                        {{ $m->nama_mapel }} ({{ $m->kode_mapel }})
                    </option>
                @endforeach
            </select>
        </div>

        <!-- TENTOR (RELASI) -->
        <div class="mb-4">
            <label class="block mb-1 font-medium">Tentor</label>
            <select name="tentor_id"
                class="w-full border p-2 rounded"
                required>

            @foreach($tentor as $t)

                <option value="{{ $t->id }}"
                    {{ $jadwal->tentor_id == $t->id ? 'selected' : '' }}>

                    {{ $t->nama }}

                </option>

            @endforeach

        </select>
        </div>

        <!-- RUANGAN -->
        <div class="mb-6">
            <label class="block mb-1 font-medium">Ruangan</label>
            <select name="ruangan_id" class="w-full border p-2 rounded-lg">
                @foreach($ruangan as $r)
                    <option value="{{ $r->id }}"
                        {{ $jadwal->ruangan_id == $r->id ? 'selected' : '' }}>
                        {{ $r->nama_ruangan }}
                    </option>
                @endforeach
            </select>
        </div>

        <!-- BUTTON -->
        <div class="flex gap-2">
            <button class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg">
                Update Jadwal
            </button>

            <a href="{{ route('jadwal.index') }}"
               class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                Batal
            </a>
        </div>

    </form>

</div>

@endsection