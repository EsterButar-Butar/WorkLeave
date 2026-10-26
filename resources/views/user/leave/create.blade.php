<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengajuan Cuti - WorkLeave</title>
    
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
    <!-- Alpine.js untuk Dropdown Profil & Logout -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-[#FFFFFF] text-wl-black min-h-screen flex antialiased">

    <!-- Sidebar User -->
    @include('user.sidebar')

    <!-- Main Content Wrapper -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-6 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- Header Title & User Profile Dropdown -->
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-[#2D2D2D] tracking-tight">Pengajuan Cuti</h1>
                        
                        <!-- Tab Navigation Switcher -->
                        <div class="flex items-center gap-8 mt-4 border-b border-gray-200">
                            <a href="{{ route('leave.create') }}" class="pb-3 text-sm font-semibold text-[#C12132] border-b-2 border-[#C12132] transition-all">
                                Pengajuan Cuti
                            </a>
                            <a href="{{ route('leave.history') }}" class="pb-3 text-sm font-medium text-[#5D5D5D] hover:text-[#C12132] transition-all">
                                Riwayat Cuti
                            </a>
                        </div>
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

                <!-- Container Utama -->
                <div class="bg-[#F4D3D4]/50 rounded-3xl p-8 border border-red-200/40 shadow-[0_4px_24px_rgba(0,0,0,0.02)] space-y-6">
                    
                    <div class="space-y-6">
                        <h2 class="text-xl font-bold text-[#2D2D2D]">Form Pengajuan Cuti</h2>

                        <!-- Form Pengajuan Cuti -->
                        <form id="leaveCreateForm" onsubmit="handleFormSubmit(event)" method="POST" action="{{ route('leave.store') }}" enctype="multipart/form-data" class="space-y-5">
                            @csrf

                            <!-- Error Alert Box -->
                            <div id="formErrorAlert" class="hidden bg-red-50 border border-red-200 text-red-700 px-5 py-3.5 rounded-2xl text-xs space-y-1">
                            </div>
                            
                            <!-- Jenis Cuti (Custom Dropdown dengan Hover Merah) -->
                            <div class="space-y-1.5 relative" id="customSelectWrapper">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Jenis Cuti</label>

                                <!-- Hidden input untuk menyimpan nilai & kalkulasi JS (kosong pada awalnya) -->
                                <input type="hidden" id="leave_type_select" name="leave_type" value="">
                                <input type="hidden" id="leave_type_id_input" name="leave_type_id" value="">

                                <!-- Tombol Trigger Dropdown -->
                                <button type="button" 
                                        id="customSelectBtn" 
                                        onclick="toggleLeaveDropdown()" 
                                        class="w-full bg-white text-left px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm shadow-xs flex items-center justify-between cursor-pointer transition-all">
                                    <span id="customSelectLabel" class="text-gray-400 font-normal">Pilih jenis cuti</span>
                                    <svg id="customSelectChevron" xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 transition-transform duration-200" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                    </svg>
                                </button>

                                <!-- Menu Pilihan dengan Warna Hover Merah Brand WorkLeave -->
                                <div id="customSelectMenu" class="hidden absolute top-full left-0 right-0 mt-1.5 bg-white rounded-2xl border border-gray-100 shadow-[0_12px_32px_rgba(0,0,0,0.12)] overflow-hidden py-1 z-30 transition-all">
                                    @forelse ($leaveTypes ?? [] as $lt)
                                        <div onclick="selectLeaveOption('{{ $lt->code }}', '{{ $lt->id }}', '{{ $lt->name }}')" 
                                             class="px-4 py-3 text-sm text-[#2D2D2D] hover:bg-[#C12132] hover:text-white cursor-pointer transition-colors flex items-center justify-between group border-t border-gray-50 first:border-t-0">
                                            <span class="font-medium">{{ $lt->name }}</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                    @empty
                                        <div onclick="selectLeaveOption('ANNUAL', '1', 'Cuti Tahunan')" 
                                             class="px-4 py-3 text-sm text-[#2D2D2D] hover:bg-[#C12132] hover:text-white cursor-pointer transition-colors flex items-center justify-between group">
                                            <span class="font-medium">Cuti Tahunan</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <div onclick="selectLeaveOption('MATERNITY', '2', 'Cuti Bersalin')" 
                                             class="px-4 py-3 text-sm text-[#2D2D2D] hover:bg-[#C12132] hover:text-white cursor-pointer transition-colors flex items-center justify-between group border-t border-gray-50">
                                            <span class="font-medium">Cuti Bersalin</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                        <div onclick="selectLeaveOption('SICK', '3', 'Cuti Sakit')" 
                                             class="px-4 py-3 text-sm text-[#2D2D2D] hover:bg-[#C12132] hover:text-white cursor-pointer transition-colors flex items-center justify-between group border-t border-gray-50">
                                            <span class="font-medium">Cuti Sakit</span>
                                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                                            </svg>
                                        </div>
                                    @endforelse
                                </div>
                            </div>

                            <!-- Tanggal Mulai (Custom Calendar Datepicker dengan Warna) -->
                            <div class="space-y-1.5 relative" id="startDatePickerWrapper">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Tanggal Mulai</label>
                                <input type="hidden" id="start_date_input" name="start_date" value="">
                                
                                <button type="button" 
                                        id="startDateBtn" 
                                        onclick="toggleCustomDatePicker('start')" 
                                        class="w-full bg-white text-left text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm shadow-xs flex items-center justify-between cursor-pointer transition-all">
                                    <span id="startDateLabel" class="text-gray-400">Pilih tanggal mulai</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                </button>

                                <!-- Popup Kalender Tanggal Mulai -->
                                <div id="startDatePopup" class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-2xl border border-gray-100 shadow-[0_15px_40px_rgba(0,0,0,0.15)] p-4 z-40 w-72 sm:w-80 space-y-3 transition-all">
                                    <div class="flex items-center justify-between pb-1 border-b border-gray-100">
                                        <span id="startCalTitle" class="text-sm font-bold text-[#2D2D2D]">Oktober 2026</span>
                                        <div class="flex items-center gap-1 bg-[#F8FAFC] border border-gray-200 rounded-lg p-0.5">
                                            <button type="button" onclick="navigateCal('start', -1)" class="p-1 text-gray-500 hover:text-[#C12132] cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                                            </button>
                                            <button type="button" onclick="navigateCal('start', 1)" class="p-1 text-gray-500 hover:text-[#C12132] cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-7 text-center text-[10px] font-semibold text-[#5D5D5D]">
                                        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div class="text-amber-600 font-bold">Sab</div><div class="text-rose-600 font-bold">Min</div>
                                    </div>
                                    <div id="startCalGrid" class="grid grid-cols-7 gap-1 text-xs"></div>
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 text-[11px] font-medium">
                                        <button type="button" onclick="clearCalDate('start')" class="text-gray-400 hover:text-[#C12132] cursor-pointer">Hapus</button>
                                        <button type="button" onclick="selectTodayCalDate('start')" class="text-blue-600 font-semibold hover:underline cursor-pointer">Hari Ini</button>
                                    </div>
                                    <div class="pt-1.5 border-t border-gray-100 flex items-center justify-between text-[9px] text-gray-500">
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#C12132]"></span>Libur</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Sabtu</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Minggu</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-500"></span>Hari Ini</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Tanggal Selesai (Custom Calendar Datepicker dengan Warna) -->
                            <div class="space-y-1.5 relative" id="endDatePickerWrapper">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Tanggal Selesai</label>
                                <input type="hidden" id="end_date_input" name="end_date" value="">
                                
                                <button type="button" 
                                        id="endDateBtn" 
                                        onclick="toggleCustomDatePicker('end')" 
                                        class="w-full bg-white text-left text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] text-sm shadow-xs flex items-center justify-between cursor-pointer transition-all">
                                    <span id="endDateLabel" class="text-gray-400">Pilih tanggal selesai</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                                    </svg>
                                </button>

                                <!-- Popup Kalender Tanggal Selesai -->
                                <div id="endDatePopup" class="hidden absolute top-full left-0 mt-1.5 bg-white rounded-2xl border border-gray-100 shadow-[0_15px_40px_rgba(0,0,0,0.15)] p-4 z-40 w-72 sm:w-80 space-y-3 transition-all">
                                    <div class="flex items-center justify-between pb-1 border-b border-gray-100">
                                        <span id="endCalTitle" class="text-sm font-bold text-[#2D2D2D]">Oktober 2026</span>
                                        <div class="flex items-center gap-1 bg-[#F8FAFC] border border-gray-200 rounded-lg p-0.5">
                                            <button type="button" onclick="navigateCal('end', -1)" class="p-1 text-gray-500 hover:text-[#C12132] cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" /></svg>
                                            </button>
                                            <button type="button" onclick="navigateCal('end', 1)" class="p-1 text-gray-500 hover:text-[#C12132] cursor-pointer">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5"><path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" /></svg>
                                            </button>
                                        </div>
                                    </div>
                                    <div class="grid grid-cols-7 text-center text-[10px] font-semibold text-[#5D5D5D]">
                                        <div>Sen</div><div>Sel</div><div>Rab</div><div>Kam</div><div>Jum</div><div class="text-amber-600 font-bold">Sab</div><div class="text-rose-600 font-bold">Min</div>
                                    </div>
                                    <div id="endCalGrid" class="grid grid-cols-7 gap-1 text-xs"></div>
                                    <div class="flex items-center justify-between pt-2 border-t border-gray-100 text-[11px] font-medium">
                                        <button type="button" onclick="clearCalDate('end')" class="text-gray-400 hover:text-[#C12132] cursor-pointer">Hapus</button>
                                        <button type="button" onclick="selectTodayCalDate('end')" class="text-blue-600 font-semibold hover:underline cursor-pointer">Hari Ini</button>
                                    </div>
                                    <div class="pt-1.5 border-t border-gray-100 flex items-center justify-between text-[9px] text-gray-500">
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-[#C12132]"></span>Libur</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-amber-500"></span>Sabtu</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-rose-500"></span>Minggu</span>
                                        <span class="inline-flex items-center gap-1"><span class="w-2 h-2 rounded-full bg-blue-500"></span>Hari Ini</span>
                                    </div>
                                </div>
                            </div>

                            <!-- KARTU HASIL KALKULASI HARI KERJA & LIBUR NASIONAL -->
                            <div id="liveCalcCard" class="hidden rounded-2xl p-4 bg-white border border-red-200/80 shadow-xs space-y-2.5">
                                <div class="flex items-center justify-between">
                                    <div class="flex items-center gap-2">
                                        <span class="w-2.5 h-2.5 rounded-full bg-[#10B981]"></span>
                                        <span class="text-xs font-bold text-[#2D2D2D]">Kalkulasi Pemotongan Kuota:</span>
                                    </div>
                                    <span id="liveCalcBadge" class="px-3 py-1 rounded-full text-xs font-bold bg-[#FFF5F6] text-[#C12132] border border-red-200/60">
                                        0 Hari Kerja
                                    </span>
                                </div>
                                
                                <div id="liveCalcDetails" class="text-xs text-[#5D5D5D] space-y-1">
                                    <!-- Rincian kalkulasi hari -->
                                </div>

                                <div id="liveCalcHolidayAlert" class="hidden text-xs text-amber-800 bg-[#FFFBEB] p-2.5 rounded-xl border border-amber-200">
                                    <!-- Tanggal merah yang dilewati -->
                                </div>

                            </div>

                            <!-- Keterangan -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Keterangan / Alasan Cuti</label>
                                <input type="text" name="reason" id="reason_input" required placeholder="Masukkan keterangan cuti" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#FA232B] placeholder:text-gray-400 text-sm shadow-xs">
                            </div>

                            <!-- Upload File Pendukung -->
                            <div class="space-y-1.5">
                                <label class="block text-xs font-medium text-[#5D5D5D]">Upload File Pendukung (Opsional)</label>
                                <div onclick="openUploadModal()" class="w-full bg-white text-[#2D2D2D] px-4 py-3.5 rounded-xl border border-gray-200 flex items-center justify-between cursor-pointer hover:border-gray-300 transition-all shadow-xs">
                                    <div class="flex items-center gap-3 text-sm text-gray-400">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                                        </svg>
                                        <span id="uploadedFileName" class="text-xs text-gray-400">Upload file</span>
                                    </div>
                                </div>
                                <input type="file" id="realFileInput" name="attachment" class="hidden" onchange="handleFileSelected(this)">
                            </div>

                            <!-- Button Submit -->
                            <div class="pt-3">
                                <button type="submit" id="submitLeaveBtn" class="w-full bg-[#C12132] hover:bg-[#9B0010] text-white font-medium py-4 rounded-xl shadow-[0_8px_25px_rgba(193,33,50,0.25)] transition-all flex items-center justify-center gap-2 text-sm cursor-pointer">
                                    <span>Ajukan Cuti</span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 12 3.269 3.125A59.769 59.769 0 0 1 21.485 12 59.768 59.768 0 0 1 3.27 20.875L5.999 12Zm0 0h7.5" />
                                    </svg>
                                </button>
                            </div>
                        </form>
                    </div>

                </div>

            </div>
        </main>
    </div>

    <!-- Pop Up Upload File -->
    <div id="uploadModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs hidden transition-all duration-300">
        <div class="bg-white w-full max-w-lg rounded-3xl p-8 shadow-[0_20px_60px_rgba(0,0,0,0.15)] space-y-6 relative transform scale-95 transition-all duration-300" id="uploadModalContainer">
            
            <!-- Header Modal -->
            <div class="flex items-center justify-between">
                <h3 class="text-xl font-bold text-[#2D2D2D] brand-font">Upload File</h3>
                <button onclick="closeUploadModal()" class="w-8 h-8 rounded-full bg-transparent hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-[#2D2D2D] transition-colors cursor-pointer">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <!-- Desc -->
            <p class="text-xs text-[#5D5D5D]">
                You can upload one file at a time, with a maximum size of 20 MB.
            </p>

            <!-- Dropzone Area -->
            <div onclick="triggerFileBrowser()" class="border-2 border-dashed border-gray-200 hover:border-[#C12132] rounded-2xl p-8 text-center cursor-pointer bg-gray-50/50 hover:bg-[#FFF5F6]/50 transition-all space-y-3">
                <div class="w-12 h-12 rounded-2xl bg-white border border-gray-200 mx-auto flex items-center justify-center text-gray-700 shadow-xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5" />
                    </svg>
                </div>
                <div>
                    <p class="text-xs text-gray-600">
                        <span class="text-[#C12132] font-semibold">Click to upload</span> or drag and drop
                    </p>
                    <p class="text-[10px] text-gray-400 mt-1">SVG, PNG, JPG, PDF or GIF (max. 800x400px)</p>
                </div>
            </div>

        </div>
    </div>

    <!-- Pop Up Sukses Pengajuan Cuti -->
    <div id="successModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-xs hidden transition-all duration-300">
        <div class="bg-white w-full max-w-lg rounded-3xl p-8 shadow-[0_20px_60px_rgba(0,0,0,0.15)] space-y-6 relative transform scale-95 transition-all duration-300 text-center" id="successModalContainer">
            
            <!-- Tombol Close (X) di Pojok Kanan Atas -->
            <button onclick="redirectToHistory()" class="absolute top-6 right-6 w-8 h-8 rounded-full bg-transparent hover:bg-gray-100 flex items-center justify-center text-gray-400 hover:text-[#2D2D2D] transition-colors cursor-pointer">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            <!-- Icon Centang Merah -->
            <div class="w-16 h-16 rounded-full bg-[#FFF5F6] border border-red-100 mx-auto flex items-center justify-center text-[#C12132] shadow-xs mt-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                </svg>
            </div>

            <!-- Teks Informasi -->
            <div class="space-y-2">
                <h3 class="text-2xl font-bold text-[#2D2D2D] brand-font">Selamat!</h3>
                <p class="text-xs text-[#5D5D5D]">
                    Form pengajuan cuti kamu berhasil dikirim!
                </p>
            </div>

            <!-- Tombol Tutup -->
            <div class="pt-2">
                <button onclick="redirectToHistory()" class="w-full bg-[#C12132] hover:bg-[#9B0010] text-white font-medium py-3.5 rounded-xl shadow-[0_4px_15px_rgba(193,33,50,0.25)] transition-all text-sm cursor-pointer">
                    Tutup
                </button>
            </div>

        </div>
    </div>

    <!-- Script Javascript -->
    <script>
        const uploadModal = document.getElementById('uploadModal');
        const uploadModalContainer = document.getElementById('uploadModalContainer');
        const successModal = document.getElementById('successModal');
        const successModalContainer = document.getElementById('successModalContainer');

        function openUploadModal() {
            uploadModal.classList.remove('hidden');
            setTimeout(() => {
                uploadModalContainer.classList.remove('scale-95');
                uploadModalContainer.classList.add('scale-100');
            }, 10);
        }

        function closeUploadModal() {
            uploadModalContainer.classList.remove('scale-100');
            uploadModalContainer.classList.add('scale-95');
            setTimeout(() => {
                uploadModal.classList.add('hidden');
            }, 200);
        }

        function triggerFileBrowser() {
            document.getElementById('realFileInput').click();
        }

        function handleFileSelected(input) {
            if (input.files && input.files[0]) {
                let fileName = input.files[0].name;
                let fileTextSpan = document.getElementById('uploadedFileName');
                fileTextSpan.innerText = fileName;
                fileTextSpan.classList.remove('text-gray-400');
                fileTextSpan.classList.add('text-[#2D2D2D]', 'font-semibold');
                closeUploadModal();
            }
        }

        function showFormError(msg) {
            const errorAlert = document.getElementById('formErrorAlert');
            if (errorAlert) {
                errorAlert.innerHTML = `
                    <div class="flex items-center gap-2 font-semibold text-red-700">
                        <svg class="w-4 h-4 text-red-600 shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                        </svg>
                        <span>${msg}</span>
                    </div>
                `;
                errorAlert.classList.remove('hidden');
                errorAlert.scrollIntoView({ behavior: 'smooth', block: 'center' });
            } else {
                alert(msg);
            }
        }

        // Fungsi saat tombol Ajukan diklik (kirimkan data ke backend)
        async function handleFormSubmit(event) {
            event.preventDefault();
            const form = document.getElementById('leaveCreateForm') || event.target;
            const submitBtn = document.getElementById('submitLeaveBtn');
            const originalBtnHtml = submitBtn ? submitBtn.innerHTML : 'Ajukan Cuti';

            const leaveType = document.getElementById('leave_type_select').value;
            const startDate = document.getElementById('start_date_input').value;
            const endDate = document.getElementById('end_date_input').value;
            const reasonInput = document.getElementById('reason_input');
            const reason = reasonInput ? reasonInput.value.trim() : '';

            const errorAlert = document.getElementById('formErrorAlert');
            if (errorAlert) errorAlert.classList.add('hidden');

            if (!leaveType) {
                showFormError('Pilih jenis cuti terlebih dahulu.');
                return;
            }
            if (!startDate) {
                showFormError('Pilih tanggal mulai cuti.');
                return;
            }
            if (!endDate) {
                showFormError('Pilih tanggal selesai cuti.');
                return;
            }
            if (!reason || reason.length < 5) {
                showFormError('Keterangan / alasan pengajuan cuti wajib diisi minimal 5 karakter.');
                if (reasonInput) reasonInput.focus();
                return;
            }

            // Pasang mode loading pada tombol submit
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.classList.add('opacity-75', 'cursor-not-allowed');
                submitBtn.innerHTML = `
                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                    </svg>
                    <span>Mengirim Pengajuan Cuti...</span>
                `;
            }

            const formData = new FormData(form);

            try {
                const response = await fetch("{{ route('leave.store') }}", {
                    method: 'POST',
                    headers: {
                        'Accept': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: formData
                });

                const result = await response.json();

                if (response.ok && result.status === 'success') {
                    successModal.classList.remove('hidden');
                    setTimeout(() => {
                        successModalContainer.classList.remove('scale-95');
                        successModalContainer.classList.add('scale-100');
                    }, 10);
                } else {
                    const errorMsg = result.message || (result.errors ? Object.values(result.errors).flat().join('<br>') : 'Terjadi kendala saat memproses pengajuan cuti.');
                    showFormError(errorMsg);
                }
            } catch (err) {
                console.error('Submit error:', err);
                showFormError('Gagal menghubungi server. Periksa koneksi internet Anda dan coba lagi.');
            } finally {
                if (submitBtn) {
                    submitBtn.disabled = false;
                    submitBtn.classList.remove('opacity-75', 'cursor-not-allowed');
                    submitBtn.innerHTML = originalBtnHtml;
                }
            }
        }

        // Fungsi tombol Tutup / Close pada modal sukses (mengarahkan ke halaman riwayat cuti)
        function redirectToHistory() {
            window.location.href = "{{ route('leave.history') }}";
        }

        // Kalkulasi real-time pemotongan hari kerja & tanggal merah nasional
        async function calculateLiveLeave() {
            const typeSelect = document.getElementById('leave_type_select');
            const startInput = document.getElementById('start_date_input');
            const endInput = document.getElementById('end_date_input');
            const card = document.getElementById('liveCalcCard');
            const badge = document.getElementById('liveCalcBadge');
            const details = document.getElementById('liveCalcDetails');
            const holidayAlert = document.getElementById('liveCalcHolidayAlert');

            if (!startInput.value || !endInput.value) {
                card.classList.add('hidden');
                return;
            }

            if (endInput.value < startInput.value) {
                card.classList.remove('hidden');
                badge.innerText = 'Tanggal Tidak Valid';
                badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700';
                details.innerHTML = '<span class="text-rose-600 font-medium">Tanggal selesai tidak boleh lebih awal dari tanggal mulai.</span>';
                holidayAlert.classList.add('hidden');
                return;
            }

            const leaveTypeCode = typeSelect.value || 'ANNUAL';

            try {
                const response = await fetch("{{ route('leave.calculate') }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    },
                    body: JSON.stringify({
                        start_date: startInput.value,
                        end_date: endInput.value,
                        leave_type_code: leaveTypeCode
                    })
                });

                const res = await response.json();
                if (res.status === 'success') {
                    const data = res.data;
                    card.classList.remove('hidden');

                    const isWorkDaysOnly = (leaveTypeCode === 'ANNUAL' || leaveTypeCode === 'SICK');
                    const isMaternity = (leaveTypeCode === 'MATERNITY');
                    const leaveLabel = leaveTypeCode === 'SICK' ? 'cuti sakit' : (isMaternity ? 'cuti bersalin' : 'cuti tahunan');

                    let badgeTitle = isWorkDaysOnly ? `${data.deducted_days} Hari Kerja` : `${data.deducted_days} Hari Kalender`;
                    if (data.is_exceeding_max_quota) {
                        badge.innerText = `${badgeTitle} (Melebihi Kuota Max ${data.max_quota} Hari)`;
                        badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-rose-100 text-rose-700 border border-rose-200';
                    } else {
                        badge.innerText = badgeTitle;
                        badge.className = 'px-3 py-1 rounded-full text-xs font-bold bg-[#FFF5F6] text-[#C12132] border border-red-200/60';
                    }

                    let detailHtml = `
                        <p class="flex items-center justify-between">
                            <span>Total hari kalender:</span>
                            <span class="font-semibold text-gray-800">${data.total_calendar_days} hari</span>
                        </p>
                        <p class="flex items-center justify-between">
                            <span>Akhir pekan (Sabtu & Minggu):</span>
                            <span class="font-semibold ${isWorkDaysOnly ? 'text-emerald-600' : 'text-gray-800'}">
                                ${data.weekend_days} hari ${isWorkDaysOnly ? '(Lewati)' : '(Dihitung)'}
                            </span>
                        </p>
                    `;

                    if (data.holiday_days > 0) {
                        detailHtml += `
                            <p class="flex items-center justify-between">
                                <span>Hari libur nasional:</span>
                                <span class="font-semibold ${isWorkDaysOnly ? 'text-emerald-600' : 'text-gray-800'}">
                                    ${data.holiday_days} hari ${isWorkDaysOnly ? '(Lewati)' : '(Dihitung)'}
                                </span>
                            </p>
                        `;

                        let holNames = data.holidays.map(h => `<strong>${h.name}</strong> (${h.date})`).join(', ');
                        if (isWorkDaysOnly) {
                            holidayAlert.innerHTML = `🎉 Melewati libur nasional: ${holNames}. Jatah ${leaveLabel} Anda <strong>aman dan tidak dipotong</strong> pada hari tersebut.`;
                        } else {
                            holidayAlert.innerHTML = `ℹ️ Melewati libur nasional: ${holNames}. Untuk cuti bersalin, masa cuti dihitung 90 hari kalender penuh.`;
                        }
                        holidayAlert.classList.remove('hidden');
                    } else {
                        holidayAlert.classList.add('hidden');
                    }

                    if (data.is_exceeding_max_quota) {
                        detailHtml += `
                            <p class="flex items-center justify-between text-rose-600 font-semibold pt-1 border-t border-rose-100">
                                <span>Peringatan Kuota:</span>
                                <span>Melebihi batas maksimal ${data.max_quota} hari</span>
                            </p>
                        `;
                    }

                    details.innerHTML = detailHtml;

                    // Render Kartu & Warna per Tanggal (Hijau = Kerja, Oranye = Sabtu, Pink = Minggu, Merah = Libur)
                    const monthNamesIndo = ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Agu', 'Sep', 'Okt', 'Nov', 'Des'];
                    const gridContainer = document.getElementById('liveCalcDaysGrid');
                    
                    if (gridContainer && data.details && data.details.length > 0) {
                        let pillsHtml = '';
                        data.details.forEach(item => {
                            let cardBg = '';
                            let borderCls = '';
                            let textCls = '';
                            let badgeCls = '';
                            let badgeText = '';

                            if (item.is_holiday) {
                                // Libur Nasional: Merah
                                cardBg = 'bg-[#FDE8EC]';
                                borderCls = 'border-red-200';
                                textCls = 'text-[#C12132]';
                                badgeCls = 'bg-red-100 text-[#C12132] border-red-200';
                                badgeText = isWorkDaysOnly ? 'Libur (0 Hari)' : 'Libur (-1)';
                            } else if (item.is_weekend) {
                                const isSun = item.day_name === 'Minggu';
                                if (isSun) {
                                    // Minggu: Rose/Pink
                                    cardBg = 'bg-rose-50/70';
                                    borderCls = 'border-rose-200';
                                    textCls = 'text-rose-700';
                                    badgeCls = 'bg-rose-100 text-rose-700 border-rose-200';
                                    badgeText = isWorkDaysOnly ? 'Minggu (0 Hari)' : 'Minggu (-1)';
                                } else {
                                    // Sabtu: Amber/Oranye
                                    cardBg = 'bg-amber-50/70';
                                    borderCls = 'border-amber-200';
                                    textCls = 'text-amber-700';
                                    badgeCls = 'bg-amber-100 text-amber-700 border-amber-200';
                                    badgeText = isWorkDaysOnly ? 'Sabtu (0 Hari)' : 'Sabtu (-1)';
                                }
                            } else {
                                // Hari Kerja: Hijau Segar
                                cardBg = 'bg-emerald-50/60';
                                borderCls = 'border-emerald-200';
                                textCls = 'text-emerald-800';
                                badgeCls = 'bg-emerald-100 text-emerald-700 border-emerald-200';
                                badgeText = isWorkDaysOnly ? 'Hari Kerja (-1)' : 'Hari Kalender (-1)';
                            }

                            const parts = item.date.split('-');
                            const formattedDate = `${parseInt(parts[2])} ${monthNamesIndo[parseInt(parts[1]) - 1]} ${parts[0]}`;

                            pillsHtml += `
                                <div class="${cardBg} border ${borderCls} rounded-xl p-2.5 flex items-center justify-between gap-2 shadow-2xs">
                                    <div class="min-w-0">
                                        <div class="flex items-center gap-1.5">
                                            <span class="w-1.5 h-1.5 rounded-full ${item.is_holiday ? 'bg-[#C12132]' : (item.is_weekend ? (item.day_name === 'Minggu' ? 'bg-rose-500' : 'bg-amber-500') : 'bg-emerald-500')}"></span>
                                            <span class="text-xs font-bold ${textCls}">${item.day_name.slice(0, 3)}, ${formattedDate}</span>
                                        </div>
                                        ${item.holiday_name ? `<p class="text-[10px] text-[#C12132] font-semibold truncate mt-0.5" title="${item.holiday_name}">${item.holiday_name}</p>` : ''}
                                    </div>
                                    <span class="text-[10px] font-semibold px-2 py-0.5 rounded-md border ${badgeCls} shrink-0">
                                        ${badgeText}
                                    </span>
                                </div>
                            `;
                        });
                        gridContainer.innerHTML = pillsHtml;
                    }
                }
            } catch (e) {
                console.error('Calculation error:', e);
            }
        }

        // Dropdown Custom Jenis Cuti dengan Hover Merah
        function toggleLeaveDropdown() {
            const menu = document.getElementById('customSelectMenu');
            const chevron = document.getElementById('customSelectChevron');
            const btn = document.getElementById('customSelectBtn');

            if (menu.classList.contains('hidden')) {
                menu.classList.remove('hidden');
                chevron.classList.add('rotate-180');
                btn.classList.add('ring-1', 'ring-[#FA232B]', 'border-[#FA232B]');
            } else {
                closeLeaveDropdown();
            }
        }

        function closeLeaveDropdown() {
            const menu = document.getElementById('customSelectMenu');
            const chevron = document.getElementById('customSelectChevron');
            const btn = document.getElementById('customSelectBtn');

            if (menu) menu.classList.add('hidden');
            if (chevron) chevron.classList.remove('rotate-180');
            if (btn) btn.classList.remove('ring-1', 'ring-[#FA232B]', 'border-[#FA232B]');
        }

        function selectLeaveOption(code, idOrLabel, maybeLabel) {
            let id = null;
            let label = idOrLabel;
            if (maybeLabel !== undefined) {
                id = idOrLabel;
                label = maybeLabel;
            }

            const hiddenInput = document.getElementById('leave_type_select');
            const idInput = document.getElementById('leave_type_id_input');
            const labelSpan = document.getElementById('customSelectLabel');

            if (hiddenInput) hiddenInput.value = code || '';
            if (idInput && id) idInput.value = id || '';
            if (labelSpan) {
                labelSpan.innerText = label;
                if (!code) {
                    labelSpan.className = 'text-gray-400 font-normal';
                } else {
                    labelSpan.className = 'text-[#2D2D2D] font-semibold';
                }
            }

            closeLeaveDropdown();
            calculateLiveLeave();
        }

        // ============================================================
        // MESIN PREDIKSI LIBUR NASIONAL INDONESIA (GOOGLE CALENDAR STYLE)
        // Mendukung prediksi otomatis tahun berjalan hingga tahun-tahun mendatang
        // ============================================================
        const FIXED_HOLIDAYS_INDO = {
            '01-01': 'Tahun Baru Masehi',
            '05-01': 'Hari Buruh Internasional',
            '06-01': 'Hari Lahir Pancasila',
            '08-17': 'Hari Kemerdekaan Republik Indonesia',
            '12-25': 'Hari Raya Natal',
        };

        const MULTI_YEAR_LUNAR_HOLIDAYS = {
            // Tahun 2025
            '2025-01-27': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2025-01-29': 'Tahun Baru Imlek 2576 Kongzili',
            '2025-03-29': 'Hari Suci Nyepi Saka 1947',
            '2025-03-31': 'Hari Raya Idul Fitri 1446 H',
            '2025-04-01': 'Hari Raya Idul Fitri 1446 H',
            '2025-05-12': 'Hari Raya Waisak 2569 BE',
            '2025-06-06': 'Hari Raya Idul Adha 1446 H',
            '2025-06-27': 'Tahun Baru Islam 1447 Hijriah',
            '2025-09-05': 'Maulid Nabi Muhammad SAW',

            // Tahun 2026
            '2026-01-28': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2026-02-17': 'Tahun Baru Imlek 2577 Kongzili',
            '2026-03-20': 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21': 'Hari Raya Idul Fitri 1447 H',
            '2026-03-21': 'Hari Suci Nyepi Saka 1948',
            '2026-05-27': 'Hari Raya Idul Adha 1447 H',
            '2026-05-31': 'Hari Raya Waisak 2570 BE',
            '2026-06-16': 'Tahun Baru Islam 1448 Hijriah',
            '2026-08-25': 'Maulid Nabi Muhammad SAW',

            // Tahun 2027
            '2027-01-16': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2027-02-06': 'Tahun Baru Imlek 2578 Kongzili',
            '2027-03-09': 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10': 'Hari Raya Idul Fitri 1448 H',
            '2027-03-10': 'Hari Suci Nyepi Saka 1949',
            '2027-05-16': 'Hari Raya Idul Adha 1448 H',
            '2027-05-20': 'Hari Raya Waisak 2571 BE',
            '2027-06-06': 'Tahun Baru Islam 1449 Hijriah',
            '2027-08-15': 'Maulid Nabi Muhammad SAW',

            // Tahun 2028
            '2028-01-05': 'Isra Mi\'raj Nabi Muhammad SAW',
            '2028-01-26': 'Tahun Baru Imlek 2579 Kongzili',
            '2028-02-27': 'Hari Raya Idul Fitri 1449 H',
            '2028-02-28': 'Hari Raya Idul Fitri 1449 H',
            '2028-03-27': 'Hari Suci Nyepi Saka 1950',
            '2028-05-05': 'Hari Raya Idul Adha 1449 H',
            '2028-05-09': 'Hari Raya Waisak 2572 BE',
            '2028-05-26': 'Tahun Baru Islam 1450 Hijriah',
            '2028-08-04': 'Maulid Nabi Muhammad SAW',
            '2028-12-24': 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2029
            '2029-02-13': 'Tahun Baru Imlek 2580 Kongzili',
            '2029-02-15': 'Hari Raya Idul Fitri 1450 H',
            '2029-02-16': 'Hari Raya Idul Fitri 1450 H',
            '2029-03-15': 'Hari Suci Nyepi Saka 1951',
            '2029-04-24': 'Hari Raya Idul Adha 1450 H',
            '2029-05-15': 'Tahun Baru Islam 1451 Hijriah',
            '2029-05-27': 'Hari Raya Waisak 2573 BE',
            '2029-07-24': 'Maulid Nabi Muhammad SAW',
            '2029-12-14': 'Isra Mi\'raj Nabi Muhammad SAW',

            // Tahun 2030
            '2030-02-03': 'Tahun Baru Imlek 2581 Kongzili',
            '2030-02-05': 'Hari Raya Idul Fitri 1451 H',
            '2030-02-06': 'Hari Raya Idul Fitri 1451 H',
            '2030-03-05': 'Hari Suci Nyepi Saka 1952',
            '2030-04-14': 'Hari Raya Idul Adha 1451 H',
            '2030-05-04': 'Tahun Baru Islam 1452 Hijriah',
            '2030-05-16': 'Hari Raya Waisak 2574 BE',
            '2030-07-13': 'Maulid Nabi Muhammad SAW',
            '2030-12-03': 'Isra Mi\'raj Nabi Muhammad SAW',
        };

        // Algoritma Computus Astronomis untuk Hari Paskah, Wafat Yesus Kristus & Kenaikan
        function getComputusHolidays(year) {
            const a = year % 19;
            const b = Math.floor(year / 100);
            const c = year % 100;
            const d = Math.floor(b / 4);
            const e = b % 4;
            const f = Math.floor((b + 8) / 25);
            const g = Math.floor((b - f + 1) / 3);
            const h = (19 * a + b - d - g + 15) % 30;
            const i = Math.floor(c / 4);
            const k = c % 4;
            const l = (32 + 2 * e + 2 * i - h - k) % 7;
            const m = Math.floor((a + 11 * h + 22 * l) / 451);
            const month = Math.floor((h + l - 7 * m + 114) / 31);
            const day = ((h + l - 7 * m + 114) % 31) + 1;

            const easterDate = new Date(year, month - 1, day);
            const goodFriday = new Date(easterDate);
            goodFriday.setDate(easterDate.getDate() - 2);
            const ascension = new Date(easterDate);
            ascension.setDate(easterDate.getDate() + 39);

            const format = (dt) => {
                const mm = String(dt.getMonth() + 1).padStart(2, '0');
                const dd = String(dt.getDate()).padStart(2, '0');
                return `${dt.getFullYear()}-${mm}-${dd}`;
            };

            const holidays = {};
            holidays[format(goodFriday)] = 'Wafat Yesus Kristus';
            holidays[format(easterDate)] = 'Hari Paskah';
            holidays[format(ascension)] = 'Kenaikan Yesus Kristus';
            return holidays;
        }

        // Resolusi libur nasional otomatis (predictable engine)
        function resolveIndonesianHoliday(dateKey, year, mStr, dStr) {
            const mmDd = `${mStr}-${dStr}`;
            if (FIXED_HOLIDAYS_INDO[mmDd]) {
                return FIXED_HOLIDAYS_INDO[mmDd];
            }
            if (MULTI_YEAR_LUNAR_HOLIDAYS[dateKey]) {
                return MULTI_YEAR_LUNAR_HOLIDAYS[dateKey];
            }
            const computus = getComputusHolidays(year);
            if (computus[dateKey]) {
                return computus[dateKey];
            }
            return null;
        }

        const CAL_MONTH_NAMES = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        let calState = {
            start: {
                year: new Date().getFullYear(),
                month: new Date().getMonth(),
                selected: null
            },
            end: {
                year: new Date().getFullYear(),
                month: new Date().getMonth(),
                selected: null
            }
        };

        function toggleCustomDatePicker(type) {
            const popup = document.getElementById(type === 'start' ? 'startDatePopup' : 'endDatePopup');
            const otherPopup = document.getElementById(type === 'start' ? 'endDatePopup' : 'startDatePopup');
            closeLeaveDropdown();

            if (otherPopup) otherPopup.classList.add('hidden');

            if (popup.classList.contains('hidden')) {
                renderCustomCalendar(type);
                popup.classList.remove('hidden');
            } else {
                popup.classList.add('hidden');
            }
        }

        function closeAllDatePickers() {
            const startPopup = document.getElementById('startDatePopup');
            const endPopup = document.getElementById('endDatePopup');
            if (startPopup) startPopup.classList.add('hidden');
            if (endPopup) endPopup.classList.add('hidden');
        }

        function navigateCal(type, delta) {
            calState[type].month += delta;
            if (calState[type].month < 0) {
                calState[type].month = 11;
                calState[type].year--;
            } else if (calState[type].month > 11) {
                calState[type].month = 0;
                calState[type].year++;
            }
            renderCustomCalendar(type);
        }

        function renderCustomCalendar(type) {
            const state = calState[type];
            const y = state.year;
            const m = state.month;

            const titleEl = document.getElementById(type === 'start' ? 'startCalTitle' : 'endCalTitle');
            const gridEl = document.getElementById(type === 'start' ? 'startCalGrid' : 'endCalGrid');

            if (titleEl) titleEl.textContent = `${CAL_MONTH_NAMES[m]} ${y}`;
            if (!gridEl) return;

            gridEl.innerHTML = '';

            const firstDayIndex = new Date(y, m, 1).getDay();
            let startDay = firstDayIndex - 1;
            if (startDay < 0) startDay = 6;

            const totalDays = new Date(y, m + 1, 0).getDate();
            const prevTotalDays = new Date(y, m, 0).getDate();

            const today = new Date();
            const isTodayThisMonth = (today.getFullYear() === y && today.getMonth() === m);

            let cellCount = 0;

            // Hari kosong dari bulan sebelumnya
            for (let i = startDay - 1; i >= 0; i--) {
                const dayNum = prevTotalDays - i;
                const cell = document.createElement('div');
                cell.className = 'h-8 flex items-center justify-center text-gray-300 text-[11px] select-none';
                cell.textContent = dayNum;
                gridEl.appendChild(cell);
                cellCount++;
            }

            // Hari pada bulan ini
            for (let d = 1; d <= totalDays; d++) {
                const mStr = String(m + 1).padStart(2, '0');
                const dStr = String(d).padStart(2, '0');
                const dateKey = `${y}-${mStr}-${dStr}`;

                const holidayName = resolveIndonesianHoliday(dateKey, y, mStr, dStr);
                const isHoliday = !!holidayName;

                const dateObj = new Date(y, m, d);
                const dayOfWeek = dateObj.getDay(); // 0 = Minggu, 6 = Sabtu
                const isSunday = (dayOfWeek === 0);
                const isSaturday = (dayOfWeek === 6);
                const isSelected = (state.selected === dateKey);
                const isToday = isTodayThisMonth && (today.getDate() === d);

                const btn = document.createElement('button');
                btn.type = 'button';
                btn.textContent = d;

                let cls = 'h-8 w-full rounded-lg flex items-center justify-center text-xs font-medium transition-all relative cursor-pointer ';

                if (isSelected) {
                    cls += 'bg-[#C12132] text-white font-bold shadow-xs ';
                } else if (isToday) {
                    // WARNA BIRU UNTUK HARI INI
                    cls += 'bg-blue-50 text-blue-600 font-bold border border-blue-400 ring-2 ring-blue-500 hover:bg-blue-100 ';
                    btn.title = isHoliday ? `Hari Ini (${holidayName})` : 'Hari Ini';
                } else if (isHoliday) {
                    // WARNA MERAH UNTUK LIBUR NASIONAL
                    cls += 'bg-[#FDE8EC] text-[#C12132] font-bold border border-red-200 hover:bg-red-100 ';
                    btn.title = `Libur Nasional: ${holidayName}`;
                } else if (isSunday) {
                    // WARNA PINK/ROSE UNTUK HARI MINGGU
                    cls += 'bg-rose-50/70 text-rose-600 font-semibold hover:bg-rose-100 ';
                    btn.title = 'Hari Minggu (Weekend)';
                } else if (isSaturday) {
                    // WARNA AMBER/ORANYE UNTUK HARI SABTU
                    cls += 'bg-amber-50/70 text-amber-600 font-semibold hover:bg-amber-100 ';
                    btn.title = 'Hari Sabtu (Weekend)';
                } else {
                    cls += 'text-[#2D2D2D] hover:bg-gray-100 ';
                }

                btn.className = cls;
                btn.onclick = () => selectCalDate(type, dateKey, `${d} ${CAL_MONTH_NAMES[m]} ${y}`);
                gridEl.appendChild(btn);
                cellCount++;
            }

            // Sisa hari dari bulan berikutnya
            const remaining = (cellCount % 7 === 0) ? 0 : (7 - (cellCount % 7));
            for (let n = 1; n <= remaining; n++) {
                const cell = document.createElement('div');
                cell.className = 'h-8 flex items-center justify-center text-gray-300 text-[11px] select-none';
                cell.textContent = n;
                gridEl.appendChild(cell);
            }
        }

        function selectCalDate(type, dateStr, displayStr) {
            calState[type].selected = dateStr;

            const hiddenInput = document.getElementById(type === 'start' ? 'start_date_input' : 'end_date_input');
            const label = document.getElementById(type === 'start' ? 'startDateLabel' : 'endDateLabel');

            if (hiddenInput) hiddenInput.value = dateStr;
            if (label) {
                label.textContent = displayStr;
                label.classList.remove('text-gray-400');
                label.classList.add('text-[#2D2D2D]', 'font-semibold');
            }

            closeAllDatePickers();
            calculateLiveLeave();
        }

        function clearCalDate(type) {
            calState[type].selected = null;
            const hiddenInput = document.getElementById(type === 'start' ? 'start_date_input' : 'end_date_input');
            const label = document.getElementById(type === 'start' ? 'startDateLabel' : 'endDateLabel');

            if (hiddenInput) hiddenInput.value = '';
            if (label) {
                label.textContent = type === 'start' ? 'Pilih tanggal mulai' : 'Pilih tanggal selesai';
                label.classList.remove('text-[#2D2D2D]', 'font-semibold');
                label.classList.add('text-gray-400');
            }

            closeAllDatePickers();
            calculateLiveLeave();
        }

        function selectTodayCalDate(type) {
            const today = new Date();
            const y = today.getFullYear();
            const m = today.getMonth();
            const d = today.getDate();

            const mStr = String(m + 1).padStart(2, '0');
            const dStr = String(d).padStart(2, '0');
            const dateKey = `${y}-${mStr}-${dStr}`;

            calState[type].year = y;
            calState[type].month = m;

            selectCalDate(type, dateKey, `${d} ${CAL_MONTH_NAMES[m]} ${y}`);
        }

        window.addEventListener('click', function(event) {
            const customSelectWrapper = document.getElementById('customSelectWrapper');
            if (customSelectWrapper && !customSelectWrapper.contains(event.target)) {
                closeLeaveDropdown();
            }

            const startWrapper = document.getElementById('startDatePickerWrapper');
            const endWrapper = document.getElementById('endDatePickerWrapper');
            if (startWrapper && !startWrapper.contains(event.target) && endWrapper && !endWrapper.contains(event.target)) {
                closeAllDatePickers();
            }

            if (event.target == uploadModal) {
                closeUploadModal();
            }
            if (event.target == successModal) {
                redirectToHistory();
            }
        });
    </script>

</body>
</html>