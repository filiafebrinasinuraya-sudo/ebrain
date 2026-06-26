@extends('layouts.admin')

@section('content')

<div class="mb-6">
    <h2 class="text-xl font-bold text-gray-700">Naik Kelas Siswa</h2>
    <p class="text-sm text-gray-500">
        Pindahkan semua siswa dari kelas asal ke kelas tujuan
    </p>
</div>

<div class="flex justify-start mb-4">
<a href="{{ url('/admin/kelas') }}"
           class="bg-gray-500 hover:bg-gray-600 text-white px-4 py-2 rounded-xl transition text-sm">

            ←Kembali ke Data Kelas

        </a>
</div>

{{-- ERROR --}}
@if($errors->any())
    <div class="bg-red-100 text-red-700 p-3 rounded mb-4 mt-3">
        <ul class="list-disc ml-5">
            @foreach($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form action="/admin/kelas/naik-kelas"
      method="POST"
      class="bg-white p-6 rounded-lg shadow space-y-6 mt-4">

    @csrf

    {{-- KELAS ASAL --}}
    <div>
        <label class="font-semibold text-gray-700">Kelas Asal</label>

        <select name="kelas_asal"
                id="kelas_asal"
                class="w-full mt-1 p-2 border rounded-lg"
                required>

            <option value="">-- Pilih Kelas Asal --</option>

            @foreach($kelas as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kelas }}
                     @if($k->hari_belajar)
                     • {{ $k->hari_belajar }}
                     @endif
                     ({{ $k->siswa_count ?? 0 }} siswa)
                </option>
            @endforeach

        </select>
    </div>

    {{-- PILIH SISWA --}}
    <div>

        <label class="font-semibold text-gray-700">

            Pilih Siswa

        </label>

        <div id="daftar_siswa"
            class="mt-2 border rounded-xl p-4
                    bg-gray-50 max-h-72 overflow-y-auto">

            <p class="text-sm text-gray-400">

                Pilih kelas asal terlebih dahulu

            </p>

        </div>

    </div>

    {{-- KELAS TUJUAN --}}
    <div>
        <label class="font-semibold text-gray-700">Kelas Tujuan</label>

        <select name="kelas_tujuan"
                id="kelas_tujuan"
                class="w-full mt-1 p-2 border rounded-lg"
                required>

            <option value="">-- Pilih Kelas Tujuan --</option>

            @foreach($kelas as $k)
                <option value="{{ $k->id }}">
                    {{ $k->nama_kelas }} ({{ $k->siswa_count ?? 0 }} siswa)
                </option>
            @endforeach

        </select>
    </div>

    {{-- INFO --}}
    <div class="text-sm text-gray-600 bg-gray-50 p-4 rounded border">
        ⚠️ Semua siswa dari kelas asal akan dipindahkan ke kelas tujuan.<br>
        ✔ Pastikan kelas tujuan berbeda dengan kelas asal.
    </div>

    {{-- BUTTON --}}
    <div class="flex justify-end">
        <button type="submit"
                onclick="return confirm('Yakin naikkan semua siswa?')"
                class="bg-orange-500 text-white px-6 py-2 rounded-lg hover:bg-orange-600 transition">
            Naikkan Semua Siswa
        </button>
    </div>

</form>

{{-- 🔥 SCRIPT DISABLE --}}
 <script>

    const kelasAsal = document.getElementById('kelas_asal');
    const kelasTujuan = document.getElementById('kelas_tujuan');
    const daftarSiswa = document.getElementById('daftar_siswa');

    kelasAsal.addEventListener('change', function() {

        let asal = this.value;

        /*
        |--------------------------------------------------------------------------
        | DISABLE KELAS TUJUAN
        |--------------------------------------------------------------------------
        */
        Array.from(kelasTujuan.options).forEach(opt => {

            opt.disabled = (opt.value === asal);

        });

        /*
        |--------------------------------------------------------------------------
        | AMBIL DATA SISWA
        |--------------------------------------------------------------------------
        */
        fetch(`/admin/kelas/${asal}/siswa`)

            .then(res => res.json())

            .then(data => {

                if(data.length === 0) {

                    daftarSiswa.innerHTML = `
                        <p class="text-sm text-gray-400">
                            Tidak ada siswa
                        </p>
                    `;

                    return;
                }

                let html = '';

                data.forEach(siswa => {

                    html += `

                        <label class="flex items-center gap-3
                                    p-3 rounded-lg hover:bg-white
                                    cursor-pointer">

                            <input type="checkbox"
                                name="siswa_id[]"
                                value="${siswa.id}"
                                class="rounded border-gray-300">

                            <span class="text-sm text-gray-700">

                                ${siswa.nama}

                            </span>

                        </label>

                    `;
                });

                daftarSiswa.innerHTML = html;
            });
    });
</script>
@endsection