<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pegawai - WorkLeave</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF !important; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

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
                        'wl-white': '#FFFFFF',
                        'wl-sidebar-bg': '#FFFBFB'
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-[#FFFFFF] text-wl-black min-h-screen flex antialiased">

    <!-- Panggil Sidebar -->
    @include('user.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-8 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- TOP BAR INFO USER -->
                <div class="flex items-center justify-between bg-[#FFFFFF]">
                    <div>
                        <p class="text-sm text-[#5D5D5D] font-medium">Selamat datang,</p>
                        <h1 class="text-3xl lg:text-4xl font-bold text-[#2D2D2D] tracking-tight mt-1">
                            Najmiyatul
                        </h1>
                        <p class="text-sm text-[#5D5D5D] mt-1.5">Pantau pengajuan cuti anda disini</p>
                    </div>

                    <div class="flex items-center gap-4">
                        <button type="button" class="relative p-2.5 bg-white border border-gray-100 shadow-sm text-gray-500 hover:bg-gray-50 rounded-2xl transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                            </svg>
                            <span class="absolute top-2 right-2 w-2 h-2 bg-[#FA232B] rounded-full border-2 border-white"></span>
                        </button>

                        <div class="flex items-center gap-3 bg-white border border-gray-100 shadow-sm px-4 py-2 rounded-2xl">
                            <img src="https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150" alt="Avatar" class="w-9 h-9 rounded-full object-cover border border-gray-200">
                            <div class="text-left">
                                <div class="text-sm font-semibold text-[#2D2D2D] leading-tight">Najmiyatul</div>
                                <div class="text-xs text-[#5D5D5D] leading-tight mt-0.5">Mitra Kerja</div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- KARTU STATISTIK SISA CUTI -->
                @include('user.dashboard.cards')

                <!-- GRID UTAMA: KALENDER & RIWAYAT CUTI -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start bg-[#FFFFFF]">
                    <div class="xl:col-span-7">
                        @include('user.dashboard.calendar')
                    </div>
                    <div class="xl:col-span-5">
                        @include('user.dashboard.recent')
                    </div>
                </div>

                <!-- BANNER AJUKAN CUTI BARU -->
                <div class="rounded-3xl p-8 bg-gradient-to-r from-[#FFF5F6] via-[#FFF1F3] to-[#FFE9EC] border border-red-100/80 relative overflow-hidden shadow-[0_2px_12px_rgba(193,33,50,0.06)] flex items-center justify-between">
                    <div class="relative z-10 max-w-lg">
                        <h3 class="text-xl font-bold text-[#2D2D2D] leading-snug">Ajukan Cuti Baru</h3>
                        <p class="text-sm text-[#5D5D5D] mt-2 leading-relaxed">
                            Isi formulir pengajuan cuti dengan mudah dan cepat.
                        </p>
                        <a href="{{ url('/leave/create') }}"
                           class="inline-flex items-center gap-2 mt-5 px-6 py-3 rounded-xl bg-[#C12132] hover:bg-[#9B0010] text-white text-sm font-medium shadow-md shadow-red-500/20 transition-all">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                            </svg>
                            <span>Ajukan Cuti</span>
                        </a>
                    </div>
                    <img src="{{ asset('img/illust.png') }}" alt="Illustration"
                         class="absolute right-6 -bottom-4 w-52 h-auto object-contain pointer-events-none opacity-95 drop-shadow-sm">
                </div>

            </div>
        </main>
    </div>

</body>
</html>