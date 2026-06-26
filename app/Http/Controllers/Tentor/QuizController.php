<?php

namespace App\Http\Controllers\Tentor;

use App\Http\Controllers\Controller;
use App\Models\Jadwal;
use App\Models\Quiz;
use App\Models\NilaiQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | FORM QUIZ
    |--------------------------------------------------------------------------
    */
    public function create(Request $request, Jadwal $jadwal)
    {
        /*
        |--------------------------------------------------------------------------
        | AMBIL SISWA
        |--------------------------------------------------------------------------
        */
        $siswa = $jadwal->kelas->siswa;

        /*
        |--------------------------------------------------------------------------
        | TANGGAL QUIZ
        |--------------------------------------------------------------------------
        */
        $tanggal = $request->tanggal
            ?? now()->toDateString();

        /*
        |--------------------------------------------------------------------------
        | CEK QUIZ BERDASARKAN TANGGAL
        |--------------------------------------------------------------------------
        */
        $quiz = Quiz::where(

                'jadwal_id',
                $jadwal->id

            )

            ->whereDate(
                'tanggal',
                $tanggal
            )

            ->first();
            $sudahQuiz = $quiz ? true : false;

        /*
        |--------------------------------------------------------------------------
        | AMBIL NILAI QUIZ
        |--------------------------------------------------------------------------
        */
        $nilaiQuiz = collect();

        if ($quiz) {

            $nilaiQuiz = NilaiQuiz::where(
                    'quiz_id',
                    $quiz->id
                )

                ->get()

                ->keyBy('siswa_id');

        }

        /*
        |--------------------------------------------------------------------------
        | VIEW
        |--------------------------------------------------------------------------
        */
        return view('tentor.quiz.create', compact(

            'jadwal',

            'quiz',

            'siswa',

            'nilaiQuiz',

            'tanggal',

            'sudahQuiz'

        ));
    }

    /*
    |--------------------------------------------------------------------------
    | SIMPAN QUIZ
    |--------------------------------------------------------------------------
    */
    public function store(Request $request, Jadwal $jadwal)
    {
        /*
        |--------------------------------------------------------------------------
        | VALIDASI
        |--------------------------------------------------------------------------
        */
        $request->validate([

            'tanggal' => 'required|date',

            'nilai' => 'required|array'

        ]);

        /*
        |--------------------------------------------------------------------------
        | BATASI 7 HARI KE BELAKANG
        |--------------------------------------------------------------------------
        */
        if (
            \Carbon\Carbon::parse($request->tanggal)
                ->lt(now()->subDays(7))
        ) {

            return back()->with(

                'error',

                'Quiz maksimal 7 hari ke belakang'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | TIDAK BOLEH TANGGAL MASA DEPAN
        |--------------------------------------------------------------------------
        */
        if (
            \Carbon\Carbon::parse($request->tanggal)
                ->gt(now())
        ) {

            return back()->with(

                'error',

                'Tanggal quiz tidak valid'

            );

        }

        /*
        |--------------------------------------------------------------------------
        | BUAT QUIZ JIKA BELUM ADA
        |--------------------------------------------------------------------------
        */
        $quiz = Quiz::firstOrCreate(

            [

                'jadwal_id' => $jadwal->id,

                'tanggal' => $request->tanggal

            ],

            [

                'judul' => 'Quiz ' .
                        ($jadwal->mataPelajaran->nama_mapel
                        ?? 'Mata Pelajaran'),

                'is_publish' => true

            ]

        );

        /*
        |--------------------------------------------------------------------------
        | SIMPAN NILAI
        |--------------------------------------------------------------------------
        */
        foreach ($request->nilai as $data) {

            // LEWATI JIKA NILAI KOSONG
            if (
                !isset($data['nilai']) ||
                $data['nilai'] === null ||
                $data['nilai'] === ''
            ) {

                continue;

            }

            NilaiQuiz::updateOrCreate(

                [

                    'quiz_id' => $quiz->id,

                    'siswa_id' => $data['siswa_id']

                ],

                [

                    'nilai' => $data['nilai']

                ]

            );
        }

        /*
        |--------------------------------------------------------------------------
        | REDIRECT
        |--------------------------------------------------------------------------
        */
        return redirect()

            ->route('tentor.quiz.create', [

                'jadwal' => $jadwal->id,

                'tanggal' => $request->tanggal

            ])

            ->with(
                'success',
                'Nilai quiz berhasil disimpan'
            );
    }
}