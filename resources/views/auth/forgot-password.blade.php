<x-guest-layout>

<div class="min-h-screen flex items-center justify-center bg-gray-50 relative overflow-hidden">

    <!-- background blur -->
    <div class="absolute -top-32 -left-32 w-96 h-96 bg-indigo-200 rounded-full blur-3xl opacity-40"></div>
    <div class="absolute -bottom-32 -right-32 w-96 h-96 bg-blue-200 rounded-full blur-3xl opacity-40"></div>

    <!-- CARD -->
    <div class="w-full max-w-md bg-white rounded-2xl shadow-xl border border-gray-100 p-8 z-10">

        <!-- HEADER -->
        <div class="text-center mb-6">

            <h1 class="text-2xl font-bold text-gray-800">
                Lupa Password?
            </h1>

            <p class="text-sm text-gray-500 mt-2">
                Masukkan email Anda untuk menerima link reset password
            </p>

        </div>

        <!-- STATUS -->
        <x-auth-session-status class="mb-4" :status="session('status')" />

        <!-- FORM -->
        <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
            @csrf

            <!-- EMAIL -->
            <div>

                <label class="text-sm text-gray-600">Email</label>

                <div class="relative mt-2">

                    <span class="absolute left-3 top-3 text-gray-400">📧</span>

                    <x-text-input
                        id="email"
                        name="email"
                        type="email"
                        :value="old('email')"
                        required
                        autofocus
                        placeholder="Masukkan email Anda"
                        class="pl-10 w-full rounded-xl border-gray-200 focus:border-indigo-500 focus:ring-indigo-500" />

                </div>

                <x-input-error :messages="$errors->get('email')" class="mt-2" />

            </div>

            <!-- BUTTON -->
            <button type="submit"
                    class="w-full bg-indigo-600 hover:bg-indigo-700 text-white py-3 rounded-xl font-semibold shadow-md transition">

                Kirim Link Reset Password

            </button>

        </form>

        <!-- BACK -->
        <p class="text-center text-sm text-gray-500 mt-6">
            <a href="/login" class="text-indigo-600 hover:underline">
                Kembali ke Login
            </a>
        </p>

    </div>

</div>

</x-guest-layout>