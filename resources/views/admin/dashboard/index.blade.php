<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin - WorkLeave</title>
    
    <!-- Google Fonts: Poppins -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&family=Montserrat+Alternates:wght@600;700&display=swap" rel="stylesheet">
    <style> 
        body { font-family: 'Poppins', sans-serif; background-color: #FFFFFF !important; } 
        .brand-font { font-family: 'Montserrat Alternates', sans-serif; }
    </style>

    <!-- Compiled Project Styles & Scripts via Vite -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-[#FFFFFF] text-[#2D2D2D] min-h-screen flex antialiased">

    <!-- Panggil Komponen Sidebar Admin -->
    @include('admin.sidebar')

    <!-- MAIN CONTENT WRAPPER -->
    <div id="mainContentWrapper" class="flex-1 flex flex-col pl-72 bg-[#FFFFFF] min-h-screen min-w-0 transition-all duration-300">
        <main class="p-8 lg:p-10 bg-[#FFFFFF] flex-1">
            <div class="space-y-8 max-w-7xl mx-auto bg-[#FFFFFF]">
                
                <!-- HEADER ATAS: LOGO & JUDUL DASHBOARD -->
                <div class="flex flex-col xl:flex-row xl:items-start justify-between gap-6 pb-2 relative min-h-[160px]">
                    <div class="max-w-xl">
                        <!-- Logo Header -->
                        <div class="flex items-center gap-2.5 mb-4">
                            <img src="{{ asset('img/logo.png') }}" alt="WorkLeave" class="h-10 w-auto object-contain">
                            <span class="text-2xl font-bold tracking-tight text-[#C12132]">WorkLeave</span>
                        </div>

                        <p class="text-xs text-[#5D5D5D] font-medium">Selamat Datang Admin,</p>
                        <h1 class="text-2xl lg:text-3xl font-extrabold text-[#2D2D2D] tracking-tight mt-0.5">
                            Dashboard Admin
                        </h1>
                        <p class="text-xs text-[#8C8C8C] mt-1">
                            Kelola pengajuan cuti, data pegawai, dan keputusan admin
                        </p>
                    </div>

                    <!-- NOTIFIKASI PENGAJUAN CUTI (SESUAI DESAIN FIGMA) -->
                    <div class="w-full xl:w-auto xl:absolute xl:right-0 xl:top-0 z-40 flex flex-col items-end">
                        @include('admin.dashboard.popup-request')
                    </div>
                </div>

                <!-- 1. KARTU STATISTIK METRIK ADMIN -->
                @include('admin.dashboard.cards')

                <!-- 2. GRID UTAMA: TABEL KUOTA CUTI (KIRI) & PEGAWAI CUTI SAAT INI (KANAN) -->
                <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start bg-[#FFFFFF]">
                    <!-- Kolom Kiri: Tabel Kuota Cuti Pegawai -->
                    <div class="xl:col-span-8">
                        @include('admin.dashboard.quota-table')
                    </div>

                    <!-- Kolom Kanan: Pegawai Cuti Saat Ini -->
                    <div class="xl:col-span-4">
                        @include('admin.dashboard.today-leave')
                    </div>
                </div>

            </div>
        </main>
    </div>

</body>
</html>
