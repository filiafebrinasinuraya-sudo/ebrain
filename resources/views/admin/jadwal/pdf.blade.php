<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Jadwal Pembelajaran E-Brain</title>

    <style>
        @page {
            margin: 25px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            color: #333;
        }

        /* =========================
           KOP SURAT
        ========================= */

        .kop {
            width: 100%;
            border-bottom: 3px solid #000;
            padding-bottom: 8px;
            margin-bottom: 15px;
        }

        .kop-table {
            width: 100%;
            border-collapse: collapse;
        }

        .kop-table td {
            border: none;
            vertical-align: middle;
        }

        .logo-cell {
            width: 90px;
            text-align: center;
        }

        .logo {
            width: 70px;
            height: auto;
        }

        .kop-text {
            text-align: center;
        }

        .kop-text h1 {
            margin: 0;
            font-size: 18px;
            font-weight: bold;
        }

        .kop-text h2 {
            margin: 3px 0;
            font-size: 13px;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9px;
        }

        /* =========================
           JUDUL
        ========================= */

        .report-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 12px 0 5px 0;
        }

        .periode {
            text-align: center;
            font-size: 10px;
            margin-bottom: 15px;
        }

        /* =========================
           TABEL
        ========================= */

        table.data {
            width: 100%;
            border-collapse: collapse;
        }

        table.data th {
            background-color: #eeeeee;
            border: 1px solid #555;
            padding: 7px 5px;
            text-align: center;
            font-weight: bold;
        }

        table.data td {
            border: 1px solid #777;
            padding: 6px 5px;
            vertical-align: middle;
        }

        .center {
            text-align: center;
        }

        /* =========================
           FOOTER
        ========================= */

        .footer {
            margin-top: 25px;
        }

        .footer-table {
            width: 100%;
            border-collapse: collapse;
        }

        .footer-table td {
            border: none;
            vertical-align: top;
        }

        .date {
            text-align: right;
            font-size: 10px;
        }

        .signature {
            margin-top: 45px;
            font-weight: bold;
        }

        /* AGAR BARIS TIDAK TERPOTONG */
        tr {
            page-break-inside: avoid;
        }
    </style>
</head>

<body>

    {{-- =========================
         KOP E-BRAIN
    ========================= --}}

    <div class="kop">

        <table class="kop-table">

            <tr>

                {{-- LOGO --}}
                <td class="logo-cell">

                    <img
                        src="{{ public_path('images/logo ebrain.png') }}"
                        class="logo"
                    >

                </td>


                {{-- INFORMASI E-BRAIN --}}
                <td class="kop-text">

                    <h1>
                        BIMBINGAN BELAJAR E-BRAIN
                    </h1>

                    <h2>
                        KABANJAHE
                    </h2>

                    <p>
                        Jl. Jamin Ginting No. 19 & 21, Ketaren,
                        Kec. Kabanjahe, Kabupaten Karo,
                        Sumatera Utara 22111
                    </p>

                    <p>
                        Telp : 0813-6003-7196
                    </p>

                </td>


                {{-- RUANG KOSONG --}}
                <td style="width: 90px;"></td>

            </tr>

        </table>

    </div>


    {{-- =========================
         JUDUL
    ========================= --}}

    <div class="report-title">
        JADWAL PEMBELAJARAN
    </div>


    {{-- =========================
         PERIODE AKTIF
    ========================= --}}

    <div class="periode">

        <strong>Periode Aktif:</strong>

        {{ $periodeAktif->tahun_ajaran ?? '-' }}

        &nbsp;•&nbsp;

        {{ $periodeAktif->semester ?? '-' }}

        <br>

        {{ $periodeAktif->tanggal_mulai
            ? \Carbon\Carbon::parse($periodeAktif->tanggal_mulai)->format('d-m-Y')
            : '-' }}

        &nbsp; s/d &nbsp;

        {{ $periodeAktif->tanggal_selesai
            ? \Carbon\Carbon::parse($periodeAktif->tanggal_selesai)->format('d-m-Y')
            : '-' }}

    </div>


    {{-- =========================
         TABEL JADWAL
    ========================= --}}

    <table class="data">

        <thead>

            <tr>

                <th style="width: 35px;">
                    No
                </th>

                <th style="width: 60px;">
                    Hari
                </th>

                <th style="width: 85px;">
                    Sesi
                </th>

                <th>
                    Kelas
                </th>

                <th>
                    Mata Pelajaran
                </th>

                <th>
                    Tentor
                </th>

                <th>
                    Ruangan
                </th>

            </tr>

        </thead>


        <tbody>

    @php
        $hariSebelumnya = null;
        $nomor = 1;

        $warnaHari = [
            'Senin'  => '#E8F1FF',
            'Selasa' => '#EAF8EE',
            'Rabu'   => '#FFF4E5',
            'Kamis'  => '#F3EAFE',
            'Jumat'  => '#FCE8F3',
            'Sabtu'  => '#E8F7F7',
        ];
    @endphp

    @forelse($jadwal as $j)

        {{-- HEADER HARI --}}
        @if($hariSebelumnya != $j->hari)

            <tr>
                <td colspan="7"
                    style="
                        background-color: {{ $warnaHari[$j->hari] ?? '#eeeeee' }};
                        font-weight: bold;
                        font-size: 12px;
                        padding: 8px;
                        text-align: left;
                        border: 1px solid #777;
                    ">

                    {{ strtoupper($j->hari) }}

                </td>
            </tr>

            @php
                $hariSebelumnya = $j->hari;
            @endphp

        @endif


        {{-- DATA JADWAL --}}
        <tr>

            {{-- NO --}}
            <td class="center">
                {{ $nomor++ }}
            </td>


            {{-- HARI --}}
            <td class="center">
                {{ $j->hari ?? '-' }}
            </td>


            {{-- SESI --}}
            <td class="center">

                {{ $j->sesi->nama_sesi ?? '-' }}

                @if($j->sesi)

                    <br>

                    <small>
                        {{ $j->sesi->jam_mulai }}
                        -
                        {{ $j->sesi->jam_selesai }}
                    </small>

                @endif

            </td>


            {{-- KELAS --}}
            <td>
                {{ $j->kelas->nama_kelas ?? '-' }}
            </td>


            {{-- MATA PELAJARAN --}}
            <td>
                {{ $j->mataPelajaran->nama_mapel
                    ?? $j->mataPelajaran->singkatan
                    ?? '-' }}
            </td>


            {{-- TENTOR --}}
            <td>
                {{ $j->tentor->nama ?? '-' }}
            </td>


            {{-- RUANGAN --}}
            <td class="center">
                {{ $j->ruangan->nama_ruangan ?? '-' }}
            </td>

        </tr>

    @empty

        <tr>
            <td colspan="7" class="center">
                Belum ada jadwal pada periode aktif.
            </td>
        </tr>

    @endforelse

</tbody>

    </table>


    {{-- =========================
         FOOTER
    ========================= --}}

    <div class="footer">

        <table class="footer-table">

            <tr>

                <td style="width: 60%;"></td>

                <td class="date">

                    Kabanjahe,

                    {{ now()->format('d') }}

                    {{ [
                        'Januari',
                        'Februari',
                        'Maret',
                        'April',
                        'Mei',
                        'Juni',
                        'Juli',
                        'Agustus',
                        'September',
                        'Oktober',
                        'November',
                        'Desember'
                    ][now()->month - 1] }}

                    {{ now()->format('Y') }}


                    <div class="signature">
                        Admin E-Brain
                    </div>

                </td>

            </tr>

        </table>

    </div>

</body>
</html>