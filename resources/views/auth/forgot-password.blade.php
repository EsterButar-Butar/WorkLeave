```blade
<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password - WorkLeave</title>

    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>

    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'wl-red-dark': '#9B0010',
                        'wl-red-light': '#FA232B',
                        'wl-black': '#2D2D2D',
                        'wl-grey-dark': '#5D5D5D',
                        'wl-grey-light': '#B2B3B8',
                        'wl-white': '#FAFAFA',
                        'wl-input-bg': '#FFF5F6',
                        'wl-input-text': '#F3A8A8'
                    }
                }
            }
        }
    </script>

    <style>
        body {
            font-family: 'Poppins', sans-serif;
        }

        .brand-font {
            font-family: 'Montserrat Alternates', sans-serif;
        }
    </style>
</head>

<body class="text-wl-black bg-white min-h-screen flex items-center justify-center relative overflow-x-hidden">

    <!-- Logo WorkLeave -->
    <div class="absolute top-6 left-6 flex items-center space-x-3">
        <img src="{{ asset('img/logo.png') }}"
             alt="WorkLeave"
             class="h-10 w-auto object-contain">

        <span class="text-2xl font-bold tracking-tight text-[#9B0010] brand-font">
            WorkLeave.com
        </span>
    </div>

    <!-- Konten Utama -->
    <div class="w-full max-w-7xl mx-auto flex items-center justify-between px-6 md:px-12 lg:px-20 py-24">

        <!-- Ilustrasi -->
        <div class="hidden md:flex w-1/2 justify-center items-center pr-8">
            <img src="{{ asset('img/illust.png') }}"
                 alt="Ilustrasi reset password WorkLeave"
                 class="w-[85%] max-w-md">
        </div>

        <!-- Form Reset Password -->
        <div class="w-full md:w-1/2 flex justify-center md:justify-start md:pl-8 lg:pl-16">
            <div class="w-full max-w-md">

                <h1 class="text-3xl md:text-[36px] font-bold mb-3 tracking-tight text-black">
                    Reset Password
                </h1>

                <p class="text-wl-grey-dark text-sm mb-8 leading-relaxed">
                    Buat password baru untuk akun WorkLeave Anda.
                    Gunakan password yang kuat dan jangan bagikan kepada siapa pun.
                </p>

                <!-- Pesan Kesalahan Umum -->
                @if ($errors->any())
                    <div class="mb-5 rounded-xl border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-700">
                        <p class="font-semibold mb-1">
                            Password belum berhasil diubah.
                        </p>
                        <ul class="list-disc pl-5 space-y-1">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form action="{{ route('password.update') }}"
                      method="POST"
                      class="space-y-5">

                    @csrf

                    <!-- Token reset password dari tautan email -->
                    <input type="hidden"
                           name="token"
                           value="{{ $token }}">

                    <!-- Email -->
                    <div>
                        <label for="email"
                               class="block text-sm font-medium text-wl-black mb-2">
                            Email Address
                        </label>

                        <input
                            id="email"
                            type="email"
                            name="email"
                            value="{{ old('email', $email ?? '') }}"
                            placeholder="Masukkan email terdaftar"
                            autocomplete="email"
                            required
                            readonly
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl border border-transparent focus:outline-none focus:ring-2 focus:ring-wl-red-light @error('email') border-red-500 @enderror"
                        >

                        @error('email')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Password Baru -->
                    <div>
                        <label for="password"
                               class="block text-sm font-medium text-wl-black mb-2">
                            Password Baru
                        </label>

                        <input
                            id="password"
                            type="password"
                            name="password"
                            placeholder="Masukkan password baru"
                            autocomplete="new-password"
                            minlength="8"
                            required
                            autofocus
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl border border-transparent focus:outline-none focus:ring-2 focus:ring-wl-red-light @error('password') border-red-500 @enderror"
                        >

                        <p class="mt-2 text-xs text-wl-grey-dark">
                            Password minimal 8 karakter.
                        </p>

                        @error('password')
                            <p class="mt-2 text-sm text-red-600">
                                {{ $message }}
                            </p>
                        @enderror
                    </div>

                    <!-- Konfirmasi Password -->
                    <div>
                        <label for="password_confirmation"
                               class="block text-sm font-medium text-wl-black mb-2">
                            Konfirmasi Password Baru
                        </label>

                        <input
                            id="password_confirmation"
                            type="password"
                            name="password_confirmation"
                            placeholder="Ulangi password baru"
                            autocomplete="new-password"
                            minlength="8"
                            required
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl border border-transparent focus:outline-none focus:ring-2 focus:ring-wl-red-light"
                        >
                    </div>

                    <!-- Tombol Submit -->
                    <div class="pt-2">
                        <button
                            type="submit"
                            class="w-full bg-[#C12132] text-white font-medium py-4 rounded-xl hover:bg-wl-red-dark focus:outline-none focus:ring-2 focus:ring-wl-red-light focus:ring-offset-2 transition-all duration-300 shadow-[0_8px_25px_rgba(193,33,50,0.25)]">
                            Ubah Password
                        </button>
                    </div>
                </form>

                <!-- Kembali ke Login -->
                <p class="text-wl-black mt-6 text-sm md:text-[15px]">
                    Ingat password Anda?
                    <a href="{{ route('login') }}"
                       class="text-[#C12132] font-semibold hover:underline ml-1">
                        Login di sini
                    </a>
                </p>

            </div>
        </div>
    </div>

</body>
</html>
```