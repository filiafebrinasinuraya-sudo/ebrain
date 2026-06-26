<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Brain Admin</title>

    <!-- FONT AWESOME -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50">

<div class="flex min-h-screen">

    <!-- OVERLAY MOBILE -->
    <div id="overlay"
         onclick="toggleSidebar()"
         class="fixed inset-0 bg-black/40 hidden z-30 md:hidden">
    </div>

    <!-- SIDEBAR -->
    <aside id="sidebar"
        class="fixed md:static z-40 w-64 min-h-screen overflow-y-auto
        flex flex-col text-white
        bg-gradient-to-b from-[#2f80ed] to-[#1e3a8a]
        shadow-xl transform -translate-x-full md:translate-x-0
        transition-all duration-300 ease-in-out">

      <!-- BRAND -->
    <div class="p-6 border-b border-white/10 flex items-center gap-3">

        <img src="/images/logo ebrain.png"
            alt="Logo"
            class="w-12 h-12 rounded-xl bg-white p-1 shadow-md">

        <div>

            <h1 class="text-lg font-bold tracking-wide text-white">
                E-Brain
            </h1>

            <p class="text-xs text-white/70">
                EXECELENT BRAIN
            </p>

        </div>

    </div>

        <!-- MENU -->
        <nav class="flex-1 p-4 space-y-1 text-sm">

          
            <!-- DASHBOARD -->
            <a href="/admin"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->is('admin') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                📊 Dashboard

            </a>

            <!-- MASTER DATA -->
            <button type="button"
                    onclick="toggleMasterData()"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/20 transition">

                <span class="flex items-center gap-3">

                    📁 Master Data

                </span>

                <i id="masterIcon"
                class="fa-solid fa-chevron-down text-xs transition-transform
                {{ request()->is('admin/siswa*') ||
                    request()->is('admin/tentor*') ||
                    request()->is('admin/program*') ||
                    request()->is('admin/mata_pelajaran*') ||
                    request()->is('admin/kelas*') ||
                    request()->is('admin/ruangan*') ||
                    request()->is('admin/sesi*')
                    ? 'rotate-180'
                    : '' }}">
                </i>

            </button>

            <!-- SUBMENU -->
            <div id="masterMenu"
                class="ml-3 mt-1 space-y-1
                {{ request()->is('admin/siswa*') ||
                    request()->is('admin/tentor*') ||
                    request()->is('admin/program*') ||
                    request()->is('admin/mata_pelajaran*') ||
                    request()->is('admin/kelas*') ||
                    request()->is('admin/ruangan*') ||
                    request()->is('admin/sesi*')
                    ? ''
                    : 'hidden' }}">

                <!-- SISWA -->
                <a href="/admin/siswa"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/siswa*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    🎓 Siswa

                </a>

                <!-- TENTOR -->
                <a href="/admin/tentor"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/tentor*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    👨‍🏫 Tentor

                </a>

                <!-- PROGRAM -->
                <a href="/admin/program"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/program*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    📘 Program

                </a>

                <!-- MAPEL -->
                <a href="{{ route('admin.mata_pelajaran.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/mata_pelajaran*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    📚 Mata Pelajaran

                </a>

                <!-- KELAS -->
                <a href="/admin/kelas"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/kelas*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    🏫 Kelas

                </a>

                <!-- RUANGAN -->
                <a href="{{ route('admin.ruangan.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/ruangan*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    🚪 Ruangan

                </a>

                <!-- SESI -->
                <a href="/admin/sesi"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/sesi*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    ⏰ Sesi

                </a>

            </div>

            <!-- AKADEMIK / JADWAL -->
            <button type="button"
                    onclick="toggleJadwalMenu()"
                    class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/20 transition">

                <span class="flex items-center gap-3">

                    📅 Jadwal

                </span>

                <i id="jadwalIcon"
                class="fa-solid fa-chevron-down text-xs transition-transform
                {{ request()->is('admin/jadwal*') ||
                    request()->is('admin/periode*')
                    ? 'rotate-180'
                    : '' }}">
                </i>

            </button>

            <!-- SUBMENU JADWAL -->
            <div id="jadwalMenu"
                class="ml-3 mt-1 space-y-1
                {{ request()->is('admin/jadwal*') ||
                    request()->is('admin/periode*')
                    ? ''
                    : 'hidden' }}">

                <!-- DATA JADWAL -->
                <a href="{{ route('jadwal.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/jadwal') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    📋 Data Jadwal

                </a>

                <!-- MATRIX -->
                <a href="{{ route('jadwal.matrix') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/jadwal/matrix*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    🧩 Matrix Jadwal

                </a>

                <!-- PERIODE -->
                <a href="{{ route('periode.index') }}"
                class="flex items-center gap-3 px-4 py-2 rounded-xl transition
                {{ request()->is('admin/periode*') ? 'bg-white/20 font-semibold' : 'hover:bg-white/20' }}">

                    📆 Periode

                </a>

            </div>

            <!-- ABSENSI -->
            <a href="/admin/absensi"    
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->is('admin/absensi*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                📝 Absensi

            </a>

            <hr class="border-white/20 my-3">

            <!-- QUIZ -->
            <a href="{{ route('quiz.index') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->is('admin/quiz*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                📝 Quiz

            </a>

            <!-- LAPORAN -->
<button type="button"
        onclick="toggleLaporanMenu()"
        class="w-full flex items-center justify-between px-4 py-3 rounded-xl hover:bg-white/20 transition">

    <span class="flex items-center gap-3">

        📊 Laporan

            </span>

            <i id="laporanIcon"
            class="fa-solid fa-chevron-down text-xs transition-transform
            {{ request()->is('admin/laporan*') ||
                request()->is('admin/laporan-siswa*')
                ? 'rotate-180'
                : '' }}">
            </i>

        </button>

        <div id="laporanMenu"
            class="ml-3 mt-1 space-y-1
            {{ request()->is('admin/laporan*') ||
                request()->is('admin/laporan-siswa*')
                ? ''
                : 'hidden' }}">

            <a href="{{ route('laporan.siswa.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->is('admin/laporan-siswa*')
                ? 'bg-white/20 font-semibold'
                : 'hover:bg-white/20' }}">

                👨‍🎓 Laporan Siswa

            </a>

            <a href="/admin/laporan/absensi"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->is('admin/laporan/absensi*')
                ? 'bg-white/20 font-semibold'
                : 'hover:bg-white/20' }}">

                📝 Laporan Absensi

            </a>

            <a href="{{ route('laporan.quiz.index') }}"
            class="flex items-center gap-3 px-4 py-2 rounded-xl transition
            {{ request()->is('admin/laporan/quiz*')
                ? 'bg-white/20 font-semibold'
                : 'hover:bg-white/20' }}">

                📚 Laporan Quiz

            </a>

        </div>

            

            <!-- USER -->
            <a href="/admin/users"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
            {{ request()->is('admin/users*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                👥 Kelola User

            </a>

            <!-- UBAH PASSWORD -->
            <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition hover:bg-white/20">

                🔐 Ubah Password

            </a>

        </nav>

        <!-- LOGOUT -->
        <div class="p-4 border-t border-white/20">

            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button
                    class="w-full bg-white text-red-500 py-3 rounded-xl
                    font-semibold hover:bg-red-50 transition">

                    <i class="fa-solid fa-right-from-bracket mr-2"></i>

                    Logout

                </button>

            </form>

        </div>

    </aside>

    <!-- MAIN -->
    <div class="flex-1 flex flex-col min-w-0">

        <!-- TOPBAR -->
        <header class="bg-white border-b border-gray-200 px-4 md:px-6 py-4
                       flex justify-between items-center shadow-sm">

            <!-- MOBILE BUTTON -->
            <button onclick="toggleSidebar()"
                    class="md:hidden text-gray-700 text-xl">

                <i class="fa-solid fa-bars"></i>

            </button>

            <!-- TITLE -->
            <h1 class="font-bold text-blue-700 text-sm md:text-lg">

                Admin  E-Brain

            </h1>

            <!-- USER -->
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full
                            bg-orange-100 text-orange-500
                            flex items-center justify-center">

                    <i class="fa-solid fa-user"></i>

                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-gray-700">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-400 capitalize">
                        {{ auth()->user()->role }}
                    </p>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-4 md:p-6">

            @if(session('success'))
                <div
                    x-data="{ show: true }"
                    x-show="show"
                    x-transition
                    x-init="setTimeout(() => show = false, 4000)"
                    class="mb-4 bg-green-100 border border-green-200
                        text-green-700 px-4 py-3 rounded-2xl">

                    ✅ {{ session('success') }}

                </div>
            @endif
           
            {{-- ERROR --}}
                @if(session('error'))
                    <div
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 4000)"
                        class="mb-4 bg-red-100 border border-red-200 text-red-700 p-4 rounded-xl">

                        ❌ {{ session('error') }}

                    </div>
                @endif

                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">

                    @yield('content')

                </div>

            </main>

    </div>

</div>


    <script>

        function toggleSidebar() {

            document.getElementById('sidebar')
                    .classList.toggle('-translate-x-full');

            document.getElementById('overlay')
                    .classList.toggle('hidden');
        }

        function toggleMasterData() {

            const menu = document.getElementById('masterMenu');
            const icon = document.getElementById('masterIcon');

            menu.classList.toggle('hidden');

            icon.classList.toggle('rotate-180');
        }

        function toggleJadwalMenu() {

            const menu = document.getElementById('jadwalMenu');
            const icon = document.getElementById('jadwalIcon');

            menu.classList.toggle('hidden');

            icon.classList.toggle('rotate-180');
        }

        function toggleLaporanMenu()
        {
            const menu = document.getElementById('laporanMenu');
            const icon = document.getElementById('laporanIcon');

            menu.classList.toggle('hidden');

            icon.classList.toggle('rotate-180');
        }   

    </script>

</body>
</html>