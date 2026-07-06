<!DOCTYPE html>
<html>

<head>

    <meta charset="utf-8">

    <title>

        Laporan Siswa

    </title>

    <style>
    @page {
        margin: 15px;
    }

    body {
        font-family: sans-serif;
        font-size: 10px;
        color: #333;
        margin: 0;
        padding: 0;
    }

    .kop {
        text-align: center;
        margin-bottom: 10px;
    }

    .kop img {
        width: 60px;
        margin-bottom: 5px;
    }

    .kop h1 {
        font-size: 18px;
        font-weight: bold;
        margin: 0;
    }

    .kop p {
        margin: 2px 0;
        font-size: 11px;
    }

    hr {
        border: 1px solid #000;
        margin: 8px 0;
    }

    .judul {
        text-align: center;
        margin: 12px 0;
    }

    .judul h2 {
        margin: 0;
        font-size: 16px;
    }

    .identitas {
        margin-bottom: 12px;
    }

    .identitas table {
        width: 100%;
        border-collapse: collapse;
    }

    .identitas td {
        padding: 2px 0;
        font-size: 10px;
    }

    .laporan {
        width: 100%;
        border-collapse: collapse;
        margin-top: 8px;
        font-size: 10px;
    }

    .laporan th,
    .laporan td {
        border: 1px solid #000;
        padding: 4px;
        text-align: center;
        vertical-align: middle;
    }

    .laporan th {
        background: #f2f2f2;
        font-weight: bold;
    }

    .ringkasan {
        margin-top: 15px;
    }

    .ringkasan table {
        width: 100%;
        border-collapse: collapse;
    }

    .ringkasan td {
        padding: 2px 0;
        font-size: 10px;
    }

    .ttd{
        width:100%;
        margin-top:20px;
    }

    .ttd td{
        width:50%;
        text-align:center;
        vertical-align:top;
    }

    .nama-ttd{
        margin-top:60px;
        font-weight:bold;
        text-decoration:underline;
    }

    .footer {
        margin-top: 50px;
        text-align: right;
        font-size: 9px;
    }
</style>

</head>

<body>

    {{-- ================= KOP ================= --}}
    <div class="kop">

    <img src="{{ public_path('images/logo ebrain.png') }}">

    <h1>BIMBINGAN BELAJAR E-BRAIN</h1>

    <p>
        Jl. Jamin Ginting No. 19 & 21, Ketaren,
        Kec. Kabanjahe, Kabupaten Karo,
        Sumatera Utara 22111
    </p>

    <p>
        Telp : 0813-6003-7196
    </p>

</div>

<div style="border-top:2px solid #000;"></div>
<div style="border-top:1px solid #000; margin-top:2px;"></div>

<div class="judul">

    <h2>LAPORAN PERKEMBANGAN SISWA</h2>

    <p>
        Rekapitulasi Absensi dan Nilai Quiz Siswa
    </p>

</div>


    {{-- ================= IDENTITAS ================= --}}
    <div class="identitas">

        <table>

            <tr>

                <td width="120">

                    Nama Siswa

                </td>

                <td width="10">

                    :

                </td>

                <td>

                    {{ $siswa->nama }}

                </td>

            </tr>

            <tr>

                <td>

                    Kelas

                </td>

                <td>

                    :

                </td>

                <td>

                    {{ $namaKelas }}

                </td>

            </tr>

            <tr>

                <td>

                    Periode

                </td>

                <td>

                    :

                </td>

                <td>

                    {{ $periode }}

                </td>

            </tr>

        </table>

    </div>

    {{-- ================= TABEL ================= --}}
    <table class="laporan">

        <thead>

            <tr>

                <th width="40">

                    No

                </th>

                <th width="120">

                    Tanggal

                </th>

                <th width="80">

                    Sesi

                </th>

                <th width="120">

                    Kehadiran

                </th>

                <th width="100">

                    Nilai Quiz

                </th>

            </tr>

        </thead>

        <tbody>

            @forelse($laporan as $item)

            <tr>

                <td>

                    {{ $loop->iteration }}

                </td>

                <td>

                    {{ $item['tanggal'] }}

                </td>

                <td>

                    {{ $item['sesi'] ?? '-' }}

                </td>

                <td>

                    {{ $item['status'] }}

                </td>

                <td>

                    {{ $item['nilai'] }}

                </td>

            </tr>

            @empty

            <tr>

                <td colspan="5">

                    Tidak ada data laporan

                </td>

            </tr>

            @endforelse

        </tbody>

    </table>

    {{-- ================= RINGKASAN ================= --}}
<div class="ringkasan">

    <table>

        <tr>
            <td width="150">Total Hadir</td>
            <td width="10">:</td>
            <td>{{ $hadir }}</td>
        </tr>

        <tr>
            <td>Total Izin</td>
            <td>:</td>
            <td>{{ $izin }}</td>
        </tr>

        <tr>
            <td>Total Sakit</td>
            <td>:</td>
            <td>{{ $sakit }}</td>
        </tr>

        <tr>
            <td>Total Alpha</td>
            <td>:</td>
            <td>{{ $alpha }}</td>
        </tr>

        <tr>
            <td>Rata-rata Quiz</td>
            <td>:</td>
            <td>{{ $rataQuiz }}</td>
        </tr>

        <tr>
            <td>Persentase Kehadiran</td>
            <td>:</td>
            <td>{{ $persentaseKehadiran }}%</td>
        </tr>

    </table>

</div>



{{-- ================= TANGGAL ================= --}}
<table width="100%" style="margin-top:30px;">
    <tr>
        <td width="50%"></td>

        <td align="center">
            Kabanjahe, {{ now()->locale('id')->translatedFormat('d F Y') }}
        </td>
    </tr>
</table>

{{-- ================= TANDA TANGAN ================= --}}
<table class="ttd">

    <tr>

        <td align="center">

            Dicetak Oleh,<br>
            Admin

            <div class="nama-ttd">

                {{ auth()->user()->name }}

            </div>

        </td>

        <td align="center">

            Mengetahui,<br>
            Direktur E-Brain

            <div class="nama-ttd">

                Elpis Brahmana, S.Pd., M.Psi., CNLP

            </div>

        </td>

    </tr>

</table>

{{-- ================= FOOTER ================= --}}
<div class="footer">

    Dicetak pada :
    {{ now()->locale('id')->translatedFormat('d F Y H:i') }}

</div>


</body>

</html>