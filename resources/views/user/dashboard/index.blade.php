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
    <!-- Alpine.js untuk Dropdown Profil & Notifikasi -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FFFFFF] text-wl-black min-h-screen flex antialiased">

    <!-- Sidebar -->
    @include('user.sidebar')

    <!-- Main Content Wrapper -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-8 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- Top Bar Info User -->
                <div class="flex items-center justify-between bg-[#FFFFFF]">
                    <div>
                        <p class="text-sm text-[#5D5D5D] font-medium">Selamat datang,</p>
                        <h1 class="text-3xl lg:text-4xl font-bold text-[#2D2D2D] tracking-tight mt-1">
                            {{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'Admin' : Auth::user()->name }}
                        </h1>
                        <p class="text-sm text-[#5D5D5D] mt-1.5">Pantau pengajuan cuti anda disini</p>
                    </div>

                    <div class="flex items-center gap-4">
                        
                        <!-- Dropdown Notifikasi Lonceng -->
                        <div class="relative" x-data="{ openNotif: false, unreadCount: 1, notifRead: false }">
                            <button @click="openNotif = !openNotif; unreadCount = 0; notifRead = true;" type="button" class="relative p-2.5 bg-white border border-gray-100 shadow-sm text-gray-500 hover:bg-gray-50 rounded-2xl transition-colors cursor-pointer focus:outline-none">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                                </svg>
                                <!-- Titik Indikator Unread -->
                                <span x-show="unreadCount > 0" class="absolute top-2 right-2 w-2 h-2 bg-[#FA232B] rounded-full border-2 border-white"></span>
                            </button>

                            <!-- Panggil file terpisah untuk komponen dropdown notifikasi -->
                            @include('user.dashboard.notifications')
                        </div>

                        <!-- Profil Button & Logout Dropdown -->
                        <div class="relative" x-data="{ openDropdown: false }">
                            <button @click="openDropdown = !openDropdown" class="flex items-center gap-3 bg-white border border-gray-100 shadow-sm px-4 py-2 rounded-2xl cursor-pointer focus:outline-none hover:bg-gray-50/80 transition-all">
                                <div class="w-9 h-9 rounded-full bg-gray-200 border border-gray-300 flex items-center justify-center text-gray-600 shrink-0">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                    </svg>
                                </div>
                                <div class="text-left">
                                    <div class="text-sm font-semibold text-[#2D2D2D] leading-tight">{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'Admin' : Auth::user()->name }}</div>
                                    <div class="text-xs text-[#5D5D5D] leading-tight mt-0.5">{{ Auth::user()->role === \App\Enums\UserRole::ADMIN ? 'Admin' : (Auth::user()->position ?? 'Mitra Kerja') }}</div>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 ml-2 text-gray-400 transition-transform duration-200" :class="{ 'rotate-180': openDropdown }" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>
                            </button>

                            <!-- Menu Dropdown Logout -->
                            <div x-show="openDropdown" 
                                 @click.away="openDropdown = false"
                                 x-transition:enter="transition ease-out duration-100"
                                 x-transition:enter-start="transform opacity-0 scale-95"
                                 x-transition:enter-end="transform opacity-100 scale-100"
                                 x-transition:leave="transition ease-in duration-75"
                                 x-transition:leave-start="transform opacity-100 scale-100"
                                 x-transition:leave-end="transform opacity-0 scale-95"
                                 class="absolute right-0 mt-2 w-full min-w-[160px] bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] border border-gray-100 py-2 z-50 hidden"
                                 :class="{ 'hidden': !openDropdown }">
                                
                                <form action="{{ route('logout') }}" method="POST">
                                    @csrf
                                    <button type="submit" class="w-full flex items-center gap-2.5 px-4 py-2.5 text-xs font-semibold text-[#C12132] hover:bg-red-50/60 transition-colors cursor-pointer">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 9V5.25A2.25 2.25 0 0 0 13.5 3h-6a2.25 2.25 0 0 0-2.25 2.25v13.5A2.25 2.25 0 0 0 7.5 21h6a2.25 2.25 0 0 0 2.25-2.25V15M12 9l-3 3m0 0 3 3m-3-3h12.75" />
                                        </svg>
                                        <span>Logout</span>
                                    </button>
                                </form>
                            </div>
                        </div>

                    </div>
                </div>

                <!-- Kartu Statistik Sisa Cuti -->
                @include('user.dashboard.cards')

                <!-- Grid Utama: Kalender & Riwayat Cuti -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start bg-[#FFFFFF]">
                    <div class="xl:col-span-7">
                        @include('user.dashboard.calendar')
                    </div>
                    <div class="xl:col-span-5">
                        @include('user.dashboard.recent')
                    </div>
                </div>

                <!-- Banner Ajukan Cuti Baru -->
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