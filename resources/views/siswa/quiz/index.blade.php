@extends('layouts.siswa')

@section('content')


<div class="max-w-5xl mx-auto space-y-6">

    {{-- ================= HEADER ================= --}}
    <div class="relative overflow-hidden
                bg-gradient-to-r
                from-blue-600 via-indigo-500 to-blue-500
                rounded-[28px]
                px-6 py-5
                shadow-lg">

        {{-- BACKGROUND ICON --}}
        <div class="absolute right-4 top-1/2
                    -translate-y-1/2
                    opacity-10 text-7xl font-bold text-white">

            📘

        </div>

        {{-- CONTENT --}}
        <div class="relative z-10">

            <p class="text-orange-100 text-xs tracking-wide uppercase">

                Riwayat Hasil Pembelajaran

            </p>

            <div class="flex items-center gap-3 mt-2">

                <div class="w-11 h-11 rounded-2xl
                            bg-white/20 backdrop-blur-md
                            flex items-center justify-center
                            text-xl">

                    📝

                </div>

                <div>

                    <h1 class="text-xl md:text-2xl
                            font-bold text-white">

                        Nilai Quiz Saya

                    </h1>

                    <p class="text-orange-100 text-sm mt-1">

                        Pantau perkembangan hasil belajar kamu

                    </p>

                </div>

            </div>

        </div>

    </div>

    {{-- ================= STATISTIK ================= --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-5">

        {{-- RATA RATA --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Rata-rata Nilai
                    </p>

                    <h2 class="text-4xl font-bold text-orange-500 mt-2">
                        {{ $rataRata ?? 0 }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl">
                    📊
                </div>

            </div>

        </div>

        {{-- TERTINGGI --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Nilai Tertinggi
                    </p>

                    <h2 class="text-4xl font-bold text-green-600 mt-2">
                        {{ $tertinggi ?? 0 }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-green-100 flex items-center justify-center text-2xl">
                    🏆
                </div>

            </div>

        </div>

        {{-- TOTAL QUIZ --}}
        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex items-center justify-between">

                <div>

                    <p class="text-sm text-gray-400">
                        Total Quiz
                    </p>

                    <h2 class="text-4xl font-bold text-blue-600 mt-2">
                        {{ $totalQuiz }}
                    </h2>

                </div>

                <div class="w-14 h-14 rounded-2xl bg-blue-100 flex items-center justify-center text-2xl">
                    📘
                </div>

            </div>

        </div>

    </div>

    {{-- ================= MOTIVASI ================= --}}
    <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100">

        <div class="flex items-center justify-between gap-5 flex-wrap">

            <div>

                <h2 class="text-lg font-bold text-gray-800">
                    Progress Belajar
                </h2>

                <p class="text-sm text-gray-500 mt-1">

                    @if(($rataRata ?? 0) >= 85)

                        Performa belajar kamu sangat baik 🎉

                    @elseif(($rataRata ?? 0) >= 70)

                        Pertahankan semangat belajar kamu 💪

                    @else

                        Yuk tingkatkan lagi hasil belajar kamu 🚀

                    @endif

                </p>

            </div>

            <div class="text-4xl font-bold text-orange-500">

                {{ $rataRata ?? 0 }}

            </div>

        </div>

    </div>

    {{-- ================= FILTER ================= --}}
    <div class="bg-white rounded-3xl p-5 shadow-sm border border-gray-100">

        <form method="GET"
            action="{{ route('siswa.quiz') }}">

            <div class="flex flex-col md:flex-row gap-4">

                {{-- BULAN --}}
                <select name="bulan"
                        class="border border-gray-200 rounded-2xl px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-orange-200">

                    <option value="">
                        Semua Bulan
                    </option>

                    @for($i = 1; $i <= 12; $i++)
                        <option value="{{ $i }}"
                            {{ request('bulan') == $i ? 'selected' : '' }}>

                            {{ \Carbon\Carbon::create()->month($i)->translatedFormat('F') }}

                        </option>
                    @endfor

                </select>

                {{-- TAHUN --}}
                <select name="tahun"
                        class="border border-gray-200 rounded-2xl px-4 py-3 text-sm
                            focus:outline-none focus:ring-2 focus:ring-orange-200">

                    <option value="">
                        Semua Tahun
                    </option>

                    @for($tahun = now()->year; $tahun >= now()->year - 3; $tahun--)
                        <option value="{{ $tahun }}"
                            {{ request('tahun') == $tahun ? 'selected' : '' }}>

                            {{ $tahun }}

                        </option>
                    @endfor

                </select>

                <button
                    class="bg-orange-500 hover:bg-orange-600
                        text-white px-6 py-3 rounded-2xl
                        text-sm font-semibold">

                    Filter

                </button>

            </div>

        </form>

    </div>

    {{-- ================= RIWAYAT QUIZ ================= --}}
    <div class="space-y-4">

        @forelse($nilaiQuiz as $n)

        <div class="bg-white rounded-3xl p-6 shadow-sm border border-gray-100 hover:shadow-md transition">

            <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between gap-5">

                {{-- LEFT --}}
                <div class="flex gap-4">

                    <div class="w-14 h-14 rounded-2xl bg-orange-100 flex items-center justify-center text-2xl shrink-0">

                        📘

                    </div>

                    <div>

                        <h2 class="text-lg font-bold text-gray-800">

                            {{ $n->quiz->judul }}

                        </h2>

                        <div class="flex flex-wrap gap-3 mt-2 text-sm text-gray-500">

                            <span>
                                📚
                                {{ $n->quiz->jadwal->mataPelajaran->nama_mapel }}
                            </span>

                            <span>
                                📅
                                {{ \Carbon\Carbon::parse($n->quiz->tanggal)->format('d M Y') }}
                            </span>

                        </div>

                    </div>

                </div>

                {{-- NILAI --}}
                <div>

                    @if($n->nilai >= 85)

                        <span class="bg-green-100 text-green-700 px-5 py-2 rounded-full text-sm font-semibold">

                            🏆 {{ $n->nilai }}

                        </span>

                    @elseif($n->nilai >= 70)

                        <span class="bg-yellow-100 text-yellow-700 px-5 py-2 rounded-full text-sm font-semibold">

                            👍 {{ $n->nilai }}

                        </span>

                    @else

                        <span class="bg-red-100 text-red-700 px-5 py-2 rounded-full text-sm font-semibold">

                            📌 {{ $n->nilai }}

                        </span>

                    @endif

                </div>

            </div>

        </div>

        @empty

        <div class="bg-white rounded-3xl p-14 shadow-sm border border-gray-100 text-center">

            <div class="text-6xl mb-4">
                📘
            </div>

            <h2 class="text-xl font-bold text-gray-700">
                Belum Ada Nilai Quiz
            </h2>

            <p class="text-sm text-gray-400 mt-2">
                Nilai quiz kamu akan muncul di sini.
            </p>

        </div>

        @endforelse
        @if($nilaiQuiz->hasPages())
            <div class="mt-6">
                {{ $nilaiQuiz->links() }}
            </div>
        @endif

    </div>

</div>

@endsection