<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

@page{
    margin:15px;
}

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
    color:#333;
}

.kop{
    text-align:center;
    margin-bottom:10px;
}

.kop img{
    width:60px;
    margin-bottom:5px;
}

.kop h1{
    margin:0;
    font-size:18px;
    font-weight:bold;
}

.kop p{
    margin:2px 0;
    font-size:11px;
}

.judul{
    text-align:center;
}

.judul h2{
    margin:15px 0 25px 0;
    font-size:18px;
    font-weight:bold;
}

.info{
    width:100%;
    margin-bottom:15px;
    border-collapse:collapse;
}

.info td{
    border:none;
    padding:3px 0;
    text-align:left;
}

.laporan{
    width:100%;
    border-collapse:collapse;
}

.laporan th,
.laporan td{
    border:1px solid #000;
    padding:5px;
    text-align:center;
}

.laporan th{
    background:#f2f2f2;
    font-weight:bold;
}

.nama{
    text-align:left;
}

.keterangan{
    margin-top:15px;
    font-size:10px;
}

.keterangan p{
    margin:3px 0;
}

.ttd{
    width:100%;
    margin-top:20px;
    border-collapse:collapse;
}

.ttd td{
    border:none;
    width:50%;
    text-align:center;
    vertical-align:top;
}

.nama-ttd{
    margin-top:60px;
    font-weight:bold;
    text-decoration:underline;
}

.footer{
    margin-top:40px;
    text-align:right;
    font-size:9px;
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

{{-- ================= JUDUL ================= --}}
<div class="judul">

    <h2>

        @if(request('minggu_ke'))

            LAPORAN NILAI QUIZ MINGGUAN

        @else

            LAPORAN NILAI QUIZ BULANAN

        @endif

    </h2>

</div>

{{-- ================= INFORMASI ================= --}}
<table class="info">

    <tr>
        <td width="70">Kelas</td>
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

{{-- ================= TABEL ================= --}}
<table class="laporan">

    <thead>

        <tr>

            <th width="5%">No</th>

            <th width="25%">Nama Siswa</th>

            @foreach($quiz as $q)

                <th>
                    Quiz {{ $loop->iteration }}
                </th>

            @endforeach

            <th width="12%">Rata-rata</th>

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

            @php
                $totalNilai = 0;
                $jumlahQuiz = 0;
            @endphp

            @foreach($quiz as $q)

                @php

                    $nilai = $nilaiQuiz
                        ->where('quiz_id', $q->id)
                        ->where('siswa_id', $item->id)
                        ->first();

                    if($nilai){
                        $totalNilai += $nilai->nilai;
                        $jumlahQuiz++;
                    }

                @endphp

                <td>
                    {{ $nilai ? $nilai->nilai : '-' }}
                </td>

            @endforeach

            <td>
                {{ $jumlahQuiz > 0 ? round($totalNilai / $jumlahQuiz,2) : '-' }}
            </td>

        </tr>

        @endforeach

    </tbody>

</table>

{{-- ================= KETERANGAN QUIZ ================= --}}
<div class="keterangan">

    <strong>Keterangan Quiz :</strong>

    @foreach($quiz as $q)

        <p>
            Quiz {{ $loop->iteration }}
            =
            {{ $q->judul }}
            ({{ \Carbon\Carbon::parse($q->tanggal)->format('d-m-Y') }})
        </p>

    @endforeach

</div>

{{-- ================= VALIDASI ================= --}}
<div style="margin-top:20px;font-size:10px;">

    <b>Keterangan Validasi :</b><br>

    Laporan ini dicetak oleh admin berdasarkan data nilai quiz
    yang telah diinput oleh tentor melalui sistem informasi
    bimbingan belajar E-Brain.

</div>

{{-- ================= TANGGAL ================= --}}
<table width="100%" style="margin-top:30px;border:none;">

    <tr>

        <td style="border:none;width:50%;"></td>

        <td style="border:none;text-align:center;">
            Kabanjahe,
            {{ now()->locale('id')->translatedFormat('d F Y') }}
        </td>

    </tr>

</table>

{{-- ================= TANDA TANGAN ================= --}}
<table class="ttd">

    <tr>

        <td>

            Dicetak Oleh,
            <br>
            Admin

            <div class="nama-ttd">

                {{ auth()->user()->name }}

            </div>

        </td>

        <td>

            Mengetahui,
            <br>
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