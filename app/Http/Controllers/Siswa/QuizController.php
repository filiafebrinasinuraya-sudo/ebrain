<?php

namespace App\Http\Controllers\Siswa;

use App\Http\Controllers\Controller;
use App\Models\NilaiQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | NILAI QUIZ SISWA
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $siswa = auth()->user()->siswa;

        $query = NilaiQuiz::with([
                'quiz.jadwal.mataPelajaran'
            ])
            ->where(
                'siswa_id',
                $siswa->id
            );

        // FILTER BULAN
        if ($request->bulan) {
            $query->whereHas(
                'quiz',
                function ($q) use ($request) {
                    $q->whereMonth(
                        'tanggal',
                        $request->bulan
                    );
                }
            );
        }

        // FILTER TAHUN
        if ($request->tahun) {
            $query->whereHas(
                'quiz',
                function ($q) use ($request) {
                    $q->whereYear(
                        'tanggal',
                        $request->tahun
                    );
                }
            );
        }

        /*
        |--------------------------------------------------------------------------
        | HITUNG SEMUA DATA QUIZ
        |--------------------------------------------------------------------------
        */
        $allQuiz = (clone $query)->get();

        // TOTAL QUIZ
        $totalQuiz = $allQuiz->count();

        // RATA-RATA
        $rataRata = number_format(
            $allQuiz->avg('nilai') ?? 0,
            2
        );

        // NILAI TERTINGGI
        $tertinggi = $allQuiz->max('nilai') ?? 0;

        /*
        |--------------------------------------------------------------------------
        | PAGINATION
        |--------------------------------------------------------------------------
        */
        $nilaiQuiz = $query
            ->latest()
            ->paginate(5)
            ->withQueryString();

        return view('siswa.quiz.index', compact(
            'nilaiQuiz',
            'totalQuiz',
            'rataRata',
            'tertinggi'
        ));
    }
}