<section>
    <section>

        <header>
            <h2 class="text-xl font-bold text-gray-800">
                Ubah Password
            </h2>

            <p class="mt-2 text-sm text-gray-600">
                Gunakan halaman ini untuk mengubah password akun Anda. Pastikan password baru mudah diingat dan tidak dibagikan kepada orang lain demi menjaga keamanan akun.
            </p>
        </header>

        <form method="POST"
            action="{{ route('password.update') }}"
            class="mt-6 space-y-5">

            @csrf
            @method('PUT')

            <!-- Password Saat Ini -->
            <div>
                <x-input-label
                    for="update_password_current_password"
                    value="Password Saat Ini"
                />

                <x-text-input
                    id="update_password_current_password"
                    name="current_password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="current-password"
                    placeholder="Masukkan password saat ini"
                />

                <x-input-error
                    :messages="$errors->updatePassword->get('current_password')"
                    class="mt-2"
                />
            </div>

            <!-- Password Baru -->
            <div>
                <x-input-label
                    for="update_password_password"
                    value="Password Baru"
                />

                <x-text-input
                    id="update_password_password"
                    name="password"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    placeholder="Masukkan password baru"
                />

                <x-input-error
                    :messages="$errors->updatePassword->get('password')"
                    class="mt-2"
                />
            </div>

            <!-- Konfirmasi Password Baru -->
            <div>
                <x-input-label
                    for="update_password_password_confirmation"
                    value="Konfirmasi Password Baru"
                />

                <x-text-input
                    id="update_password_password_confirmation"
                    name="password_confirmation"
                    type="password"
                    class="mt-1 block w-full"
                    autocomplete="new-password"
                    placeholder="Ulangi password baru"
                />

                <x-input-error
                    :messages="$errors->updatePassword->get('password_confirmation')"
                    class="mt-2"
                />
            </div>

            <!-- Tombol -->
            <div class="flex items-center gap-3">

                <a href="javascript:history.back()"
                class="px-4 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition">
                    Kembali
                </a>

                <x-primary-button>
                    Simpan Perubahan
                </x-primary-button>

                @if (session('status') === 'password-updated')
                    <span
                        x-data="{ show: true }"
                        x-show="show"
                        x-transition
                        x-init="setTimeout(() => show = false, 3000)"
                        class="text-sm text-green-600 font-medium"
                    >
                        Password berhasil diperbarui.
                    </span>
                @endif

            </div>

        </form>

    </section>

</section>
