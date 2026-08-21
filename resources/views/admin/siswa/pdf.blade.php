<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">

    <title>Data Siswa E-Brain</title>

    <style>

        @page {
            margin: 25px 30px;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 11px;
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
            width: 100px;
            text-align: center;
        }

        .logo {
            width: 75px;
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
            font-size: 14px;
            font-weight: bold;
        }

        .kop-text p {
            margin: 2px 0;
            font-size: 9px;
        }


        /* =========================
           JUDUL LAPORAN
        ========================= */

        .report-title {
            text-align: center;
            font-size: 15px;
            font-weight: bold;
            margin: 15px 0;
        }


        /* =========================
           TABEL DATA
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

        table.data td.center {
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
        }

        .date {
            text-align: right;
            font-size: 11px;
        }

        .signature {
            margin-top: 45px;
            font-weight: bold;
        }

    </style>
</head>

<body>

    <!-- =========================
         KOP SURAT
    ========================= -->

    <div class="kop">

        <table class="kop-table">

            <tr>

                <!-- LOGO -->
                <td class="logo-cell">

                    <img
                        src="{{ public_path('images/logo ebrain.png') }}"
                        class="logo"
                    >

                </td>


                <!-- TEXT KOP -->
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


                <!-- RUANG KOSONG AGAR TEXT TETAP DI TENGAH -->
                <td style="width: 100px;"></td>

            </tr>

        </table>

    </div>


    <!-- =========================
         JUDUL
    ========================= -->

    <div class="report-title">
        DATA SISWA BIMBINGAN BELAJAR E-BRAIN
    </div>


    <!-- =========================
         TABEL
    ========================= -->

    <table class="data">

        <thead>

            <tr>

                <th style="width: 35px;">
                    No
                </th>

                <th>
                    Nama Siswa
                </th>

                <th style="width: 45px;">
                    JK
                </th>

                <th>
                    Tempat, Tanggal Lahir
                </th>

                <th>
                    Asal Sekolah
                </th>

                <th>
                    Kelas
                </th>

                <th>
                    No. HP
                </th>

                <th style="width: 60px;">
                    Status
                </th>

            </tr>

        </thead>


        <tbody>

            @forelse($siswa as $index => $s)

                <tr>

                    <td class="center">
                        {{ $index + 1 }}
                    </td>

                    <td>
                        {{ $s->nama ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $s->jenis_kelamin ?? '-' }}
                    </td>

                    <td>
                        {{ $s->tempat_lahir ?? '-' }},
                        {{ $s->tanggal_lahir?->format('d-m-Y') ?? '-' }}
                    </td>

                    <td>
                        {{ $s->asal_sekolah ?? '-' }}
                    </td>

                    <td>

                        @if($s->kelas->count())

                            @foreach($s->kelas as $k)

                                {{ $k->nama_kelas }}

                                @if(!$loop->last)
                                    ,
                                @endif

                            @endforeach

                        @else

                            -

                        @endif

                    </td>

                    <td>
                        {{ $s->no_hp ?? '-' }}
                    </td>

                    <td class="center">
                        {{ $s->status ?? '-' }}
                    </td>

                </tr>

            @empty

                <tr>

                    <td colspan="8" class="center">
                        Data siswa tidak ditemukan
                    </td>

                </tr>

            @endforelse

        </tbody>

    </table>


    <!-- =========================
         FOOTER
    ========================= -->

    <div class="footer">

        <table class="footer-table">

            <tr>

                <td style="width: 60%;"></td>

                <td class="date">

                    Kabanjahe,
                        {{ now()->format('d') }}
                        {{ ['Januari','Februari','Maret','April','Mei','Juni','Juli','Agustus','September','Oktober','November','Desember'][now()->month - 1] }}
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