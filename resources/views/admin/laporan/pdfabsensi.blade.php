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
    }

    .judul h2 {
        margin: 15px 0 25px 0;
        font-size: 18px;
        font-weight: bold;
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

    <h2>

        @if(request('minggu_ke'))

            LAPORAN ABSENSI MINGGUAN

        @else

            LAPORAN ABSENSI BULANAN

        @endif

    </h2>

</div>

<table class="info">

    <tr>
        <td width="30">Kelas</td>
        <td>: {{ $kelas->nama_kelas }}</td>
    </tr>

    <tr>
        <td>Bulan</td>
        <td>: {{ $bulan->locale('id')->isoFormat('MMMM Y') }}</td>
    </tr>

    @if(request('minggu_ke'))

    <tr>
        <td>Periode</td>
        <td>: Minggu Ke-{{ request('minggu_ke') }}</td>
    </tr>

    @endif

</table>

<table class="laporan">

    <thead>

        <tr>

            <th width="5%">No</th>

            <th width="25%">Nama Siswa</th>

            @foreach($tanggalPertemuan as $tgl)

                <th>

                    {{ \Carbon\Carbon::parse($tgl)->format('d') }}

                </th>

            @endforeach

            <th width="10%">% Hadir</th>

        </tr>

    </thead>

    <tbody>

        @foreach($siswa as $item)

        <tr>

            <td>
                {{ $loop->iteration }}
            </td>

            <td class="nama">
                {{ $item->nama }}
            </td>

            @foreach($tanggalPertemuan as $tgl)

                @php

                    $absenTanggal = $absensi
                        ->where('siswa_id', $item->id)
                        ->filter(function ($a) use ($tgl) {

                            return $a->tanggal == $tgl;

                        });

                @endphp

                <td>

                    @if($absenTanggal->count())

                        {{ $absenTanggal->map(function ($a) {

                            if ($a->status == 'Hadir') return 'H';
                            if ($a->status == 'Izin') return 'I';
                            if ($a->status == 'Sakit') return 'S';
                            if ($a->status == 'Alpha') return 'A';

                            return '-';

                        })->implode('/') }}

                    @else

                        -

                    @endif

                </td>

            @endforeach

            @php

                $totalSesi = $absensi
                    ->where('siswa_id', $item->id)
                    ->count();

                $totalHadir = $absensi
                    ->where('siswa_id', $item->id)
                    ->where('status', 'Hadir')
                    ->count();

                $persentase = $totalSesi > 0
                    ? round(($totalHadir / $totalSesi) * 100, 2)
                    : 0;

            @endphp

            <td>
                {{ $persentase }}%
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

<div class="mt-4 text-sm">
    <p><strong>Keterangan:</strong></p>
    <p>H = Hadir</p>
    <p>I = Izin</p>
    <p>S = Sakit</p>
    <p>A = Alpha</p>
    <p>Format H/H menunjukkan status kehadiran pada dua sesi pembelajaran dalam satu hari (Sesi 1 / Sesi 2).</p>
</div>
    <div style="margin-top:25px; font-size:10px;">
        <b>Keterangan Validasi:</b><br>
        Laporan ini dicetak oleh admin berdasarkan data absensi yang telah diinput oleh tentor melalui sistem informasi bimbingan belajar.
    </div>

<div style="margin-top:40px; width:100%;">

    <table width="100%">
        <tr>
            <td width="50%"></td>
            <td align="center">
                Kabanjahe,
                {{ now()->locale('id')->translatedFormat('d F Y') }}
            </td>
        </tr>
    </table>

    <table width="100%" style="margin-top:30px; border:none;">

    <tr>

        <td width="50%" align="center" style="border:none;">

            Dicetak Oleh,
            <br>
            Admin
            <br><br><br><br><br>

            <u>
                <b>{{ auth()->user()->name }}</b>
            </u>

        </td>

        <td width="50%" align="center" style="border:none;">

            Mengetahui,
            <br>
            Direktur E-Brain
            <br><br><br><br><br>

            <u>
                <b>Elpis Brahmana, S.Pd., M.Psi., CNLP</b>
            </u>

        </td>

    </tr>

</table>

<div class="footer">

    Dicetak pada :
    {{ now()->locale('id')->translatedFormat('d F Y H:i') }}

</div>

</div>


</body>
</html>
