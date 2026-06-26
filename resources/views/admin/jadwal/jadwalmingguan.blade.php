@extends('layouts.admin')

@section('content')

<div class="space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-4">

        <div>

            <h1 class="text-2xl font-bold text-gray-800">
                📚 Jadwal Mingguan Bimbel
            </h1>

            <p class="text-sm text-gray-500 mt-1">
                Input jadwal banyak sekaligus seperti spreadsheet
            </p>

        </div>

        <div class="flex gap-3">

            <a href="{{ route('jadwal.matrix') }}"
               class="bg-indigo-600 hover:bg-indigo-700 text-white px-4 py-2 rounded-xl shadow">

                📅 Matrix Jadwal

            </a>

            <a href="{{ route('jadwal.index') }}"
               class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-xl">

                📋 List Jadwal

            </a>

        </div>

    </div>

    {{-- ================= STATS ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">

        <div class="bg-white rounded-2xl shadow-sm border p-5">

            <p class="text-sm text-gray-500">
                Total Kelas
            </p>

            <h2 class="text-3xl font-bold text-blue-600 mt-2">
                {{ $kelas->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-5">

            <p class="text-sm text-gray-500">
                Total Tentor
            </p>

            <h2 class="text-3xl font-bold text-green-600 mt-2">
                {{ $tentor->count() }}
            </h2>

        </div>

        <div class="bg-white rounded-2xl shadow-sm border p-5">

            <p class="text-sm text-gray-500">
                Total Ruangan
            </p>

            <h2 class="text-3xl font-bold text-purple-600 mt-2">
                {{ $ruangan->count() }}
            </h2>

        </div>

    </div>

    {{-- ================= FORM ================= --}}
    <form action="{{ route('jadwal.mingguan.store') }}"
          method="POST">

        @csrf

        {{-- ================= PILIH PERIODE ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border p-5 mb-5">

            <label class="block text-sm font-semibold text-gray-700 mb-2">

                Pilih Periode Jadwal

            </label>

            <select name="periode_id"
                    class="w-full border rounded-xl p-3"
                    required>

                <option value="">
                    Pilih Periode
                </option>

                @foreach($periode as $p)

                    <option value="{{ $p->id }}">

                        {{ $p->tahun_ajaran }}
                        -
                        {{ $p->semester }}

                        ({{ \Carbon\Carbon::parse($p->tanggal_mulai)->format('d M Y') }}
                        -
                        {{ \Carbon\Carbon::parse($p->tanggal_selesai)->format('d M Y') }})

                        {{ $p->is_active ? ' - AKTIF' : '' }}

                    </option>

                @endforeach

            </select>

        </div>

        {{-- ================= TABLE ================= --}}
        <div class="bg-white rounded-2xl shadow-sm border overflow-hidden">

            <div class="overflow-x-auto">

                <table class="min-w-full border-collapse text-sm">

                    {{-- HEADER --}}
                    <thead class="bg-gray-100 sticky top-0 z-10">

                        <tr>

                            <th class="border px-3 py-3 text-left">
                                Kelas
                            </th>

                            <th class="border px-3 py-3 text-left">
                                Hari
                            </th>

                            <th class="border px-3 py-3 text-left">
                                Ruangan
                            </th>

                            <th class="border px-3 py-3 text-left">
                                Sesi
                            </th>

                            <th class="border px-3 py-3 text-left">
                                Mapel
                            </th>

                            <th class="border px-3 py-3 text-left">
                                Tentor
                            </th>

                            <th class="border px-3 py-3 text-center">
                                Status
                            </th>

                            <th class="border px-3 py-3 text-center">
                                Aksi
                            </th>

                        </tr>

                    </thead>

                    {{-- BODY --}}
                    <tbody id="bodyJadwal">

                        <tr class="hover:bg-blue-50 transition">

                            {{-- KELAS --}}
                            <td class="border p-2">

                                <select name="jadwal[0][kelas_id]"
                                        class="w-full border rounded-lg p-2"
                                        onchange="setHari(this)"
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

                            </td>

                            {{-- HARI --}}
                            <td class="border p-2">

                                <select name="jadwal[0][hari]"
                                        class="w-full border rounded-lg p-2 hari-select"
                                        required>

                                    <option value="">
                                        Pilih Hari
                                    </option>

                                </select>

                            </td>

                            {{-- RUANGAN --}}
                            <td class="border p-2">

                                <select name="jadwal[0][ruangan_id]"
                                        class="w-full border rounded-lg p-2"
                                        required>

                                    <option value="">
                                        Pilih Ruangan
                                    </option>

                                    @foreach($ruangan as $r)

                                        <option value="{{ $r->id }}">
                                            {{ $r->nama_ruangan }}
                                        </option>

                                    @endforeach

                                </select>

                            </td>

                            {{-- SESI --}}
                            <td class="border p-2">

                                <select name="jadwal[0][sesi_id]"
                                        class="w-full border rounded-lg p-2"
                                        required>

                                    <option value="">
                                        Pilih Sesi
                                    </option>

                                    @foreach($sesi as $s)

                                        <option value="{{ $s->id }}">

                                            {{ $s->nama_sesi }}
                                            ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})

                                        </option>

                                    @endforeach

                                </select>

                            </td>

                            {{-- MAPEL --}}
                            <td class="border p-2">

                                <select name="jadwal[0][mata_pelajaran_id]"
                                        class="w-full border rounded-lg p-2"
                                        required>

                                    <option value="">
                                        Pilih Mapel
                                    </option>

                                    @foreach($mapel as $m)

                                        <option value="{{ $m->id }}">
                                            {{ $m->singkatan }}
                                        </option>

                                    @endforeach

                                </select>

                            </td>

                            {{-- TENTOR --}}
                            <td class="border p-2">

                                <select name="jadwal[0][tentor_id]"
                                        class="w-full border rounded-lg p-2"
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

                            </td>

                            {{-- STATUS --}}
                            <td class="border p-2 text-center">

                                <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                                    Ready

                                </span>

                            </td>

                            {{-- AKSI --}}
                            <td class="border p-2 text-center">

                                <button type="button"
                                        onclick="hapusBaris(this)"
                                        class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">

                                    X

                                </button>

                            </td>

                        </tr>

                    </tbody>

                </table>

            </div>

        </div>

        {{-- ================= BUTTON ================= --}}
        <div class="flex flex-wrap gap-3 mt-5">

            {{-- TAMBAH BARIS --}}
            <button type="button"
                    onclick="tambahBaris()"
                    class="bg-green-600 hover:bg-green-700 text-white px-5 py-3 rounded-xl shadow">

                ➕ Tambah Baris

            </button>

            {{-- SIMPAN --}}
            <button type="submit"
                    class="bg-blue-600 hover:bg-blue-700 text-white px-5 py-3 rounded-xl shadow">

                💾 Simpan Semua

            </button>

        </div>

    </form>

</div>

{{-- ================= SCRIPT ================= --}}
<script>

let index = 1;

function tambahBaris()
{
    let table = document.getElementById('bodyJadwal');

    let row = `
    <tr class="hover:bg-blue-50 transition">

        <td class="border p-2">

            <select name="jadwal[\${index}][kelas_id]"
                    class="w-full border rounded-lg p-2"
                    onchange="setHari(this)"
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

        </td>

        <td class="border p-2">

            <select name="jadwal[\${index}][hari]"
                    class="w-full border rounded-lg p-2 hari-select"
                    required>

                <option value="">
                    Pilih Hari
                </option>

            </select>

        </td>

        <td class="border p-2">

            <select name="jadwal[\${index}][ruangan_id]"
                    class="w-full border rounded-lg p-2"
                    required>

                <option value="">
                    Pilih Ruangan
                </option>

                @foreach($ruangan as $r)

                    <option value="{{ $r->id }}">
                        {{ $r->nama_ruangan }}
                    </option>

                @endforeach

            </select>

        </td>

        <td class="border p-2">

            <select name="jadwal[\${index}][sesi_id]"
                    class="w-full border rounded-lg p-2"
                    required>

                <option value="">
                    Pilih Sesi
                </option>

                @foreach($sesi as $s)

                    <option value="{{ $s->id }}">

                        {{ $s->nama_sesi }}
                        ({{ $s->jam_mulai }} - {{ $s->jam_selesai }})

                    </option>

                @endforeach

            </select>

        </td>

        <td class="border p-2">

            <select name="jadwal[\${index}][mata_pelajaran_id]"
                    class="w-full border rounded-lg p-2"
                    required>

                <option value="">
                    Pilih Mapel
                </option>

                @foreach($mapel as $m)

                    <option value="{{ $m->id }}">
                        {{ $m->singkatan }}
                    </option>

                @endforeach

            </select>

        </td>

        <td class="border p-2">

            <select name="jadwal[\${index}][tentor_id]"
                    class="w-full border rounded-lg p-2"
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

        </td>

        <td class="border p-2 text-center">

            <span class="bg-green-100 text-green-700 px-3 py-1 rounded-full text-xs font-semibold">

                Ready

            </span>

        </td>

        <td class="border p-2 text-center">

            <button type="button"
                    onclick="hapusBaris(this)"
                    class="bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg">

                X

            </button>

        </td>

    </tr>
    `;

    table.insertAdjacentHTML('beforeend', row);

    index++;
}

function hapusBaris(btn)
{
    let row = btn.closest('tr');

    let totalRow =
        document.querySelectorAll('#bodyJadwal tr').length;

    if(totalRow > 1)
    {
        row.remove();
    }
    else
    {
        alert('Minimal 1 baris!');
    }
}

function setHari(select)
{
    let row = select.closest('tr');

    let hariSelect =
        row.querySelector('.hari-select');

    let selectedOption =
        select.options[select.selectedIndex];

    let hariBelajar =
        selectedOption.getAttribute('data-hari');

    hariSelect.innerHTML =
        `<option value="">Pilih Hari</option>`;

    if(hariBelajar)
    {
        let hariArray =
            hariBelajar.split(',');

        hariArray.forEach(function(hari){

            hari = hari.trim();

            hariSelect.innerHTML +=
            `<option value="${hari}">
                ${hari}
            </option>`;
        });
    }
}

</script>

@endsection