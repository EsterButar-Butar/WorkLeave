<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - WorkLeave</title>

    <!-- Google Fonts: Poppins -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <!-- Compiled Project Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#F8FAFC] text-[#2D2D2D] font-sans antialiased min-h-screen">
@php
    // Isolated dynamic user authentication fallback
    $authUser = auth()->user();
    $userName = $authUser?->name ?? 'Ayu Nabila';
    $userRole = $authUser ? ($authUser->role?->label() ?? 'Mitra Kerja') : 'Mitra Kerja';
    $userAvatar = 'https://images.unsplash.com/photo-1494790108377-be9c29b29330?auto=format&fit=crop&q=80&w=150';
@endphp

<div class="flex min-h-screen">

    <!-- Mobile Sidebar Backdrop Overlay -->
    <div id="sidebarBackdrop" class="fixed inset-0 bg-black/40 z-40 hidden lg:hidden transition-opacity"></div>

    <!-- Sidebar Navigation -->
    <aside id="mainSidebar"
           class="fixed top-0 bottom-0 left-0 w-64 bg-white border-r border-gray-100 z-50 flex flex-col justify-between py-6 px-5 transition-transform duration-300 -translate-x-full lg:translate-x-0 lg:static lg:z-auto">
        <div>
            <!-- Brand Logo Header -->
            <div class="flex items-center gap-3 px-2 mb-10">
                <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-10 w-auto object-contain">
                <span class="text-2xl font-bold tracking-tight text-[#9B0010]">WorkLeave.com</span>
            </div>

            <!-- Navigation Menu -->
            <nav class="space-y-2">
                <!-- Dashboard (Active) -->
                <a href="{{ url('/dashboard') }}"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl bg-[#C12132] text-white font-medium text-sm shadow-sm transition-all">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m2.25 12 8.954-8.955c.44-.439 1.152-.439 1.591 0L21.75 12M4.5 9.75v10.125c0 .621.504 1.125 1.125 1.125H9.75v-4.875c0-.621.504-1.125 1.125-1.125h2.25c.621 0 1.125.504 1.125 1.125V21h4.125c.621 0 1.125-.504 1.125-1.125V9.75M8.25 21h8.25" />
                    </svg>
                    <span>Dashboard</span>
                </a>

                <!-- Cuti (Inactive) -->
                <a href="#"
                   class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all group">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#8C8C8C] group-hover:text-[#C12132]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                    </svg>
                    <span>Cuti</span>
                </a>
            </nav>
        </div>

        <!-- Bottom Settings Menu -->
        <div class="pt-6 border-t border-gray-100">
            <a href="#"
               class="flex items-center gap-3.5 px-4 py-3 rounded-2xl text-[#5D5D5D] hover:text-[#C12132] hover:bg-[#FFF5F6] font-medium text-sm transition-all group">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 shrink-0 text-[#8C8C8C] group-hover:text-[#C12132]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.594 3.94c.09-.542.56-.94 1.11-.94h2.593c.55 0 1.02.398 1.11.94l.213 1.281c.063.374.313.686.645.87.074.04.147.083.22.127.324.196.72.257 1.075.124l1.217-.456a1.125 1.125 0 0 1 1.37.49l1.296 2.247a1.125 1.125 0 0 1-.26 1.431l-1.003.827c-.293.24-.438.613-.431.992a6.759 6.759 0 0 1 0 .255c-.007.378.138.75.43.99l1.005.828c.424.35.534.954.26 1.43l-1.298 2.247a1.125 1.125 0 0 1-1.369.491l-1.217-.456c-.355-.133-.75-.072-1.076.124a6.57 6.57 0 0 1-.22.128c-.331.183-.581.495-.644.869l-.213 1.28c-.09.543-.56.941-1.11.941h-2.594c-.55 0-1.02-.398-1.11-.94l-.213-1.281c-.062-.374-.312-.686-.644-.87a6.52 6.52 0 0 1-.22-.127c-.325-.196-.72-.257-1.076-.124l-1.217.456a1.125 1.125 0 0 1-1.369-.49l-1.297-2.247a1.125 1.125 0 0 1 .26-1.431l1.004-.827c.292-.24.437-.613.43-.992a6.932 6.932 0 0 1 0-.255c.007-.378-.138-.75-.43-.99l-1.004-.828a1.125 1.125 0 0 1-.26-1.43l1.297-2.247a1.125 1.125 0 0 1 1.37-.491l1.216.456c.356.133.751.072 1.076-.124.072-.044.146-.087.22-.128.332-.183.582-.495.644-.869l.214-1.281Z" />
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                </svg>
                <span>Pengaturan</span>
            </a>
        </div>
    </aside>

    <!-- Main Content Wrapper -->
    <div class="flex-1 flex flex-col min-w-0 overflow-y-auto">

        <!-- Top Header Bar -->
        <header class="bg-white border-b border-gray-100 px-6 lg:px-10 py-4 flex items-center justify-between sticky top-0 z-30">
            <!-- Mobile Menu Trigger -->
            <button id="mobileMenuBtn" type="button" class="lg:hidden p-2 rounded-xl text-gray-600 hover:bg-gray-100 transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M3.75 6.75h16.5M3.75 12h16.5m-16.5 5.25h16.5" />
                </svg>
            </button>

            <!-- Spacer for Desktop -->
            <div class="hidden lg:block"></div>

            <!-- Header Right Section: Notification & User Info -->
            <div class="flex items-center gap-5 ml-auto">
                <!-- Notification Bell -->
                <button type="button" class="relative p-2 text-gray-500 hover:text-gray-700 hover:bg-gray-50 rounded-xl transition-colors">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                    <!-- Red Indicator Dot -->
                    <span class="absolute top-2 right-2 w-2 h-2 bg-[#FA232B] rounded-full border-2 border-white"></span>
                </button>

                <!-- Profile Info Pill -->
                <div class="flex items-center gap-3 pl-2">
                    <img src="{{ $userAvatar }}" alt="{{ $userName }}" class="w-10 h-10 rounded-full object-cover border border-gray-200">
                    <div class="hidden sm:block text-left">
                        <div class="text-sm font-semibold text-[#2D2D2D] leading-tight">{{ $userName }}</div>
                        <div class="text-xs text-[#5D5D5D] leading-tight mt-0.5">{{ $userRole }}</div>
                    </div>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 hidden sm:block" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                    </svg>
                </div>
            </div>
        </header>

        <!-- Dashboard Main Body -->
        <main class="p-6 lg:p-10 space-y-8 max-w-7xl w-full mx-auto">

            <!-- Welcome Greeting Banner -->
            <div>
                <p class="text-sm text-[#5D5D5D] font-medium">Selamat datang,</p>
                <h1 class="text-3xl lg:text-4xl font-bold text-[#2D2D2D] tracking-tight mt-1 flex items-center gap-2">
                    {{ $userName }}
                    <span class="text-2xl">👋</span>
                </h1>
                <p class="text-sm text-[#5D5D5D] mt-1.5">Pantau pengajuan cuti dan sisa cuti anda disini</p>
            </div>

            <!-- Summary Metric Cards (4 Cards Grid) -->
            <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

                <!-- Card 1: Sisa Cuti Tahunan -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex items-center justify-between group hover:border-red-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FFF5F6] flex items-center justify-center text-[#C12132] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-[#5D5D5D] block">Sisa Cuti Tahunan</span>
                            <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">8 hari</span>
                            <span class="text-[11px] text-[#B2B3B8] block mt-0.5">dari 12 hari</span>
                        </div>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-gray-50 group-hover:bg-[#FFF5F6] text-gray-400 group-hover:text-[#C12132] flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>

                <!-- Card 2: Sisa Cuti Sakit -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex items-center justify-between group hover:border-blue-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#EFF6FF] flex items-center justify-center text-[#2563EB] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 9v6m3-3H9m12 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-[#5D5D5D] block">Sisa Cuti Sakit</span>
                            <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">5 hari</span>
                            <span class="text-[11px] text-[#B2B3B8] block mt-0.5">dari 14 hari</span>
                        </div>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-gray-50 group-hover:bg-blue-50 text-gray-400 group-hover:text-[#2563EB] flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>

                <!-- Card 3: Sisa Cuti Melahirkan / Bersalin -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex items-center justify-between group hover:border-purple-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FAF5FF] flex items-center justify-center text-[#9333EA] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M21 8.25c0-2.485-2.099-4.5-4.688-4.5-1.935 0-3.597 1.126-4.312 2.733-.715-1.607-2.377-2.733-4.313-2.733C5.1 3.75 3 5.765 3 8.25c0 7.22 9 12 9 12s9-4.78 9-12Z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-[#5D5D5D] block">Sisa Cuti Bersalin</span>
                            <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">90 hari</span>
                            <span class="text-[11px] text-[#B2B3B8] block mt-0.5">dari 90 hari</span>
                        </div>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-gray-50 group-hover:bg-purple-50 text-gray-400 group-hover:text-[#9333EA] flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>

                <!-- Card 4: Pengajuan Aktif -->
                <div class="bg-white rounded-2xl p-5 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] flex items-center justify-between group hover:border-amber-100 transition-all">
                    <div class="flex items-center gap-4">
                        <div class="w-12 h-12 rounded-2xl bg-[#FFFBEB] flex items-center justify-center text-[#D97706] shrink-0">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                        </div>
                        <div>
                            <span class="text-xs font-medium text-[#5D5D5D] block">Pengajuan Aktif</span>
                            <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">2</span>
                            <span class="text-[11px] text-[#B2B3B8] block mt-0.5">menunggu persetujuan</span>
                        </div>
                    </div>
                    <div class="w-7 h-7 rounded-full bg-gray-50 group-hover:bg-amber-50 text-gray-400 group-hover:text-[#D97706] flex items-center justify-center transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </div>
                </div>

            </div>

            <!-- Main Content Area: Kalender Cuti (Kiri) & Widgets (Kanan) -->
            <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start">

                <!-- Left Column: Kalender Cuti -->
                <div class="xl:col-span-8 bg-white rounded-3xl p-6 lg:p-7 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)] space-y-6">

                    <!-- Calendar Header Controls -->
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
                        <h2 class="text-lg font-bold text-[#2D2D2D]">Kalender Cuti</h2>

                        <div class="flex flex-wrap items-center gap-3">
                            <!-- Prev / Next Month Navigator -->
                            <div class="flex items-center gap-2 bg-[#F8FAFC] border border-gray-200 rounded-xl px-2 py-1">
                                <button id="calPrevBtn" type="button" class="p-1 text-gray-600 hover:text-[#C12132] rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                                    </svg>
                                </button>
                                <span id="calMonthLabel" class="text-xs font-semibold text-[#2D2D2D] min-w-[110px] text-center">September 2024</span>
                                <button id="calNextBtn" type="button" class="p-1 text-gray-600 hover:text-[#C12132] rounded-lg transition-colors">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </button>
                            </div>

                            <!-- Today Button -->
                            <button id="calTodayBtn" type="button" class="px-3 py-1.5 text-xs font-semibold rounded-xl border border-gray-200 text-gray-700 hover:bg-gray-50 transition-colors">
                                Today
                            </button>

                            <!-- View Switcher Controls (Month / Week / Day / List) -->
                            <div class="hidden md:flex items-center bg-[#F8FAFC] p-1 rounded-xl border border-gray-200 text-xs">
                                <button type="button" class="px-2.5 py-1 rounded-lg bg-white text-[#C12132] font-semibold shadow-xs">Bulan</button>
                                <button type="button" class="px-2.5 py-1 rounded-lg text-gray-500 hover:text-gray-900 transition-colors">Minggu</button>
                                <button type="button" class="px-2.5 py-1 rounded-lg text-gray-500 hover:text-gray-900 transition-colors">Hari</button>
                                <button type="button" class="px-2.5 py-1 rounded-lg text-gray-500 hover:text-gray-900 transition-colors">Daftar</button>
                            </div>
                        </div>
                    </div>

                    <!-- Calendar Grid Wrapper -->
                    <div class="overflow-x-auto">
                        <div class="min-w-[600px]">
                            <!-- Weekday Column Headers -->
                            <div class="grid grid-cols-7 text-center pb-3 text-xs font-semibold text-[#5D5D5D]">
                                <div>Sen</div>
                                <div>Sel</div>
                                <div>Rab</div>
                                <div>Kam</div>
                                <div>Jum</div>
                                <div>Sab</div>
                                <div>Min</div>
                            </div>

                            <!-- Calendar Day Cells Container -->
                            <div id="calendarGrid" class="grid grid-cols-7 border-t border-l border-gray-100 rounded-xl overflow-hidden">
                                <!-- Calendar cells dynamically generated by JavaScript below -->
                            </div>
                        </div>
                    </div>

                    <!-- Legend Items Footer -->
                    <div class="flex flex-wrap items-center gap-6 pt-3 text-xs text-[#5D5D5D] border-t border-gray-100">
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#FA232B]"></span>
                            <span>Cuti Saya</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#9B0010]"></span>
                            <span>Hari Libur Nasional</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#22C55E]"></span>
                            <span>Cuti Rekan Kerja</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <span class="w-2.5 h-2.5 rounded-full bg-[#CBD5E1]"></span>
                            <span>Akhir Pekan</span>
                        </div>
                    </div>

                </div>

                <!-- Right Column: Recent Requests & CTA Banner -->
                <div class="xl:col-span-4 space-y-6">

                    <!-- Widget 1: Pengajuan Cuti Terbaru -->
                    <div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
                        <!-- Widget Header -->
                        <div class="flex items-center justify-between pb-4 border-b border-gray-100 mb-4">
                            <h2 class="text-base font-bold text-[#2D2D2D]">Pengajuan Cuti Terbaru</h2>
                            <a href="#" class="text-xs font-semibold text-[#C12132] hover:text-[#9B0010] flex items-center gap-1 transition-colors">
                                Lihat Semua
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                </svg>
                            </a>
                        </div>

                        <!-- List of Leave Requests -->
                        <div class="space-y-3">

                            <!-- Request 1: Pending -->
                            <div class="p-3.5 rounded-2xl bg-[#FAFAFA] border border-gray-100 flex items-center justify-between gap-3 hover:bg-[#FFF5F6] transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 text-[#C12132] flex items-center justify-center shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-[#2D2D2D] truncate">Cuti Tahunan</h4>
                                        <p class="text-[11px] text-[#5D5D5D] truncate">8 - 11 September 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="px-2.5 py-1 rounded-full bg-[#FEF3C7] text-[#D97706] text-[11px] font-semibold">
                                        Menunggu
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Request 2: Approved -->
                            <div class="p-3.5 rounded-2xl bg-[#FAFAFA] border border-gray-100 flex items-center justify-between gap-3 hover:bg-[#FFF5F6] transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 text-[#C12132] flex items-center justify-center shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-[#2D2D2D] truncate">Cuti Sakit</h4>
                                        <p class="text-[11px] text-[#5D5D5D] truncate">14 - 15 Agustus 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="px-2.5 py-1 rounded-full bg-[#DCFCE7] text-[#16A34A] text-[11px] font-semibold">
                                        Disetujui
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>

                            <!-- Request 3: Rejected -->
                            <div class="p-3.5 rounded-2xl bg-[#FAFAFA] border border-gray-100 flex items-center justify-between gap-3 hover:bg-[#FFF5F6] transition-colors">
                                <div class="flex items-center gap-3 min-w-0">
                                    <div class="w-9 h-9 rounded-xl bg-white border border-gray-200 text-[#C12132] flex items-center justify-center shrink-0">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                        </svg>
                                    </div>
                                    <div class="min-w-0">
                                        <h4 class="text-xs font-bold text-[#2D2D2D] truncate">Cuti Tahunan</h4>
                                        <p class="text-[11px] text-[#5D5D5D] truncate">3 - 5 Juni 2024</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 shrink-0">
                                    <span class="px-2.5 py-1 rounded-full bg-[#FEE2E2] text-[#DC2626] text-[11px] font-semibold">
                                        Ditolak
                                    </span>
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                                    </svg>
                                </div>
                            </div>

                        </div>
                    </div>

                    <!-- Widget 2: Banner Ajukan Cuti Baru -->
                    <div class="rounded-3xl p-6 bg-gradient-to-br from-[#FFF5F6] via-[#FFF1F3] to-[#FFE9EC] border border-red-100/80 relative overflow-hidden shadow-[0_2px_12px_rgba(193,33,50,0.06)]">
                        <div class="relative z-10 max-w-[210px]">
                            <h3 class="text-base font-bold text-[#2D2D2D] leading-snug">Ajukan Cuti Baru</h3>
                            <p class="text-xs text-[#5D5D5D] mt-1.5 leading-relaxed">
                                Isi formulir pengajuan cuti dengan mudah dan cepat.
                            </p>
                            <a href="#"
                               class="inline-flex items-center gap-1.5 mt-4 px-4 py-2.5 rounded-xl bg-[#C12132] hover:bg-[#9B0010] text-white text-xs font-medium shadow-md shadow-red-500/20 transition-all">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.5v15m7.5-7.5h-15" />
                                </svg>
                                <span>Ajukan Cuti</span>
                            </a>
                        </div>

                        <!-- Illustration Image -->
                        <img src="{{ asset('img/illust.png') }}" alt="Illustration"
                             class="absolute -right-3 -bottom-3 w-36 h-auto object-contain pointer-events-none opacity-90 drop-shadow-sm">
                    </div>

                </div>

            </div>

        </main>
    </div>

</div>

<!-- Calendar & Responsive Logic Scripts -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // --- 1. Mobile Sidebar Toggle ---
        const mobileMenuBtn = document.getElementById('mobileMenuBtn');
        const mainSidebar = document.getElementById('mainSidebar');
        const sidebarBackdrop = document.getElementById('sidebarBackdrop');

        function toggleSidebar() {
            const isClosed = mainSidebar.classList.contains('-translate-x-full');
            if (isClosed) {
                mainSidebar.classList.remove('-translate-x-full');
                sidebarBackdrop.classList.remove('hidden');
            } else {
                mainSidebar.classList.add('-translate-x-full');
                sidebarBackdrop.classList.add('hidden');
            }
        }

        if (mobileMenuBtn) {
            mobileMenuBtn.addEventListener('click', toggleSidebar);
        }
        if (sidebarBackdrop) {
            sidebarBackdrop.addEventListener('click', toggleSidebar);
        }

        // --- 2. Interactive Calendar Implementation ---
        let currentYear = 2024;
        let currentMonth = 8; // 0-indexed: 8 is September

        const monthNames = [
            'Januari', 'Februari', 'Maret', 'April', 'Mei', 'Juni',
            'Juli', 'Agustus', 'September', 'Oktober', 'November', 'Desember'
        ];

        const monthLabel = document.getElementById('calMonthLabel');
        const calGrid = document.getElementById('calendarGrid');
        const prevBtn = document.getElementById('calPrevBtn');
        const nextBtn = document.getElementById('calNextBtn');
        const todayBtn = document.getElementById('calTodayBtn');

        // Events list mapping (format: 'YYYY-MM-DD')
        const events = {
            // Range 8-11 September 2024: Cuti Ayu Nabila
            '2024-09-08': { type: 'leave-start', label: 'Cuti - {{ $userName }}' },
            '2024-09-09': { type: 'leave-mid' },
            '2024-09-10': { type: 'leave-mid' },
            '2024-09-11': { type: 'leave-end' },
            // 17 September 2024: Cuti Rekan Kerja
            '2024-09-17': { type: 'colleague-leave' },
            // 25 September 2024: Hari Libur Nasional
            '2024-09-25': { type: 'holiday' },

            // Support September 2026 if navigated
            '2026-09-08': { type: 'leave-start', label: 'Cuti - {{ $userName }}' },
            '2026-09-09': { type: 'leave-mid' },
            '2026-09-10': { type: 'leave-mid' },
            '2026-09-11': { type: 'leave-end' },
            '2026-09-17': { type: 'colleague-leave' },
            '2026-09-25': { type: 'holiday' }
        };

        function renderCalendar(year, month) {
            monthLabel.textContent = `${monthNames[month]} ${year}`;
            calGrid.innerHTML = '';

            // Day 1 of month (Monday = 0, Sunday = 6)
            const firstDayDate = new Date(year, month, 1);
            let startDay = firstDayDate.getDay() - 1;
            if (startDay < 0) startDay = 6; // Sunday adjusted to index 6

            const daysInMonth = new Date(year, month + 1, 0).getDate();
            const daysInPrevMonth = new Date(year, month, 0).getDate();

            // Total slots to fill in 7 columns
            const totalCells = Math.ceil((startDay + daysInMonth) / 7) * 7;

            for (let i = 0; i < totalCells; i++) {
                const cell = document.createElement('div');
                cell.className = 'min-h-[72px] sm:min-h-[82px] p-1.5 sm:p-2 border-r border-b border-gray-100 flex flex-col justify-between transition-colors relative';

                let dayNumber;
                let isCurrentMonth = true;
                let cellDateStr = '';
                let isWeekend = (i % 7 === 5 || i % 7 === 6);

                if (i < startDay) {
                    // Previous month overflow days
                    isCurrentMonth = false;
                    dayNumber = daysInPrevMonth - startDay + i + 1;
                    const prevMonth = month === 0 ? 11 : month - 1;
                    const prevYear = month === 0 ? year - 1 : year;
                    cellDateStr = `${prevYear}-${String(prevMonth + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                } else if (i >= startDay + daysInMonth) {
                    // Next month overflow days
                    isCurrentMonth = false;
                    dayNumber = i - (startDay + daysInMonth) + 1;
                    const nextMonth = month === 11 ? 0 : month + 1;
                    const nextYear = month === 11 ? year + 1 : year;
                    cellDateStr = `${nextYear}-${String(nextMonth + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                } else {
                    // Current month days
                    dayNumber = i - startDay + 1;
                    cellDateStr = `${year}-${String(month + 1).padStart(2, '0')}-${String(dayNumber).padStart(2, '0')}`;
                }

                // Header number of the cell
                const dateHeader = document.createElement('span');
                dateHeader.className = `text-xs font-medium ${isCurrentMonth ? (isWeekend ? 'text-gray-400' : 'text-[#2D2D2D]') : 'text-gray-300'}`;
                dateHeader.textContent = dayNumber;
                cell.appendChild(dateHeader);

                // Check for event indicators
                const eventInfo = events[cellDateStr];
                if (eventInfo && isCurrentMonth) {
                    if (eventInfo.type === 'leave-start' || eventInfo.type === 'leave-mid' || eventInfo.type === 'leave-end') {
                        cell.classList.add('bg-[#FFF0F2]');
                        if (eventInfo.label) {
                            const badge = document.createElement('div');
                            badge.className = 'mt-auto bg-white/90 border border-red-200 text-[#C12132] text-[9px] font-semibold px-1.5 py-0.5 rounded-md flex items-center gap-1 shadow-xs truncate';
                            badge.innerHTML = `<span class="w-1.5 h-1.5 rounded-full bg-[#FA232B] shrink-0"></span><span class="truncate">${eventInfo.label}</span>`;
                            cell.appendChild(badge);
                        }
                    } else if (eventInfo.type === 'colleague-leave') {
                        cell.classList.add('bg-emerald-50/60');
                        const dot = document.createElement('div');
                        dot.className = 'mt-auto flex items-center justify-center';
                        dot.innerHTML = `<span class="w-2 h-2 rounded-full bg-[#22C55E]" title="Cuti Rekan Kerja"></span>`;
                        cell.appendChild(dot);
                    } else if (eventInfo.type === 'holiday') {
                        const dot = document.createElement('div');
                        dot.className = 'mt-auto flex items-center justify-center';
                        dot.innerHTML = `<span class="w-2 h-2 rounded-full bg-[#9B0010]" title="Hari Libur Nasional"></span>`;
                        cell.appendChild(dot);
                    }
                }

                calGrid.appendChild(cell);
            }
        }

        // Initial calendar render
        renderCalendar(currentYear, currentMonth);

        // Previous month button
        prevBtn.addEventListener('click', function () {
            currentMonth--;
            if (currentMonth < 0) {
                currentMonth = 11;
                currentYear--;
            }
            renderCalendar(currentYear, currentMonth);
        });

        // Next month button
        nextBtn.addEventListener('click', function () {
            currentMonth++;
            if (currentMonth > 11) {
                currentMonth = 0;
                currentYear++;
            }
            renderCalendar(currentYear, currentMonth);
        });

        // Today button (resets to September 2024 initial view)
        todayBtn.addEventListener('click', function () {
            currentYear = 2024;
            currentMonth = 8;
            renderCalendar(currentYear, currentMonth);
        });
    });
</script>

</body>
</html>
