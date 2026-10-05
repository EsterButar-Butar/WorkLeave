<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password - WorkLeave</title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style> body { font-family: 'Poppins', sans-serif; } </style>

    <!-- Tailwind CSS CDN -->
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

        <!-- Section Right: Form Forgot Password -->
        <div class="w-1/2 flex justify-start pl-16 items-center">
            <div class="w-full max-w-md">
                
                <h1 class="text-[36px] font-bold text-left mb-3 tracking-tight text-black">Forgot Password?</h1>
                <p class="text-wl-grey-dark text-sm mb-8 leading-relaxed">
                    Don't worry! Enter your registered email address below, and we'll send you instructions to reset your password.
                </p>

                <form action="#" method="POST" class="space-y-6">
                    <!-- Input: Email Address -->
                    <div class="relative">
                        <input type="email" placeholder="Enter your registered email"
                            class="w-full bg-wl-input-bg text-wl-black px-6 py-4 rounded-xl focus:outline-none focus:ring-1 focus:ring-wl-red-light placeholder:text-wl-input-text placeholder:font-light">
                        <div class="absolute inset-y-0 right-6 flex items-center text-wl-grey-light">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-5 h-5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21.75 6.75v10.5a2.25 2.25 0 0 1-2.25 2.25h-15a2.25 2.25 0 0 1-2.25-2.25V6.75m19.5 0A2.25 2.25 0 0 0 19.5 4.5h-15a2.25 2.25 0 0 0-2.25 2.25m19.5 0v.243a2.25 2.25 0 0 1-1.07 1.916l-7.5 4.615a2.25 2.25 0 0 1-2.36 0L3.32 8.91a2.25 2.25 0 0 1-1.07-1.916V6.75" />
                            </svg>
                        </div>
                    </div>

                    <!-- Button: Send Reset Link -->
                    <div class="pt-2 pb-2">
                        <button type="button"
                            class="w-full bg-[#C12132] text-white font-medium py-4 rounded-xl hover:bg-wl-red-dark transition-all duration-300 shadow-[0_8px_25px_rgba(193,33,50,0.25)]">
                            Send Reset Instructions
                        </button>
                    </div>
                </form>

                <!-- Link: Back to Login -->
                <p class="text-left text-wl-black mt-6 text-[15px]">
                    Remembered your password? <a href="{{ url('/') }}" class="text-[#C12132] font-semibold hover:underline ml-1">Sign in here !</a>
                </p>

            </div>
        </div>

    </div>

</body>
</html>