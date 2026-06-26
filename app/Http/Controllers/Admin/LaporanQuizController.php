<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Quiz;
use App\Models\NilaiQuiz;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;

class LaporanQuizController extends Controller
{
    public function index(Request $request)
{
    $kelas = Kelas::orderBy('nama_kelas')->get();

    $siswa = collect();
    $quiz = collect();
    $nilaiQuiz = collect();

    if ($request->kelas_id && $request->bulan) {

        $bulan = Carbon::parse($request->bulan);

        $quiz = Quiz::join('jadwal', 'jadwal.id', '=', 'quiz.jadwal_id')
            ->where('jadwal.kelas_id', $request->kelas_id)
            ->whereMonth('quiz.tanggal', $bulan->month)
            ->whereYear('quiz.tanggal', $bulan->year)
            ->orderBy('quiz.tanggal')
            ->orderBy('jadwal.sesi_id')
            ->select('quiz.*')
            ->get();

        if ($request->minggu_ke) {

            $minggu = (int) $request->minggu_ke;

            $quiz = $quiz->filter(function ($q) use ($minggu) {

                $hari = Carbon::parse($q->tanggal)->day;

                return ceil($hari / 7) == $minggu;

            })->values(); // tambahan penting
        }

        $nilaiQuiz = NilaiQuiz::whereIn(
            'quiz_id',
            $quiz->pluck('id')
        )->get();

        $siswa = Siswa::whereIn(
            'id',
            $nilaiQuiz->pluck('siswa_id')->unique()
        )
        ->orderBy('nama')
        ->get();
    }

    $rataKelas = 0;
    $nilaiTertinggi = 0;
    $nilaiTerendah = 0;

    if ($nilaiQuiz->count()) {

        $rataKelas = round($nilaiQuiz->avg('nilai'), 2);
        $nilaiTertinggi = $nilaiQuiz->max('nilai');
        $nilaiTerendah = $nilaiQuiz->min('nilai');
    }

    return view(
        'admin.laporan.quiz',
        compact(
            'kelas',
            'siswa',
            'quiz',
            'nilaiQuiz',
            'rataKelas',
            'nilaiTertinggi',
            'nilaiTerendah'
        )
    );
}
    public function exportPdf(Request $request)
    {
        Carbon::setLocale('id');

        $kelas = Kelas::findOrFail($request->kelas_id);

        $bulan = Carbon::parse($request->bulan);

        $quiz = collect();
        $nilaiQuiz = collect();
        $siswa = collect();

        // =====================
        // AMBIL QUIZ
        // =====================
       $quiz = Quiz::join('jadwal', 'jadwal.id', '=', 'quiz.jadwal_id')
        ->where('jadwal.kelas_id', $request->kelas_id)
        ->whereMonth('quiz.tanggal', $bulan->month)
        ->whereYear('quiz.tanggal', $bulan->year)
        ->orderBy('quiz.tanggal')
        ->orderBy('jadwal.sesi_id')
        ->select('quiz.*')
        ->get();


        // =====================
        // FILTER MINGGU (JIKA ADA)
        // =====================
        if ($request->minggu_ke) {

            $minggu = (int) $request->minggu_ke;

            $quiz = $quiz->filter(function ($q) use ($minggu) {

                $hari = Carbon::parse($q->tanggal)->day;

                return ceil($hari / 7) == $minggu;
            });
        }

        // =====================
        // AMBIL NILAI QUIZ (WAJIB DULU)
        // =====================
        $nilaiQuiz = NilaiQuiz::whereIn(
            'quiz_id',
            $quiz->pluck('id')
        )->get();

        // =====================
        // AMBIL SISWA BERDASARKAN NILAI (ANTI HILANG SAAT PINDAH KELAS)
        // =====================
        $siswa = Siswa::whereIn(
            'id',
            $nilaiQuiz->pluck('siswa_id')->unique()
        )
        ->orderBy('nama')
        ->get();

        // =====================
        // HITUNG STATISTIK
        // =====================
        $rataKelas = 0;
        $nilaiTertinggi = 0;
        $nilaiTerendah = 0;

        if ($nilaiQuiz->count()) {

            $rataKelas = round($nilaiQuiz->avg('nilai'), 2);
            $nilaiTertinggi = $nilaiQuiz->max('nilai');
            $nilaiTerendah = $nilaiQuiz->min('nilai');
        }

        // =====================
        // GENERATE PDF
        // =====================
        $pdf = Pdf::loadView('admin.laporan.pdfquiz', compact(
            'kelas',
            'bulan',
            'quiz',
            'nilaiQuiz',
            'siswa',
            'rataKelas',
            'nilaiTertinggi',
            'nilaiTerendah'
        ));

        return $pdf->stream('laporan-quiz.pdf');
    }

}
