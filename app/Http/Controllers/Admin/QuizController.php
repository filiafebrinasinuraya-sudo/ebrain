<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Quiz;
use App\Models\Kelas;
use App\Models\NilaiQuiz;
use Illuminate\Http\Request;

class QuizController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | INDEX QUIZ
    |--------------------------------------------------------------------------
    */
    public function index(Request $request)
    {
        $query = Quiz::with([
            'jadwal.kelas',
            'jadwal.tentor',
            'jadwal.mataPelajaran',
            'nilaiQuiz'
        ]);

        // FILTER KELAS
        if ($request->kelas_id) {

            $query->whereHas('jadwal', function ($q) use ($request) {

                $q->where(
                    'kelas_id',
                    $request->kelas_id
                );

            });

        }

        $quiz = $query
            ->latest()
            ->get();

        return view('admin.quiz.index', [

            'quiz' => $quiz,

            'kelas' => Kelas::orderBy(
                'nama_kelas'
            )->get()

        ]);
    }

    /*
    |--------------------------------------------------------------------------
    | DETAIL QUIZ
    |--------------------------------------------------------------------------
    */
    public function detail(Quiz $quiz)
    {
        $quiz->load([
            'jadwal.kelas',
            'jadwal.mataPelajaran',
            'jadwal.tentor',
            'nilaiQuiz.siswa'
        ]);

        // RATA-RATA
        $rataRata = round(
            $quiz->nilaiQuiz->avg('nilai'),
            1
        );

        // NILAI TERTINGGI
        $tertinggi = $quiz->nilaiQuiz->max('nilai');

        // NILAI TERENDAH
        $terendah = $quiz->nilaiQuiz->min('nilai');

        return view('admin.quiz.detail', compact(
            'quiz',
            'rataRata',
            'tertinggi',
            'terendah'
        ));
    }

    public function editNilai($id)
    {
        $nilai = NilaiQuiz::with([
            'siswa',
            'quiz'
        ])->findOrFail($id);

        return view(
            'admin.quiz.edit',
            compact('nilai')
        );
    }

    public function updateNilai(Request $request, $id)
    {
        $request->validate([
            'nilai' => 'required|numeric|min:0|max:100',
        ]);

        $nilai = NilaiQuiz::findOrFail($id);

        $nilai->update([
            'nilai' => $request->nilai,
        ]);

        return redirect()
            ->route('quiz.detail', $nilai->quiz_id)
            ->with(
                'success',
                'Nilai quiz berhasil diperbarui.'
            );
    }
}