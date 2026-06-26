<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-50 relative overflow-hidden">

    <!-- background blur -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-200 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-40"></div>

    <!-- CARD -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8 z-10">

        <!-- ICON -->
        <div class="text-center mb-6">

            <div class="mx-auto w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center text-2xl">
                📩
            </div>

            <h1 class="text-2xl font-bold text-gray-800 mt-4">
                Verifikasi Email
            </h1>

            <p class="text-sm text-gray-500 mt-2 leading-relaxed">
                Kami telah mengirimkan link verifikasi ke email Anda.<br>
                Silakan cek inbox atau folder spam.
            </p>

        </div>

        <!-- SUCCESS MESSAGE -->
        @if (session('status') == 'verification-link-sent')
            <div class="mb-4 text-sm text-green-600 bg-green-50 p-3 rounded-xl text-center">
                Link verifikasi baru telah dikirim ke email Anda.
            </div>
        @endif

        <!-- ACTIONS -->
        <div class="space-y-3">

            <!-- RESEND EMAIL -->
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf

                <button type="submit"
                        class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold shadow-md transition">

                    Kirim Ulang Email Verifikasi

                </button>
            </form>

            <!-- LOGOUT -->
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <button type="submit"
                        class="w-full bg-gray-100 hover:bg-gray-200 text-gray-700 py-3 rounded-xl font-medium transition">

                    Keluar dari Sistem

                </button>

            </form>

        </div>

        <!-- FOOTER -->
        <p class="text-center text-xs text-gray-400 mt-6">
            Pastikan email aktif agar dapat mengakses sistem
        </p>

    </div>

</div>

</x-guest-layout>