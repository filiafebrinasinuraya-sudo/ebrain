@extends('layouts.admin')

@section('content')

<div class="mb-6">

    <h2 class="text-2xl font-bold text-gray-800">
        Tambah Jadwal
    </h2>

    <p class="text-sm text-gray-500">
        Tambahkan jadwal ke periode aktif
    </p>

</div>



{{-- VALIDATION --}}
@if ($errors->any())

    <div class="bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl mb-4">

        <ul class="list-disc ml-5">

            @foreach ($errors->all() as $error)

                <li>{{ $error }}</li>

            @endforeach

        </ul>

    </div>

@endif

<form action="{{ route('jadwal.store') }}"
      method="POST"
      class="bg-white p-6 rounded-2xl shadow">

    @csrf

    {{-- ================= PERIODE ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Periode Aktif
        </label>

        <div class="w-full border border-gray-300 p-3 rounded-xl bg-gray-100 text-gray-700">

            {{ $periodeAktif->tahun_ajaran ?? '-' }}
            -
            Semester {{ $periodeAktif->semester ?? '-' }}

        </div>

        <input type="hidden"
               name="periode_id"
               value="{{ $periodeAktif->id ?? '' }}">

    </div>

    {{-- ================= KELAS ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Kelas
        </label>

        <select name="kelas_id"
                id="kelasSelect"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Kelas
            </option>

            @foreach($kelas as $k)

                <option value="{{ $k->id }}"
                        data-hari="{{ $k->hari_belajar }}">

                    {{ $k->nama_kelas }}

                </option>

            @endforeach

        </select>

    </div>

    {{-- ================= HARI ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Hari
        </label>

        <select name="hari"
                id="hariSelect"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Hari
            </option>

            @if(request('hari'))

                <option value="{{ request('hari') }}"
                        selected>

                    {{ request('hari') }}

                </option>

            @endif

        </select>

        <p class="text-xs text-gray-500 mt-2">
            Hari otomatis mengikuti jadwal belajar kelas
        </p>

    </div>

    {{-- ================= RUANGAN ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Ruangan
        </label>

        <select name="ruangan_id"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Ruangan
            </option>

           @foreach($ruangan as $r)

                <option value="{{ $r->id }}"

                    {{ (string) request('ruangan_id') === (string) $r->id
                        ? 'selected'
                        : ''
                    }}>

                    {{ $r->nama_ruangan }}

                </option>

            @endforeach

        </select>

    </div>

   {{-- ================= SESI ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Sesi
        </label>

        <select name="sesi_id"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Sesi
            </option>

            @foreach($sesi as $s)

                <option value="{{ $s->id }}"

                    {{ request('sesi_id') == $s->id
                        ? 'selected'
                        : ''
                    }}>

                    {{ $s->nama_sesi }}
                    ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})

                </option>

            @endforeach

        </select>

    </div>

    {{-- ================= MAPEL ================= --}}
    <div class="mb-5">

        <label class="block font-semibold mb-2">
            Mata Pelajaran
        </label>

        <select name="mata_pelajaran_id"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Mata Pelajaran
            </option>

            @foreach($mapel as $m)

                <option value="{{ $m->id }}">

                    {{ $m->nama_mapel }}
                    ({{ $m->kode_mapel }})

                </option>

            @endforeach

        </select>

    </div>

    {{-- ================= TENTOR ================= --}}
    <div class="mb-6">

        <label class="block font-semibold mb-2">
            Tentor
        </label>

        <select name="tentor_id"
                class="w-full border border-gray-300 p-3 rounded-xl"
                required>

            <option value="">
                Pilih Tentor
            </option>

            @foreach($tentor as $t)

                <option value="{{ $t->id }}">

                    {{ $t->nama }}

                </option>

            @endforeach

        </select>

    </div>

    {{-- ================= BUTTON ================= --}}
    <div class="flex items-center gap-3 flex-wrap">

        <button type="submit"
                class="bg-orange-600 hover:bg-orange-700 text-white px-6 py-3 rounded-xl transition">

            Simpan Jadwal

        </button>

         <a href="{{ route('jadwal.matrix') }}"
             class="bg-gray-400 hover:bg-gray-500 text-white px-4 py-2 rounded-lg">
                Kembali
        </a>

    </div>

</form>

<script>

const kelasSelect =
    document.getElementById('kelasSelect');

const hariSelect =
    document.getElementById('hariSelect');

/*
|--------------------------------------------------------------------------
| AUTO LOAD HARI BERDASARKAN KELAS
|--------------------------------------------------------------------------
*/
kelasSelect.addEventListener('change', function(){

    let selectedOption =
        this.options[this.selectedIndex];

    let hariBelajar =
        selectedOption.getAttribute('data-hari');

    // RESET
    hariSelect.innerHTML =
        '<option value="">Pilih Hari</option>';

    /*
    |--------------------------------------------------------------------------
    | AUTO GENERATE HARI
    |--------------------------------------------------------------------------
    */
    if(hariBelajar)
    {
        let hariArray =
            hariBelajar.split(',');

        let selectedHari =
            "{{ request('hari') }}";

        hariArray.forEach(function(hari){

            hari = hari.trim();

            let selected =
                hari === selectedHari
                ? 'selected'
                : '';

            hariSelect.innerHTML +=
            `<option value="${hari}" ${selected}>
                ${hari}
            </option>`;
        });
    }

});

/*
|--------------------------------------------------------------------------
| AUTO TRIGGER SAAT MASUK DARI MATRIX
|--------------------------------------------------------------------------
*/
window.addEventListener('load', function(){

    kelasSelect.dispatchEvent(
        new Event('change')
    );

});

</script>

@endsection