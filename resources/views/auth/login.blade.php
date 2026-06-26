<x-guest-layout>

<div class="min-h-screen flex items-center justify-center
            bg-gradient-to-br from-[#eef5ff] via-[#f8fbff] to-[#fff4e6] p-6">

    <!-- CARD -->
    <div class="w-full max-w-5xl bg-white rounded-3xl
                shadow-2xl overflow-hidden grid lg:grid-cols-2">

        <!-- LEFT SIDE -->
        <div class="hidden lg:flex flex-col justify-center items-center relative
                    bg-gradient-to-b from-[#2f80ed] via-[#2563eb] to-[#1e3a8a]
                    text-white p-12">

            <!-- BLUR -->
            <div class="absolute w-72 h-72 bg-orange-300/20 rounded-full blur-3xl top-10 left-10"></div>

            <div class="absolute w-72 h-72 bg-blue-200/20 rounded-full blur-3xl bottom-10 right-10"></div>

            <!-- LOGO -->
            <img src="{{ asset('images/logo ebrain3.png') }}"
                 class="w-44 mb-6 drop-shadow-2xl"
                 alt="Logo">

            <!-- TITLE -->
            <h2 class="text-3xl font-bold text-center">
                E-Brain System
            </h2>

            <!-- DESC -->
            <p class="text-center text-sm mt-4 opacity-90 leading-relaxed max-w-sm">

                Sistem Informasi Manajemen Siswa dan Tentor
                berbasis digital untuk mempermudah pengelolaan
                data akademik secara modern dan efisien.

            </p>

        </div>

        <!-- RIGHT SIDE -->
        <div class="p-8 sm:p-12 lg:p-14 flex items-center justify-center">

            <div class="w-full max-w-md">

                <!-- MOBILE HEADER -->
                <div class="lg:hidden text-center mb-8">

                    <img src="{{ asset('images/logo ebrain3.png') }}"
                         class="w-24 mx-auto mb-4 drop-shadow-lg">

                    <h1 class="text-3xl font-bold text-blue-700">
                        E-Brain
                    </h1>

                    <p class="text-sm text-gray-500 mt-1">
                        Sistem Informasi Bimbingan Belajar
                    </p>

                </div>

                <!-- HEADER -->
                <div class="mb-8 text-center">

                    <h2 class="text-3xl font-bold text-gray-800">

                        Selamat Datang 👋

                    </h2>

                    <p class="text-gray-500 mt-3">

                        Login untuk masuk ke dashboard sistem

                    </p>

                </div>

                <!-- STATUS -->
                <x-auth-session-status
                    class="mb-4"
                    :status="session('status')" />

                <!-- FORM -->
                <form method="POST" action="{{ route('login') }}">

                    @csrf

                    <!-- EMAIL -->
                    <div class="mb-5">

                        <x-input-label
                            for="email"
                            :value="__('Email')"
                            class="text-gray-700" />

                        <x-text-input
                            id="email"
                            class="block mt-2 w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                            type="email"
                            name="email"
                            :value="old('email')"
                            required
                            autofocus />

                        <x-input-error
                            :messages="$errors->get('email')"
                            class="mt-2" />

                    </div>

                    <!-- PASSWORD -->
                    <div class="mb-5">

                        <x-input-label
                            for="password"
                            :value="__('Password')"
                            class="text-gray-700" />

                        <x-text-input
                            id="password"
                            class="block mt-2 w-full rounded-xl
                                   border-gray-300
                                   focus:border-blue-500
                                   focus:ring-blue-500"
                            type="password"
                            name="password"
                            required />

                        <x-input-error
                            :messages="$errors->get('password')"
                            class="mt-2" />

                    </div>

                    <!-- BUTTON -->
                    <button type="submit"
                            class="w-full
                                   bg-orange-500 hover:bg-orange-600
                                   text-white py-3 rounded-xl
                                   font-semibold shadow-lg transition">

                        Login ke Sistem

                    </button>

                </form>

                <!-- FOOTER -->
                <p class="text-center text-xs text-gray-400 mt-8">

                    © 2026 E-Brain Kabanjahe• All Rights Reserved

                </p>

            </div>

        </div>

    </div>

</div>

</x-guest-layout>