<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">

<style>

body{
    font-family: DejaVu Sans, sans-serif;
    font-size:11px;
}

table{
    width:100%;
    border-collapse:collapse;
}

th,td{
    border:1px solid #000;
    padding:5px;
    text-align:center;
}

.nama{
    text-align:left;
}

</style>

</head>

<body>

<h2 style="text-align:center;">
    E-BRAIN KABANJAHE
</h2>

<h3 style="text-align:center;">
    LAPORAN NILAI QUIZ
</h3>

<p>
    Kelas :
    {{ $kelas->nama_kelas }}
</p>

<p>
    Bulan :
    {{ $bulan->locale('id')->isoFormat('MMMM Y') }}
</p>

@if(request('minggu_ke'))

<p>
    Minggu Ke-{{ request('minggu_ke') }}
</p>

@endif

<table>
<thead>

    <tr>

        <th>No</th>

        <th>Nama Siswa</th>

        @foreach($quiz as $q)

            <th>
                Quiz {{ $loop->iteration }}
            </th>

        @endforeach

        <th>Rata-rata</th>

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

                if ($nilai) {

                    $totalNilai += $nilai->nilai;
                    $jumlahQuiz++;

                }

            @endphp

            <td>

                {{ $nilai ? $nilai->nilai : '-' }}

            </td>

        @endforeach

        <td>

            {{ $jumlahQuiz > 0 ? round($totalNilai / $jumlahQuiz, 2) : '-' }}

        </td>

    </tr>

    @endforeach

</tbody>

</table>

<br>

<h4>
    Keterangan Quiz
</h4>

@foreach($quiz as $q)
<p>

    Quiz {{ $loop->iteration }}
    =
    {{ $q->judul }}

    ({{ \Carbon\Carbon::parse($q->tanggal)->format('d-m-Y') }})

</p>

@endforeach

<br>

<p style="text-align:right;">

Dicetak pada :
{{ now()->locale('id')->isoFormat('D MMMM Y HH:mm') }}

</p>


</html>