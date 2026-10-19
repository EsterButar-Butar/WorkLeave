<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengajuan Cuti - Admin WorkLeave</title>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF !important; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

    <!-- Compiled Project Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFFFF] text-[#2D2D2D] min-h-screen flex antialiased">

    <!-- Panggil Sidebar Admin -->
    @include('admin.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-8 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- TOP BAR HEADER -->
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 bg-[#FFFFFF]">
                    <div>
                        <h1 class="text-3xl font-bold text-[#2D2D2D] tracking-tight">
                            Riwayat Pengajuan Cuti
                        </h1>
                        <p class="text-sm text-[#5D5D5D] mt-1">
                            Tinjau permohonan cuti masuk, status persetujuan, dan verifikasi dokumen pendukung.
                        </p>
                    </div>

                    <!-- Tombol Kembali ke Dashboard -->
                    <div>
                        <a href="{{ url('/admin/dashboard') }}"
                           class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl border border-gray-200 text-xs font-semibold text-[#5D5D5D] hover:bg-gray-50 transition-colors">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5 3 12m0 0 7.5-7.5M3 12h18" />
                            </svg>
                            <span>Kembali ke Dashboard</span>
                        </a>
                    </div>
                </div>

                <!-- 1. 4 KARTU RINGKASAN PENGAJUAN -->
                @include('admin.approvals.cards')

                <!-- 2. TABEL DAFTAR PENGAJUAN LENGKAP -->
                @include('admin.approvals.table')

                <!-- 3. MODAL DETAIL & AKSI PERSETUJUAN -->
                @include('admin.approvals.modal-detail')

            </div>
        </main>
    </div>

</body>
</html>
