<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Brain Siswa</title>

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
        <nav class="flex-1 p-4 space-y-2 text-sm">

            <!-- DASHBOARD -->
            <a href="/siswa"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('siswa') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                🏠 Dashboard

            </a>

            <!-- JADWAL -->
            <a href="/siswa/jadwal"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('siswa/jadwal*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                📅 Jadwal

            </a>

            <!-- ABSENSI -->
            <a href="/siswa/absensi"
               class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('siswa/absensi*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                📝 Absensi

            </a>

            <!-- NILAI QUIZ -->
            <a href="/siswa/quiz"
                    class="flex items-center gap-3 px-4 py-3 rounded-xl transition
                    {{ request()->is('siswa/quiz*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

                        📝 Nilai Quiz

            </a>

            <a href="{{ route('profile.edit') }}"
            class="flex items-center gap-3 px-4 py-3 rounded-xl transition
               {{ request()->is('siswa/profil*') ? 'bg-white/20 font-semibold shadow' : 'hover:bg-white/20' }}">

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

                    🚪 Logout

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

                ☰

            </button>

            <!-- TITLE -->
            <h1 class="font-bold text-blue-700 text-sm md:text-lg">

                Dashboard Siswa

            </h1>

            <!-- USER -->
            <div class="flex items-center gap-3">

                <div class="w-10 h-10 rounded-full
                            bg-orange-100 text-orange-500
                            flex items-center justify-center">

                    👤

                </div>

                <div class="hidden sm:block">

                    <p class="text-sm font-semibold text-gray-700">
                        {{ auth()->user()->name }}
                    </p>

                    <p class="text-xs text-gray-400">
                        Siswa
                    </p>

                </div>

            </div>

        </header>

        <!-- CONTENT -->
        <main class="p-4 md:p-6">

            <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-4 md:p-6">

                @yield('content')

            </div>

        </main>

    </div>

</div>

<!-- SCRIPT -->
<script>

function toggleSidebar() {

    document.getElementById('sidebar')
            .classList.toggle('-translate-x-full');

    document.getElementById('overlay')
            .classList.toggle('hidden');
}

</script>

</body>
</html>