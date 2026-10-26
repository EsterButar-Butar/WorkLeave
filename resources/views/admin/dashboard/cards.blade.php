@php
    // =========================================================================
    // 1. DATA REAL DARI DATABASE
    // =========================================================================

    // A. Real Pegawai Aktif (dari $dbEmployees)
    $realEmployees = [];
    if (isset($dbEmployees) && $dbEmployees->count() > 0) {
        foreach ($dbEmployees as $emp) {
            $realEmployees[] = [
                'name' => $emp->name,
                'subtitle' => ($emp->position ?? 'Mitra Kerja') . ' • ' . ($emp->department ?? 'General Operations'),
                'is_real' => true,
            ];
        }
    }

    // B. Real Cuti Disetujui (dari $dbApproved)
    $realApproved = [];
    if (isset($dbApproved) && $dbApproved->count() > 0) {
        foreach ($dbApproved as $req) {
            if ($req->user) {
                $startFmt = \Carbon\Carbon::parse($req->start_date)->format('d/m/Y');
                $endFmt = \Carbon\Carbon::parse($req->end_date)->format('d/m/Y');
                $period = ($startFmt === $endFmt) ? $startFmt : ($startFmt . ' – ' . $endFmt);
                $type = $req->leaveType->name ?? 'Cuti';
                $realApproved[] = [
                    'name' => $req->user->name,
                    'subtitle' => $type . ' (' . ($req->total_days ?? 1) . ' hari) • ' . $period,
                    'is_real' => true,
                ];
            }
        }
    }

    // C. Real Pengajuan Cuti Pending (dari $dbPending)
    $realPending = [];
    if (isset($dbPending) && $dbPending->count() > 0) {
        foreach ($dbPending as $req) {
            if ($req->user) {
                $startFmt = \Carbon\Carbon::parse($req->start_date)->format('d/m/Y');
                $endFmt = \Carbon\Carbon::parse($req->end_date)->format('d/m/Y');
                $period = ($startFmt === $endFmt) ? $startFmt : ($startFmt . ' – ' . $endFmt);
                $type = $req->leaveType->name ?? 'Cuti';
                $realPending[] = [
                    'name' => $req->user->name,
                    'subtitle' => $type . ' (' . ($req->total_days ?? 1) . ' hari) • ' . $period,
                    'is_real' => true,
                ];
            }
        }
    }

    // D. Real Cuti Ditolak (dari $dbRejected)
    $realRejected = [];
    if (isset($dbRejected) && $dbRejected->count() > 0) {
        foreach ($dbRejected as $req) {
            if ($req->user) {
                $startFmt = \Carbon\Carbon::parse($req->start_date)->format('d/m/Y');
                $endFmt = \Carbon\Carbon::parse($req->end_date)->format('d/m/Y');
                $period = ($startFmt === $endFmt) ? $startFmt : ($startFmt . ' – ' . $endFmt);
                $type = $req->leaveType->name ?? 'Cuti';
                $realRejected[] = [
                    'name' => $req->user->name,
                    'subtitle' => $type . ' • ' . $period,
                    'is_real' => true,
                ];
            }
        }
    }

    // =========================================================================
    // 2. DATA DUMMY / DEMO (Bisa dipertahankan atau dikosongkan sewaktu-waktu)
    // =========================================================================
    // Jika dummy dihapus (cukup kosongkan array $demoEmployees dsb), data otomatis 100% murni dari database!
    $demoEmployees = [
        ['name' => 'Budi Santoso', 'subtitle' => 'Senior Frontend Developer • Technology & IT', 'is_real' => false],
        ['name' => 'Siti Rahmawati', 'subtitle' => 'Content Specialist • Digital Marketing', 'is_real' => false],
        ['name' => 'Dimas Prasetyo', 'subtitle' => 'UI/UX Designer • Product & Design', 'is_real' => false],
        ['name' => 'Ayu Pratiwi', 'subtitle' => 'Recruitment Officer • Human Resources', 'is_real' => false],
        ['name' => 'Putri Wulandari', 'subtitle' => 'Finance Staff • Finance & Accounting', 'is_real' => false],
        ['name' => 'Yanto Nugroho', 'subtitle' => 'Backend Engineer • Technology & IT', 'is_real' => false],
        ['name' => 'Yanti Kusuma', 'subtitle' => 'CS Lead • Customer Success', 'is_real' => false],
        ['name' => 'Putra Pratama', 'subtitle' => 'DevOps Specialist • Technology & IT', 'is_real' => false],
        ['name' => 'Dani Firmansyah', 'subtitle' => 'Account Executive • Sales & Business', 'is_real' => false],
        ['name' => 'Titi Handayani', 'subtitle' => 'Product Manager • Product & Design', 'is_real' => false],
        ['name' => 'Rian Hidayat', 'subtitle' => 'Mobile Developer • Technology & IT', 'is_real' => false],
        ['name' => 'Maya Anggraini', 'subtitle' => 'SEO & SEM Specialist • Digital Marketing', 'is_real' => false],
    ];

    $demoApproved = [
        ['name' => 'Budi Santoso', 'subtitle' => 'Cuti Tahunan (3 hari) • 11/10/2026 – 13/10/2026', 'is_real' => false],
        ['name' => 'Dimas Prasetyo', 'subtitle' => 'Cuti Sakit (2 hari) • 17/10/2026 – 18/10/2026', 'is_real' => false],
        ['name' => 'Titi Handayani', 'subtitle' => 'Cuti Tahunan (3 hari) • 11/10/2026 – 13/10/2026', 'is_real' => false],
        ['name' => 'Putri Wulandari', 'subtitle' => 'Cuti Tahunan (3 hari) • 11/10/2026 – 13/10/2026', 'is_real' => false],
        ['name' => 'Ayu Pratiwi', 'subtitle' => 'Cuti Sakit (3 hari) • 05/10/2026 – 07/10/2026', 'is_real' => false],
        ['name' => 'Yanto Nugroho', 'subtitle' => 'Cuti Tahunan (3 hari) • 02/10/2026 – 04/10/2026', 'is_real' => false],
        ['name' => 'Yanti Kusuma', 'subtitle' => 'Cuti Menikah (3 hari) • 08/10/2026 – 10/10/2026', 'is_real' => false],
        ['name' => 'Putra Pratama', 'subtitle' => 'Cuti Tahunan (2 hari) • 14/10/2026 – 15/10/2026', 'is_real' => false],
        ['name' => 'Dani Firmansyah', 'subtitle' => 'Cuti Tahunan (2 hari) • 18/10/2026 – 19/10/2026', 'is_real' => false],
    ];

    $demoPending = [
        ['name' => 'Siti Rahmawati', 'subtitle' => 'Cuti Tahunan (2 hari) • 11/10/2026 – 13/10/2026', 'is_real' => false],
        ['name' => 'Budi Santoso', 'subtitle' => 'Cuti Tahunan (2 hari) • 25/10/2026 – 26/10/2026', 'is_real' => false],
        ['name' => 'Maya Anggraini', 'subtitle' => 'Cuti Tahunan (3 hari) • 22/10/2026 – 24/10/2026', 'is_real' => false],
        ['name' => 'Rian Hidayat', 'subtitle' => 'Cuti Penting (2 hari) • 23/10/2026 – 24/10/2026', 'is_real' => false],
        ['name' => 'Ayu Pratiwi', 'subtitle' => 'Cuti Tahunan (3 hari) • 28/10/2026 – 30/10/2026', 'is_real' => false],
        ['name' => 'Putri Wulandari', 'subtitle' => 'Cuti Tahunan (2 hari) • 27/10/2026 – 28/10/2026', 'is_real' => false],
        ['name' => 'Yanto Nugroho', 'subtitle' => 'Cuti Sakit (2 hari) • 21/10/2026 – 22/10/2026', 'is_real' => false],
        ['name' => 'Yanti Kusuma', 'subtitle' => 'Cuti Tahunan (3 hari) • 29/10/2026 – 31/10/2026', 'is_real' => false],
        ['name' => 'Putra Pratama', 'subtitle' => 'Cuti Tahunan (2 hari) • 24/10/2026 – 25/10/2026', 'is_real' => false],
        ['name' => 'Dani Firmansyah', 'subtitle' => 'Cuti Tahunan (2 hari) • 26/10/2026 – 27/10/2026', 'is_real' => false],
        ['name' => 'Dimas Prasetyo', 'subtitle' => 'Cuti Tahunan (2 hari) • 30/10/2026 – 31/10/2026', 'is_real' => false],
    ];

    $demoRejected = [
        ['name' => 'Dimas Prasetyo', 'subtitle' => 'Cuti Tahunan • 01/10/2026 – 03/10/2026', 'is_real' => false],
        ['name' => 'Dani Firmansyah', 'subtitle' => 'Cuti Tahunan • 05/10/2026 – 08/10/2026', 'is_real' => false],
    ];

    // =========================================================================
    // 3. PENGGABUNGAN DATA (DATA REAL DATABASE PRIORITAS PERTAMA / DI ATAS)
    // =========================================================================
    $mergeCardData = function ($realList, $demoList) {
        $result = $realList;
        $realNamesLower = array_map(function($item) {
            return strtolower(trim($item['name']));
        }, $realList);

        foreach ($demoList as $demo) {
            // Jika nama demo belum ada di daftar nama real, tambahkan ke fallback
            if (!in_array(strtolower(trim($demo['name'])), $realNamesLower)) {
                $result[] = $demo;
            }
        }
        return $result;
    };

    $finalEmployees = $mergeCardData($realEmployees, $demoEmployees);
    $finalApproved  = $mergeCardData($realApproved, $demoApproved);
    $finalPending   = $mergeCardData($realPending, $demoPending);
    $finalRejected  = $mergeCardData($realRejected, $demoRejected);

    $countEmployees = count($finalEmployees);
    $countApproved  = count($finalApproved);
    $countPending   = count($finalPending);
    $countRejected  = count($finalRejected);
