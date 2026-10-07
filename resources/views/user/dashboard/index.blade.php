@extends('layouts.app')

@section('title', 'Dashboard Pegawai')

@section('content')
<div class="space-y-8 max-w-7xl mx-auto bg-white">
    <!-- Top Bar Info User -->
    <div class="flex items-center justify-between bg-white">
        <div>
            <p class="text-sm text-[#5D5D5D] font-medium">Selamat datang,</p>
            <h1 class="text-3xl lg:text-4xl font-bold text-[#2D2D2D] tracking-tight mt-1">
                Nama Kamu 👋
            </h1>
            <p class="text-sm text-[#5D5D5D] mt-1.5">Pantau pengajuan cuti dan sisa cuti anda disini</p>
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
                    <div class="text-sm font-semibold text-[#2D2D2D] leading-tight">Nama Kamu</div>
                    <div class="text-xs text-[#5D5D5D] leading-tight mt-0.5">Mitra Kerja</div>
                </div>
            </div>
        </div>
    </div>

    <!-- Kartu Statistik Sisa Cuti -->
    @include('user.dashboard.cards')

    <!-- Grid Utama: Kalender Cuti & Riwayat Cuti Terbaru -->
    <div class="grid grid-cols-1 xl:grid-cols-12 gap-8 items-start bg-white">
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
@endsection