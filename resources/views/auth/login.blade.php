<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign In - WorkLeave</title>
    
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>

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
        <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-20">
        <span class="text-3xl font-bold tracking-tight text-[#9B0010]">WorkLeave.com</span>
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

                <form action="#" method="POST" class="space-y-6">
                    <div>
                        <input type="text" placeholder="Enter email or user name"
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl focus:outline-none focus:ring-1 focus:ring-wl-red-light placeholder:text-wl-input-text placeholder:font-light">
                    </div>

                    <div class="relative">
                        <input type="password" id="password-input" placeholder="Password"
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
                        <button type="button"
                            class="w-full bg-[#C12132] text-white font-medium py-4 rounded-xl hover:bg-wl-red-dark transition-all duration-300 shadow-[0_8px_25px_rgba(193,33,50,0.25)]">
                            Login
                        </button>
                    </div>
                </form>

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