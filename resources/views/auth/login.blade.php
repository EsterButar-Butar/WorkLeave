<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - WorkLeave</title>
    
    <!-- Google Fonts: Poppins & Montserrat Alternates -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

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
</head>
<body class="text-wl-black bg-white min-h-screen flex items-center justify-center relative overflow-x-hidden">

    <!-- Section Brand Logo -->
    <div class="absolute top-6 left-6 flex items-center space-x-3">
        <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-10 w-auto object-contain">
        <span class="text-2xl font-bold tracking-tight text-[#9B0010] brand-font">WorkLeave.com</span>
    </div>

    <!-- Main Container -->
    <div class="w-full max-w-7xl mx-auto flex items-center justify-between px-12 lg:px-20 pt-16">

        <!-- Section Left: Illustration -->
        <div class="w-1/2 flex justify-center items-center pr-8">
            <img src="{{ asset('img/illust.png') }}" alt="Illustration" class="w-[85%] max-w-md">
        </div>

        <!-- Section Right: Form Login -->
        <div class="w-1/2 flex justify-start pl-16 items-center">
            <div class="w-full max-w-md">
                
                <h1 class="text-[40px] font-bold text-left mb-10 tracking-tight text-black">Sign in</h1>

                <form action="{{ route('login.post') }}" method="POST" class="space-y-6">
                    @csrf

                    @if (session('success'))
                        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-4 py-3 rounded-xl text-sm">
                            {{ session('success') }}
                        </div>
                    @endif

                    @if (session('info'))
                        <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded-xl text-sm">
                            {{ session('info') }}
                        </div>
                    @endif

                    @php
                        $unverifiedEmail = session('unverified_email');
                        $unverifiedUser = $unverifiedEmail ? \App\Models\User::where('email', $unverifiedEmail)->first() : null;
                        $quickVerifyUrl = null;
                        if ($unverifiedUser && !$unverifiedUser->hasVerifiedEmail()) {
                            $quickVerifyUrl = \Illuminate\Support\Facades\URL::temporarySignedRoute(
                                'verification.verify',
                                now()->addMinutes(60),
                                ['id' => $unverifiedUser->id, 'hash' => sha1($unverifiedUser->getEmailForVerification())]
                            );
                        }
                    @endphp

                    @if ($errors->any())
                        <div class="bg-red-50 border border-red-200 text-red-700 px-4 py-3.5 rounded-xl text-sm space-y-3">
                            <p class="font-medium">{{ $errors->first() }}</p>

                            @if ($unverifiedEmail)
                                <div class="pt-2.5 border-t border-red-200/80 space-y-2.5">
                                    <div class="flex items-center gap-2 flex-wrap">
                                        <!-- Tombol Kirim Ulang -->
                                        <button type="submit" form="resendVerificationForm" class="text-xs font-semibold text-[#C12132] hover:underline inline-flex items-center gap-1.5 cursor-pointer">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                                            </svg>
                                            <span>Kirim ulang email verifikasi</span>
                                        </button>

                                        @if ($quickVerifyUrl)
                                            <!-- Tombol Akses Cepat Verifikasi Lokal -->
                                            <a href="{{ $quickVerifyUrl }}" class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg bg-[#C12132] text-white text-xs font-semibold hover:bg-[#9B0010] shadow-xs transition-colors">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                                </svg>
                                                <span>Verifikasi Akun Ini Sekarang</span>
                                            </a>
                                        @endif
                                    </div>

                                    <div class="text-[11px] text-gray-500 leading-relaxed bg-white/70 p-2.5 rounded-lg border border-red-100">
                                        💡 <b>Info Pengujian:</b> Driver email saat ini adalah <code>log</code> (tidak dikirim ke server Gmail asli). Anda dapat langsung mengklik tombol merah <b>"Verifikasi Akun Ini Sekarang"</b> di atas atau mengecek tautan di file <code>storage/logs/laravel.log</code>.
                                    </div>
                                </div>
                            @endif
                        </div>
                    @endif

                    <div>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="Enter email address"
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl focus:outline-none focus:ring-1 focus:ring-wl-red-light placeholder:text-wl-input-text placeholder:font-light">
                    </div>

                    <div class="relative">
                        <input type="password" name="password" id="password-input" required placeholder="Password"
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl focus:outline-none focus:ring-1 focus:ring-wl-red-light placeholder:text-wl-input-text placeholder:font-light">
                        
                        <div onclick="togglePassword()" class="absolute inset-y-0 right-6 flex items-center cursor-pointer text-wl-grey-light hover:text-wl-grey-dark">
                            <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />
                            </svg>
                        </div>
                    </div>

                    <div class="flex justify-end pt-1 pr-1">
                        <a href="{{ url('/forgot-password') }}" class="text-wl-grey-light text-sm hover:text-wl-red-light transition-colors">Forgot password ?</a>
                    </div>

                    <div class="pt-4 pb-2">
                        <button type="submit"
                            class="w-full bg-[#C12132] text-white font-medium py-4 rounded-xl hover:bg-wl-red-dark transition-all duration-300 shadow-[0_8px_25px_rgba(193,33,50,0.25)]">
                            Login
                        </button>
                    </div>
                </form>
                
                @if ($unverifiedEmail)
                    <form id="resendVerificationForm" action="{{ route('verification.resend') }}" method="POST" class="hidden">
                        @csrf
                        <input type="hidden" name="email" value="{{ $unverifiedEmail }}">
                    </form>
                @endif

                <p class="text-left text-wl-black mt-6 text-[15px]">
                    Don't have an Account? <a href="{{ url('/register') }}" class="text-[#C12132] font-semibold hover:underline ml-1">Register here !</a>
                </p>

            </div>
        </div>

    </div>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById('password-input');
            const eyeIcon = document.getElementById('eye-icon');
            
            if (passwordInput.type === 'password') {
                passwordInput.type = 'text';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />`;
            } else {
                passwordInput.type = 'password';
                eyeIcon.innerHTML = `<path stroke-linecap="round" stroke-linejoin="round" d="M3.98 8.223A10.477 10.477 0 0 0 1.934 12C3.226 16.338 7.244 19.5 12 19.5c.993 0 1.953-.138 2.863-.395M6.228 6.228A10.45 10.45 0 0 1 12 4.5c4.756 0 8.773 3.162 10.065 7.498a10.523 10.523 0 0 1-4.293 5.774M6.228 6.228 3 3m3.228 3.228 3.65 3.65m7.894 7.894L21 21m-3.228-3.228-3.65-3.65m0 0a3 3 0 1 0-4.243-4.243m4.242 4.242L9.88 9.88" />`;
            }
        }
    </script>
</body>
</html>