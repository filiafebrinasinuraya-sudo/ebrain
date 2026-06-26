<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Siswa;
use App\Models\Kelas;

class DashboardController extends Controller
{
    public function index()
    {
        $totalSiswa = Siswa::where('status', 'Aktif')->count();

        $totalGuru = User::where('role', 'tentor')->count();

        $totalKelas = Kelas::count();

        $siswaTerbaru = Siswa::where('status', 'Aktif')
                            ->latest()
                            ->take(5)
                            ->get();

        $absensiHariIni = 0;

        return view('admin.dashboard', compact(
            'totalSiswa',
            'totalGuru',
            'totalKelas',
            'siswaTerbaru',
            'absensiHariIni'
        ));
    }
}