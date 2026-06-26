<!DOCTYPE html>

<html>
<head>
    <meta charset="utf-8">

<style>

    body{
        font-family: DejaVu Sans, sans-serif;
        font-size:11px;
    }

    .header{
        text-align:center;
        margin-bottom:20px;
    }

    .header h2{
        margin:0;
        padding:0;
    }

    .header h3{
        margin:5px 0;
        padding:0;
    }

    .info{
        width:100%;
        margin-bottom:15px;
    }

    .info td{
        border:none;
        padding:3px;
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
        background-color:#f2f2f2;
        font-weight:bold;
    }

    .nama{
        text-align:left;
    }

    .footer{
        margin-top:20px;
        text-align:right;
        font-size:10px;
    }

</style>

</head>

<body>

<div class="header">

    <h2>E-BRAIN KABANJAHE</h2>

    <h3>

        @if(request('minggu_ke'))

            LAPORAN ABSENSI MINGGUAN

        @else

            LAPORAN ABSENSI BULANAN

        @endif

    </h3>

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

<div class="footer">

   Dicetak pada :
    {{ now()->locale('id')->translatedFormat('d F Y H:i') }}
</div>


</body>
</html>
