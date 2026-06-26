<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Siswa;
use App\Models\Absensi;
use App\Models\NilaiQuiz;
use App\Models\Kelas;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanSiswaController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | LIST SISWA
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER
        |--------------------------------------------------------------------------
        */
        $kelasId = $request->kelas_id;

        /*
        |--------------------------------------------------------------------------
        | DATA SISWA
        |--------------------------------------------------------------------------
        */
        $siswa = Siswa::with('kelas')

            ->when($kelasId, function ($query) use ($kelasId) {

                $query->whereHas('kelas', function ($q) use ($kelasId) {

                    $q->where('kelas.id', $kelasId);

                });

            })

            ->latest()

            ->get();

        /*
        |--------------------------------------------------------------------------
        | DATA KELAS
        |--------------------------------------------------------------------------
        */
        $kelas = \App\Models\Kelas::all();

        return view(
            'admin.laporan.index',
            compact(
                'siswa',
                'kelas'
            )
        );
    }   

    /*
    |--------------------------------------------------------------------------
    | DETAIL LAPORAN SISWA
    |--------------------------------------------------------------------------
    */
    public function detail(Siswa $siswa)
    {
        $kelasId = request('kelas_id');
        $bulan = request('bulan');
        $absensi = Absensi::where(
            'siswa_id',
            $siswa->id
        )

        ->when($kelasId, function ($query) use ($kelasId) {

            $query->whereHas('jadwal', function ($q) use ($kelasId) {

                $q->where(
                    'kelas_id',
                    $kelasId
                );

            });

        })

        ->when($bulan, function ($query) use ($bulan) {

            $query->whereMonth(
                'tanggal',
                \Carbon\Carbon::parse($bulan)->month
            )

            ->whereYear(
                'tanggal',
                \Carbon\Carbon::parse($bulan)->year
            );

        })

        ->orderBy('tanggal')

        ->get();

        /*
        |--------------------------------------------------------------------------
        | NILAI QUIZ
        |--------------------------------------------------------------------------
        */
        $nilaiQuiz = NilaiQuiz::where(
            'siswa_id',
            $siswa->id
        )

        ->when($kelasId, function ($query) use ($kelasId) {

            $query->whereHas(
                'quiz.jadwal',
                function ($q) use ($kelasId) {

                    $q->where(
                        'kelas_id',
                        $kelasId
                    );

                }
            );

        })

        ->whereHas('quiz', function ($q) use ($bulan) {

            if ($bulan) {

                $q->whereMonth(
                    'tanggal',
                    \Carbon\Carbon::parse($bulan)->month
                )

                ->whereYear(
                    'tanggal',
                    \Carbon\Carbon::parse($bulan)->year
                );

            }

        })

        ->with('quiz')

        ->get();

        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN DATA
        |--------------------------------------------------------------------------
        */
        $laporan = $absensi->map(function ($a) use ($nilaiQuiz) {

            $quiz = $nilaiQuiz->first(function ($q) use ($a) {

                return optional($q->quiz)->jadwal_id == $a->jadwal_id
                    && optional($q->quiz)->tanggal == $a->tanggal;

            });

            return [

                'tanggal' => $a->tanggal,

                 'sesi' => $a->jadwal->sesi->nama_sesi ?? '-',

                'status' => $a->status,

                'nilai' => $quiz->nilai ?? '-'

            ];

        });

        $laporan = $laporan
        ->sortBy(function ($item) {

            return $item['tanggal'].'-'.$item['sesi'];

        })
        ->values();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */
        $hadir = $absensi
            ->where('status', 'Hadir')
            ->count();

        $izin = $absensi
            ->where('status', 'Izin')
            ->count();

        $sakit = $absensi
            ->where('status', 'Sakit')
            ->count();

        $alpha = $absensi
            ->where('status', 'Alpha')
            ->count();
        
        $totalPertemuan = $hadir + $izin + $sakit + $alpha;
            $persentaseKehadiran = $totalPertemuan > 0
                ? round(($hadir / $totalPertemuan) * 100, 0)
                : 0;

        $rataQuiz = round(
            $nilaiQuiz->avg('nilai'),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | KESIMPULAN OTOMATIS
        |--------------------------------------------------------------------------
        */
        return view(
            'admin.laporan.detail',
            compact(
                'siswa',
                'laporan',
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'rataQuiz',
                'persentaseKehadiran'
            )
        );
    }

    public function pdf(Request $request, Siswa $siswa)
    {
        /*
        |--------------------------------------------------------------------------
        | FILTER BULAN
        |--------------------------------------------------------------------------
        */
        $bulan = $request->bulan;
        $kelasId = $request->kelas_id;
        /*
        |--------------------------------------------------------------------------
        | ABSENSI
        |--------------------------------------------------------------------------
        */
        $absensi = Absensi::with('jadwal.sesi')
        ->where(
            'siswa_id',
            $siswa->id
        )

            ->when($kelasId, function ($query) use ($kelasId) {

                $query->whereHas('jadwal', function ($q) use ($kelasId) {

                    $q->where(
                        'kelas_id',
                        $kelasId
                    );

                });

            })

            ->when($bulan, function ($query) use ($bulan) {

                $query->whereMonth(
                    'tanggal',
                    \Carbon\Carbon::parse($bulan)->month
                )

                ->whereYear(
                    'tanggal',
                    \Carbon\Carbon::parse($bulan)->year
                );

            })

            ->orderBy('tanggal')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | QUIZ
        |--------------------------------------------------------------------------
        */
        $nilaiQuiz = NilaiQuiz::where(
                'siswa_id',
                $siswa->id
            )

            ->when($kelasId, function ($query) use ($kelasId) {

                $query->whereHas(
                    'quiz.jadwal',
                    function ($q) use ($kelasId) {

                        $q->where(
                            'kelas_id',
                            $kelasId
                        );

                    }
                );

            })

            ->whereHas('quiz', function ($q) use ($bulan) {

                if ($bulan) {

                    $q->whereMonth(
                        'tanggal',
                        \Carbon\Carbon::parse($bulan)->month
                    )

                    ->whereYear(
                        'tanggal',
                        \Carbon\Carbon::parse($bulan)->year
                    );

                }

            })

            ->with('quiz')

            ->get();

        /*
        |--------------------------------------------------------------------------
        | GABUNGKAN DATA
        |--------------------------------------------------------------------------
        */
        $laporan = $absensi->map(function ($a) use ($nilaiQuiz) {

            $quiz = $nilaiQuiz->first(function ($q) use ($a) {

                return optional($q->quiz)->jadwal_id == $a->jadwal_id
                    && optional($q->quiz)->tanggal == $a->tanggal;

            });
            return [

                'tanggal' => \Carbon\Carbon::parse($a->tanggal)
                ->format('d/m/Y'),

                'sesi' => $a->jadwal->sesi->nama_sesi ?? '-',

                'status' => $a->status,

                'nilai' => $quiz->nilai ?? '-'

            ];

        });

        $laporan = $laporan
            ->sortBy(function ($item) {

                return $item['tanggal'].'-'.$item['sesi'];

            })
            ->values();

        /*
        |--------------------------------------------------------------------------
        | RINGKASAN
        |--------------------------------------------------------------------------
        */
        $hadir = $absensi
            ->where('status', 'Hadir')
            ->count();

        $izin = $absensi
            ->where('status', 'Izin')
            ->count();

        $sakit = $absensi
            ->where('status', 'Sakit')
            ->count();

        $alpha = $absensi
            ->where('status', 'Alpha')
            ->count();
        
        $totalPertemuan = $hadir + $izin + $sakit + $alpha;
            $persentaseKehadiran = $totalPertemuan > 0
                ? round(($hadir / $totalPertemuan) * 100, 0)
                : 0;

        $rataQuiz = round(
            $nilaiQuiz->avg('nilai'),
            2
        );

        /*
        |--------------------------------------------------------------------------
        | PERIODE
        |--------------------------------------------------------------------------
        */
        $periode = $bulan
            ? \Carbon\Carbon::parse($bulan)
                ->locale('id')
                ->translatedFormat('F Y')
            : 'Semua Periode';

        $kelasDipilih = Kelas::find($kelasId);

        $namaKelas = $kelasDipilih
            ? $kelasDipilih->nama_kelas
            : 'Semua Kelas';
        
        $pdf = Pdf::loadView(
            'admin.laporan.pdf',
            compact(
                'siswa',
                'laporan',
                'hadir',
                'izin',
                'sakit',
                'alpha',
                'rataQuiz',
                'periode',
                'persentaseKehadiran',
                'namaKelas'
            )
        );

        return $pdf->stream(
            'laporan-'.$siswa->nama.'.pdf'
        );
    }
}