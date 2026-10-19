<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan Cuti - {{ $name ?? 'Siti' }} - WorkLeave</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF !important; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFFFF] text-[#2D2D2D] min-h-screen flex antialiased">

    <!-- Panggil Sidebar Admin -->
    @include('admin.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-8 lg:p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-6 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- TOP HEADER BAR: JUDUL & TOMBOL AKSI -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 pb-2">
                    <div>
                        <h1 class="text-2xl font-bold text-[#2D2D2D] tracking-tight">
                            Riwayat Pengajuan Cuti
                        </h1>
                        <div class="flex items-center gap-1.5 text-xs text-[#5D5D5D] mt-1 font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                            </svg>
                            <span>{{ $name ?? 'Siti' }}</span>
                        </div>
                    </div>

                    <!-- Tombol Tahun & Tombol Tutup -->
                    <div class="flex items-center gap-3">
                        <!-- Tahun 2026 -->
                        <div class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-[#EFF6FF] border border-blue-100 text-xs font-semibold text-[#2563EB]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-[#2563EB]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                            </svg>
                            <span>Tahun 2026</span>
                        </div>

                        <!-- Tombol Tutup (Kembali ke Dashboard) -->
                        <a href="{{ url('/admin/dashboard') }}"
                           class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-xs font-semibold text-[#5D5D5D] hover:text-[#2D2D2D] transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                            </svg>
                            <span>Tutup</span>
                        </a>
                    </div>
                </div>

                <!-- 1. 4 KARTU RINGKASAN KUOTA SITI -->
                @if(request('approved'))
                <!-- Banner Konfirmasi Berhasil Disetujui -->
                <div id="approvedAlert" class="p-4 rounded-2xl bg-[#E6F8F0] border border-emerald-200 text-emerald-900 flex items-center justify-between text-xs font-medium shadow-xs">
                    <div class="flex items-center gap-3">
                        <div class="w-7 h-7 rounded-full bg-emerald-100 flex items-center justify-center text-[#10B981] shrink-0">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m4.5 12.75 6 6 9-13.5" />
                            </svg>
                        </div>
                        <div>
                            <span class="font-bold text-[#10B981]">Pengajuan Berhasil Disetujui!</span>
                            <span class="text-[#2D2D2D] ml-1">Pengajuan cuti Siti (11/10/2026 – 13/10/2026) telah masuk dan dicatat di baris pertama tabel riwayat.</span>
                        </div>
                    </div>
                    <button type="button" onclick="document.getElementById('approvedAlert').remove()" class="text-gray-400 hover:text-gray-600 p-1 cursor-pointer text-sm font-bold">
                        ✕
                    </button>
                </div>
                @endif

                @include('admin.employee.cards')

                <!-- 2. TABEL RIWAYAT PENGAJUAN SITI LENGKAP -->
                @include('admin.employee.table')

            </div>
        </main>
    </div>

</body>
</html>
