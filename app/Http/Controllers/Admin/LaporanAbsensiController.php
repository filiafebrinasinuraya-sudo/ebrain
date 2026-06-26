<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Absensi;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;

class LaporanAbsensiController extends Controller
{
    public function index(Request $request)
    {
        $kelas = Kelas::orderBy('nama_kelas')->get();

        $siswa = collect();
        $absensi = collect();
        $tanggalPertemuan = collect();

        $kelasTerpilih = null;
        $bulan = null;

        // =====================
        // KELAS TERPILIH
        // =====================
        if ($request->kelas_id) {
            $kelasTerpilih = Kelas::find($request->kelas_id);
        }

        // =====================
        // BULAN TERPILIH
        // =====================
        if ($request->bulan) {
            $bulan = Carbon::parse($request->bulan);
        }

        // =====================
        // ABSENSI
        // =====================
        if ($request->kelas_id && $bulan) {

            $absensi = Absensi::whereHas('jadwal', function ($q) use ($request) {
                    $q->where('kelas_id', $request->kelas_id);
                })
                ->whereMonth('tanggal', $bulan->month)
                ->whereYear('tanggal', $bulan->year)
                ->get();

            // =====================
            // SISWA DARI ABSENSI (ANTI HILANG SAAT PINDAH KELAS)
            // =====================
            $siswa = Siswa::whereIn(
                    'id',
                    $absensi->pluck('siswa_id')->unique()
                )
                ->orderBy('nama')
                ->get();
        }

        // =====================
        // TANGGAL PERTEMUAN
        // =====================
        if ($kelasTerpilih && $bulan) {

            $hariBelajar = explode(',', $kelasTerpilih->hari_belajar);
            $jumlahHari = $bulan->daysInMonth;

            $mappingHari = [
                'Minggu' => 0,
                'Senin' => 1,
                'Selasa' => 2,
                'Rabu' => 3,
                'Kamis' => 4,
                'Jumat' => 5,
                'Sabtu' => 6,
            ];

            for ($i = 1; $i <= $jumlahHari; $i++) {

                $tanggal = Carbon::create(
                    $bulan->year,
                    $bulan->month,
                    $i
                );

                foreach ($hariBelajar as $hari) {

                    $hari = trim($hari);

                    if (isset($mappingHari[$hari]) &&
                        $tanggal->dayOfWeek == $mappingHari[$hari]) {

                        $tanggalPertemuan->push(
                            $tanggal->format('Y-m-d')
                        );
                    }
                }
            }

            // filter minggu
            if ($request->minggu_ke) {

                $minggu = (int) $request->minggu_ke;

                $tanggalPertemuan = $tanggalPertemuan
                    ->filter(function ($tgl) use ($minggu) {

                        $hari = Carbon::parse($tgl)->day;

                        return match ($minggu) {
                            1 => $hari >= 1 && $hari <= 7,
                            2 => $hari >= 8 && $hari <= 14,
                            3 => $hari >= 15 && $hari <= 21,
                            4 => $hari >= 22 && $hari <= 28,
                            5 => $hari >= 29,
                            default => true
                        };
                    })
                    ->values();
            }
        }

        return view('admin.laporan.absensi', compact(
            'kelas',
            'siswa',
            'absensi',
            'tanggalPertemuan'
        ));
    }

    public function exportPdf(Request $request)
    {
        $kelas = Kelas::findOrFail($request->kelas_id);

        $bulan = Carbon::parse($request->bulan);

        $absensi = collect();
        $siswa = collect();
        $tanggalPertemuan = collect();

        // =====================
        // AMBIL DATA ABSENSI
        // =====================
        $absensi = Absensi::whereHas('jadwal', function ($q) use ($request) {
                $q->where('kelas_id', $request->kelas_id);
            })
            ->whereMonth('tanggal', $bulan->month)
            ->whereYear('tanggal', $bulan->year)
            ->get();

        // =====================
        // AMBIL SISWA BERDASARKAN ABSENSI (ANTI HILANG SAAT PINDAH KELAS)
        // =====================
        $siswa = Siswa::whereIn(
            'id',
            $absensi->pluck('siswa_id')->unique()
        )
        ->orderBy('nama')
        ->get();

        // =====================
        // GENERATE TANGGAL PERTEMUAN
        // =====================
        $hariBelajar = explode(',', $kelas->hari_belajar);

        $mappingHari = [
            'Minggu' => 0,
            'Senin' => 1,
            'Selasa' => 2,
            'Rabu' => 3,
            'Kamis' => 4,
            'Jumat' => 5,
            'Sabtu' => 6,
        ];

        for ($i = 1; $i <= $bulan->daysInMonth; $i++) {

            $tanggal = Carbon::create(
                $bulan->year,
                $bulan->month,
                $i
            );

            foreach ($hariBelajar as $hari) {

                $hari = trim($hari);

                if (
                    isset($mappingHari[$hari]) &&
                    $tanggal->dayOfWeek == $mappingHari[$hari]
                ) {
                    $tanggalPertemuan->push(
                        $tanggal->format('Y-m-d')
                    );
                }
            }
        }

        // =====================
        // FILTER MINGGU (JIKA ADA)
        // =====================
        if ($request->minggu_ke) {

            $minggu = (int) $request->minggu_ke;

            $tanggalPertemuan = $tanggalPertemuan
                ->filter(function ($tgl) use ($minggu) {

                    $hari = Carbon::parse($tgl)->day;

                    return match ($minggu) {
                        1 => $hari >= 1 && $hari <= 7,
                        2 => $hari >= 8 && $hari <= 14,
                        3 => $hari >= 15 && $hari <= 21,
                        4 => $hari >= 22 && $hari <= 28,
                        5 => $hari >= 29,
                        default => true
                    };
                })
                ->values();
        }

        // =====================
        // GENERATE PDF
        // =====================
        $pdf = Pdf::loadView('admin.laporan.pdfabsensi', compact(
            'kelas',
            'bulan',
            'siswa',
            'absensi',
            'tanggalPertemuan'
        ));

        return $pdf->stream('laporan-absensi.pdf');
    }
}