@endphp

<!-- 4 KARTU STATISTIK DASHBOARD ADMIN (IN-PAGE INTERAKTIF) -->
<div class="space-y-4">

    <!-- BARIS 4 KARTU STATISTIK -->
    <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">

        <!-- Card 1: Total Pegawai (Soft Blue) -->
        <div id="statCard_total_pegawai" 
             onclick="toggleCardNames('total_pegawai')" 
             role="button"
             tabindex="0"
             title="Klik untuk melihat daftar nama seluruh pegawai aktif"
             class="bg-[#EBF2FE] rounded-2xl p-5 border border-blue-100/60 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex items-center justify-between gap-4 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#5B8DEF] flex items-center justify-center text-white shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#5D5D5D] block">Total Pegawai</span>
                    <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">{{ $countEmployees }}</span>
                    <span class="text-[11px] text-[#8C8C8C] block mt-0.5">Pegawai aktif</span>
                </div>
            </div>
            <div id="arrow_total_pegawai" class="text-blue-400 group-hover:text-blue-600 transition-transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </div>

        <!-- Card 2: Cuti Disetujui (Soft Green) -->
        <div id="statCard_disetujui" 
             onclick="toggleCardNames('disetujui')" 
             role="button"
             tabindex="0"
             title="Klik untuk melihat daftar nama yang cutinya disetujui"
             class="bg-[#E7F7F0] rounded-2xl p-5 border border-emerald-100/60 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex items-center justify-between gap-4 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#48BB88] flex items-center justify-center text-white shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75 11.25 15 15 9.75M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#5D5D5D] block">Cuti Disetujui</span>
                    <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">{{ $countApproved }}</span>
                    <span class="text-[11px] text-[#8C8C8C] block mt-0.5">Bulan ini</span>
                </div>
            </div>
            <div id="arrow_disetujui" class="text-emerald-400 group-hover:text-emerald-600 transition-transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </div>

        <!-- Card 3: Pengajuan Cuti (Soft Amber/Yellow) -->
        <div id="statCard_pending" 
             onclick="toggleCardNames('pending')" 
             role="button"
             tabindex="0"
             title="Klik untuk melihat daftar nama yang sedang mengajukan cuti"
             class="bg-[#FBF4E6] rounded-2xl p-5 border border-amber-100/60 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex items-center justify-between gap-4 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#DDA022] flex items-center justify-center text-white shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#5D5D5D] block">Pengajuan Cuti</span>
                    <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">{{ $countPending }}</span>
                    <span class="text-[11px] text-[#8C8C8C] block mt-0.5">Bulan ini</span>
                </div>
            </div>
            <div id="arrow_pending" class="text-amber-400 group-hover:text-amber-600 transition-transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </div>

        <!-- Card 4: Cuti Ditolak (Soft Red) -->
        <div id="statCard_ditolak" 
             onclick="toggleCardNames('ditolak')" 
             role="button"
             tabindex="0"
             title="Klik untuk melihat daftar nama yang cutinya ditolak"
             class="bg-[#FBE8EC] rounded-2xl p-5 border border-red-100/60 shadow-[0_2px_10px_rgba(0,0,0,0.02)] flex items-center justify-between gap-4 cursor-pointer hover:shadow-md hover:-translate-y-0.5 transition-all duration-200 group">
            <div class="flex items-center gap-4">
                <div class="w-14 h-14 rounded-2xl bg-[#C12132] flex items-center justify-center text-white shadow-sm shrink-0 group-hover:scale-105 transition-transform">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-7 h-7" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m9.75 9.75 4.5 4.5m0-4.5-4.5 4.5M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <span class="text-xs font-medium text-[#5D5D5D] block">Cuti Ditolak</span>
                    <span class="text-2xl font-bold text-[#2D2D2D] leading-tight block mt-0.5">{{ $countRejected }}</span>
                    <span class="text-[11px] text-[#8C8C8C] block mt-0.5">Bulan ini</span>
                </div>
            </div>
            <div id="arrow_ditolak" class="text-red-400 group-hover:text-red-600 transition-transform duration-200">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                </svg>
            </div>
        </div>

    </div>

    <!-- PANEL DAFTAR NAMA INLINE (MUNCUL LANGSUNG DI BAWAH KARTU PADA HALAMAN INI) -->
    <div id="inlineNamesPanel" 
         class="hidden bg-white rounded-2xl p-6 border shadow-[0_4px_20px_rgba(0,0,0,0.03)] transition-all duration-300">
        
        <!-- Header Panel -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <span id="panelCategoryDot" class="w-3 h-3 rounded-full bg-[#C12132]"></span>
                <h3 id="panelCategoryTitle" class="text-sm font-bold text-[#2D2D2D]">Daftar Nama Pegawai</h3>
                <span id="panelCategoryCount" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0 Nama</span>
            </div>
            
            <div class="flex items-center gap-2">
                @if (function_exists('view') && view()->exists('admin.dashboard.card-detail-modal'))
                    <button type="button" 
                            onclick="if (typeof openCardModal === 'function') openCardModal(activeCardKey)" 
                            class="hidden sm:flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-semibold text-[#C12132] hover:bg-red-50 hover:text-[#9B0010] transition-colors cursor-pointer"
                            title="Buka rincian lengkap">
                        <span>Lihat Rincian Lengkap</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
                        </svg>
                    </button>
                @endif

                <button type="button" 
                        onclick="closeInlineNames()" 
                        class="flex items-center gap-1.5 px-3 py-1.5 rounded-xl text-xs font-medium text-gray-500 hover:text-gray-800 hover:bg-gray-100 transition-colors cursor-pointer"
                        title="Tutup list">
                    <span>Tutup</span>
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>
        </div>

        <!-- Grid List Nama Pegawai -->
        <div id="panelNamesList" class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 pt-4">
            <!-- List nama di-render otomatis oleh JavaScript -->
        </div>

    </div>

</div>

<script>
    // DATA LIST NAMA DINAMIS SESUAI DATABASE (DENGAN DEMO DATA PRIORITAS KEDUA)
    window.CARD_NAMES_DATA = {
        total_pegawai: {
            title: 'Daftar Seluruh Pegawai Aktif',
            badgeBg: 'bg-blue-100 text-blue-700',
            dotColor: 'bg-[#5B8DEF]',
            cardBorder: 'border-blue-400 ring-2 ring-blue-100',
            names: @json($finalEmployees)
        },
        disetujui: {
            title: 'Daftar Nama Pegawai yang Cuti Disetujui',
            badgeBg: 'bg-emerald-100 text-emerald-700',
            dotColor: 'bg-[#48BB88]',
            cardBorder: 'border-emerald-400 ring-2 ring-emerald-100',
            names: @json($finalApproved)
        },
        pending: {
            title: 'Daftar Nama Pegawai yang Mengajukan Cuti',
            badgeBg: 'bg-amber-100 text-amber-700',
            dotColor: 'bg-[#DDA022]',
            cardBorder: 'border-amber-400 ring-2 ring-amber-100',
            names: @json($finalPending)
        },
        ditolak: {
            title: 'Daftar Nama Pegawai yang Cuti Ditolak',
            badgeBg: 'bg-rose-100 text-rose-700',
            dotColor: 'bg-[#C12132]',
            cardBorder: 'border-rose-400 ring-2 ring-rose-100',
            names: @json($finalRejected)
        }
    };

    let activeCardKey = null;

    /**
     * Buka / Tutup panel daftar nama langsung di bawah kartu
     */
    function toggleCardNames(type) {
        const panel = document.getElementById('inlineNamesPanel');
        
        // Jika kartu yang sama diklik lagi saat terbuka, tutup panelnya
        if (activeCardKey === type && !panel.classList.contains('hidden')) {
            closeInlineNames();
            return;
        }

        activeCardKey = type;
        const config = window.CARD_NAMES_DATA[type];
        if (!config) return;

        // Reset highlight kartu-kartu lain
        ['total_pegawai', 'disetujui', 'pending', 'ditolak'].forEach(k => {
            const el = document.getElementById(`statCard_${k}`);
            const arrow = document.getElementById(`arrow_${k}`);
            if (el) {
                el.classList.remove('border-blue-400', 'border-emerald-400', 'border-amber-400', 'border-rose-400', 'ring-2', 'ring-blue-100', 'ring-emerald-100', 'ring-amber-100', 'ring-rose-100', 'bg-white');
            }
            if (arrow) {
                arrow.classList.remove('rotate-90');
            }
        });

        // Highlight kartu yang aktif
        const activeCard = document.getElementById(`statCard_${type}`);
        const activeArrow = document.getElementById(`arrow_${type}`);
        if (activeCard) {
            config.cardBorder.split(' ').forEach(cls => activeCard.classList.add(cls));
            activeCard.classList.add('bg-white');
        }
        if (activeArrow) {
            activeArrow.classList.add('rotate-90');
        }

        // Update teks header & dot warna
        document.getElementById('panelCategoryTitle').innerText = config.title;
        document.getElementById('panelCategoryCount').innerText = `${config.names.length} Pegawai`;
        document.getElementById('panelCategoryCount').className = `px-2.5 py-0.5 rounded-full text-xs font-bold ${config.badgeBg}`;
        document.getElementById('panelCategoryDot').className = `w-3 h-3 rounded-full ${config.dotColor}`;

        // Render list nama-namanya
        const listContainer = document.getElementById('panelNamesList');
        if (!config.names || config.names.length === 0) {
            listContainer.innerHTML = `
                <div class="col-span-full py-8 text-center text-xs text-gray-400">
                    Belum ada data pada kategori ini.
                </div>
            `;
        } else {
            let html = '';
            config.names.forEach((item, index) => {
                const nameStr = (typeof item === 'object' && item.name) ? item.name : String(item);
                const subStr = (typeof item === 'object' && item.subtitle) ? item.subtitle : '';
                const isReal = typeof item === 'object' && item.is_real;

                html += `
                    <div class="flex items-center justify-between gap-3 p-3.5 rounded-xl bg-gray-50/80 border border-gray-100 hover:bg-gray-100/80 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <span class="w-7 h-7 rounded-lg ${config.dotColor} text-white font-bold text-xs flex items-center justify-center shrink-0 shadow-2xs">
                                ${index + 1}
                            </span>
                            <div class="min-w-0">
                                <span class="font-semibold text-xs text-[#2D2D2D] truncate block" title="${nameStr}">${nameStr}</span>
                                ${subStr ? `<span class="text-[10px] text-[#8C8C8C] truncate block mt-0.5" title="${subStr}">${subStr}</span>` : ''}
                            </div>
                        </div>
                        ${isReal ? `<span class="px-2 py-0.5 rounded-md text-[9px] font-bold bg-emerald-50 text-emerald-600 border border-emerald-200 shrink-0">Aktif</span>` : ''}
                    </div>
                `;
            });
            listContainer.innerHTML = html;
        }

        // Tampilkan panel
        panel.classList.remove('hidden');

        // Scroll halus sedikit jika perlu
        panel.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    }

    /**
     * Tutup panel daftar nama
     */
    function closeInlineNames() {
        const panel = document.getElementById('inlineNamesPanel');
        if (panel) panel.classList.add('hidden');

        // Reset highlight semua kartu
        ['total_pegawai', 'disetujui', 'pending', 'ditolak'].forEach(k => {
            const el = document.getElementById(`statCard_${k}`);
            const arrow = document.getElementById(`arrow_${k}`);
            if (el) {
                el.classList.remove('border-blue-400', 'border-emerald-400', 'border-amber-400', 'border-rose-400', 'ring-2', 'ring-blue-100', 'ring-emerald-100', 'ring-amber-100', 'ring-rose-100', 'bg-white');
            }
            if (arrow) {
                arrow.classList.remove('rotate-90');
            }
        });

        activeCardKey = null;
    }
</script>
