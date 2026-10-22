<!-- MODAL DETAIL DAFTAR NAMA SESUAI KARTU STATISTIK ADMIN -->
<div id="cardDetailModal" 
     class="hidden fixed inset-0 z-[99999] items-center justify-center bg-black/50 backdrop-blur-sm p-4 sm:p-6 transition-all duration-300"
     role="dialog" 
     aria-modal="true" 
     aria-labelledby="cardModalTitle">

    <div class="bg-white rounded-3xl w-full max-w-4xl max-h-[90vh] flex flex-col shadow-2xl border border-gray-100 overflow-hidden transform transition-all duration-300 scale-95 opacity-0"
         id="cardModalContent">

        <!-- HEADER MODAL -->
        <div class="px-6 py-5 border-b border-gray-100 flex items-center justify-between gap-4 bg-white sticky top-0 z-10">
            <div class="flex items-center gap-3.5">
                <div id="cardModalIconWrap" class="w-12 h-12 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-sm transition-colors">
                    <svg id="cardModalIcon" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                    </svg>
                </div>
                <div>
                    <div class="flex items-center gap-2.5">
                        <h2 id="cardModalTitle" class="text-lg font-bold text-[#2D2D2D] leading-tight">Detail Data</h2>
                        <span id="cardModalCountBadge" class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-gray-100 text-gray-700">0</span>
                    </div>
                    <p id="cardModalSubtitle" class="text-xs text-[#8C8C8C] mt-0.5">Daftar nama pegawai yang sesuai dengan kriteria kartu.</p>
                </div>
            </div>

            <button type="button" 
                    onclick="closeCardModal()" 
                    class="w-9 h-9 rounded-xl flex items-center justify-center text-gray-400 hover:text-[#C12132] hover:bg-red-50 transition-colors cursor-pointer"
                    title="Tutup Modal (Esc)">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- SEARCH BAR & TAB SWITCHER -->
        <div class="px-6 py-3.5 bg-gray-50/70 border-b border-gray-100 flex flex-col sm:flex-row items-stretch sm:items-center justify-between gap-3">
            <!-- TAB PILIHAN CEPAT -->
            <div class="flex items-center gap-1.5 overflow-x-auto pb-1 sm:pb-0">
                <button type="button" onclick="switchCardTab('total_pegawai')" id="tabBtn_total_pegawai"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all cursor-pointer">
                    Total Pegawai
                </button>
                <button type="button" onclick="switchCardTab('disetujui')" id="tabBtn_disetujui"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all cursor-pointer">
                    Cuti Disetujui
                </button>
                <button type="button" onclick="switchCardTab('pending')" id="tabBtn_pending"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all cursor-pointer">
                    Pengajuan Cuti
                </button>
                <button type="button" onclick="switchCardTab('ditolak')" id="tabBtn_ditolak"
                        class="px-3.5 py-1.5 rounded-xl text-xs font-semibold whitespace-nowrap transition-all cursor-pointer">
                    Cuti Ditolak
                </button>
            </div>

            <!-- SEARCH INPUT -->
            <div class="relative w-full sm:w-64">
                <input type="text" 
                       id="cardModalSearchInput" 
                       oninput="searchCardModal(this.value)"
                       placeholder="Cari nama atau NIP..." 
                       class="w-full bg-white text-xs text-[#2D2D2D] pl-8 pr-4 py-2 rounded-xl border border-gray-200 focus:outline-none focus:ring-1 focus:ring-[#C12132] focus:border-[#C12132] placeholder:text-gray-400">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 absolute left-2.5 top-2.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                </svg>
            </div>
        </div>

        <!-- ISI KONTEN DAFTAR PEGAWAI / CUTI -->
        <div class="overflow-y-auto p-6 flex-1 divide-y divide-gray-100" id="cardModalListContainer">
            <!-- Item akan digenerate otomatis oleh JavaScript -->
        </div>

        <!-- FOOTER MODAL -->
        <div class="px-6 py-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs text-[#8C8C8C]">
            <span id="cardModalFooterCount">Menampilkan 0 data</span>
            <button type="button" onclick="closeCardModal()" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-[#2D2D2D] font-medium rounded-xl transition-colors cursor-pointer">
                Tutup
            </button>
        </div>

    </div>
</div>

<script>
    // DATA DARI DATABASE LARAVEL DENGAN FALLBACK DEMO FIGMA LENGKAP
    @php
        // 1. Data Pegawai Aktif
        $employeeList = [];
        if (isset($dbEmployees) && $dbEmployees->count() > 0) {
            foreach ($dbEmployees as $emp) {
                $employeeList[] = [
                    'name' => $emp->name,
                    'nip' => $emp->nip ?? 'MTR-' . str_pad($emp->id, 3, '0', STR_PAD_LEFT),
                    'department' => $emp->department ?? 'General Operations',
                    'position' => $emp->position ?? 'Mitra Kerja',
                    'email' => $emp->email,
                    'phone' => $emp->phone ?? '-',
                    'date' => $emp->join_date ? \Carbon\Carbon::parse($emp->join_date)->translatedFormat('d M Y') : 'Aktif',
                    'tag' => 'Pegawai Aktif',
                    'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200',
                ];
            }
        }
        
        // Lengkapi agar genap 12 sesuai desain Figma
        $demoEmployees = [
            ['name' => 'Budi Santoso', 'nip' => 'MTR-2024-001', 'department' => 'Technology & IT', 'position' => 'Senior Frontend Developer', 'email' => 'budi@workleave.test', 'phone' => '081298765432', 'date' => '15 Jan 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Siti Rahmawati', 'nip' => 'MTR-2024-002', 'department' => 'Digital Marketing', 'position' => 'Content Specialist', 'email' => 'siti@workleave.test', 'phone' => '081345678901', 'date' => '01 Mar 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Dimas Prasetyo', 'nip' => 'MTR-2024-003', 'department' => 'Product & Design', 'position' => 'UI/UX Designer', 'email' => 'dimas@workleave.test', 'phone' => '081456789012', 'date' => '10 Jun 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Ayu Pratiwi', 'nip' => 'MTR-2024-004', 'department' => 'Human Resources', 'position' => 'Recruitment Officer', 'email' => 'ayu@workleave.test', 'phone' => '081567890123', 'date' => '12 Jan 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Putri Wulandari', 'nip' => 'MTR-2024-005', 'department' => 'Finance & Accounting', 'position' => 'Finance Staff', 'email' => 'putri@workleave.test', 'phone' => '081678901234', 'date' => '20 Feb 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Yanto Nugroho', 'nip' => 'MTR-2024-006', 'department' => 'Technology & IT', 'position' => 'Backend Engineer', 'email' => 'yanto@workleave.test', 'phone' => '081789012345', 'date' => '05 Apr 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Yanti Kusuma', 'nip' => 'MTR-2024-007', 'department' => 'Customer Success', 'position' => 'CS Lead', 'email' => 'yanti@workleave.test', 'phone' => '081890123456', 'date' => '18 Mei 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Putra Pratama', 'nip' => 'MTR-2024-008', 'department' => 'Technology & IT', 'position' => 'DevOps Specialist', 'email' => 'putra@workleave.test', 'phone' => '081901234567', 'date' => '01 Jul 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Dani Firmansyah', 'nip' => 'MTR-2024-009', 'department' => 'Sales & Business', 'position' => 'Account Executive', 'email' => 'dani@workleave.test', 'phone' => '082112345678', 'date' => '15 Agu 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Titi Handayani', 'nip' => 'MTR-2024-010', 'department' => 'Product & Design', 'position' => 'Product Manager', 'email' => 'titi@workleave.test', 'phone' => '082223456789', 'date' => '01 Sep 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Rian Hidayat', 'nip' => 'MTR-2024-011', 'department' => 'Technology & IT', 'position' => 'Mobile Developer', 'email' => 'rian@workleave.test', 'phone' => '082334567890', 'date' => '10 Sep 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
            ['name' => 'Maya Anggraini', 'nip' => 'MTR-2024-012', 'department' => 'Digital Marketing', 'position' => 'SEO & SEM Specialist', 'email' => 'maya@workleave.test', 'phone' => '082445678901', 'date' => '25 Sep 2024', 'tag' => 'Pegawai Aktif', 'tag_color' => 'bg-blue-50 text-blue-700 border-blue-200'],
        ];

        // Gabungkan tanpa duplikasi email
        $existingEmails = array_column($employeeList, 'email');
        foreach ($demoEmployees as $d) {
            if (!in_array($d['email'], $existingEmails)) {
                $employeeList[] = $d;
            }
        }

        // 2. Data Cuti Disetujui (9)
        $approvedList = [
            ['name' => 'Budi Santoso', 'nip' => 'MTR-2024-001', 'department' => 'Technology & IT', 'type' => 'Cuti Tahunan', 'period' => '11/10/2026 – 13/10/2026', 'duration' => '3 Hari', 'desc' => 'Keperluan keluarga di luar kota', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Dimas Prasetyo', 'nip' => 'MTR-2024-003', 'department' => 'Product & Design', 'type' => 'Cuti Sakit', 'period' => '17/10/2026 – 18/10/2026', 'duration' => '2 Hari', 'desc' => 'Demam dan flu berat, istirahat atas saran dokter', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Titi Handayani', 'nip' => 'MTR-2024-010', 'department' => 'Product & Design', 'type' => 'Cuti Tahunan', 'period' => '11/10/2026 – 13/10/2026', 'duration' => '3 Hari', 'desc' => 'Acara keluarga besar di kampung halaman', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Putri Wulandari', 'nip' => 'MTR-2024-005', 'department' => 'Finance & Accounting', 'type' => 'Cuti Tahunan', 'period' => '11/10/2026 – 13/10/2026', 'duration' => '3 Hari', 'desc' => 'Keperluan wisuda adik kandung', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Ayu Pratiwi', 'nip' => 'MTR-2024-004', 'department' => 'Human Resources', 'type' => 'Cuti Sakit', 'period' => '05/10/2026 – 07/10/2026', 'duration' => '3 Hari', 'desc' => 'Pemeriksaan kesehatan rawat jalan', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Yanto Nugroho', 'nip' => 'MTR-2024-006', 'department' => 'Technology & IT', 'type' => 'Cuti Tahunan', 'period' => '02/10/2026 – 04/10/2026', 'duration' => '3 Hari', 'desc' => 'Renovasi rumah tempat tinggal', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Yanti Kusuma', 'nip' => 'MTR-2024-007', 'department' => 'Customer Success', 'type' => 'Cuti Menikah', 'period' => '08/10/2026 – 10/10/2026', 'duration' => '3 Hari', 'desc' => 'Pernikahan kerabat inti', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Putra Pratama', 'nip' => 'MTR-2024-008', 'department' => 'Technology & IT', 'type' => 'Cuti Tahunan', 'period' => '14/10/2026 – 15/10/2026', 'duration' => '2 Hari', 'desc' => 'Urusan sertifikasi keahlian', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
            ['name' => 'Dani Firmansyah', 'nip' => 'MTR-2024-009', 'department' => 'Sales & Business', 'type' => 'Cuti Tahunan', 'period' => '18/10/2026 – 19/10/2026', 'duration' => '2 Hari', 'desc' => 'Keperluan perpanjangan SIM dan paspor', 'status' => 'Disetujui', 'status_color' => 'bg-emerald-50 text-emerald-700 border-emerald-200'],
        ];

        // 3. Data Pengajuan Cuti Pending (11)
        $pendingList = [
            ['name' => 'Siti Rahmawati', 'nip' => 'MTR-2024-002', 'department' => 'Digital Marketing', 'type' => 'Cuti Tahunan', 'period' => '11/10/2026 – 13/10/2026', 'duration' => '2 Hari', 'desc' => 'Perpanjangan dokumen kependudukan dan urusan administrasi keluarga', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Budi Santoso', 'nip' => 'MTR-2024-001', 'department' => 'Technology & IT', 'type' => 'Cuti Tahunan', 'period' => '25/10/2026 – 26/10/2026', 'duration' => '2 Hari', 'desc' => 'Menghadiri reuni keluarga besar', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Maya Anggraini', 'nip' => 'MTR-2024-012', 'department' => 'Digital Marketing', 'type' => 'Cuti Tahunan', 'period' => '22/10/2026 – 24/10/2026', 'duration' => '3 Hari', 'desc' => 'Keperluan pindah rumah baru', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Rian Hidayat', 'nip' => 'MTR-2024-011', 'department' => 'Technology & IT', 'type' => 'Cuti Penting', 'period' => '23/10/2026 – 24/10/2026', 'duration' => '2 Hari', 'desc' => 'Mendampingi keluarga rawat inap', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Ayu Pratiwi', 'nip' => 'MTR-2024-004', 'department' => 'Human Resources', 'type' => 'Cuti Tahunan', 'period' => '28/10/2026 – 30/10/2026', 'duration' => '3 Hari', 'desc' => 'Libur tahunan keluarga', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Putri Wulandari', 'nip' => 'MTR-2024-005', 'department' => 'Finance & Accounting', 'type' => 'Cuti Tahunan', 'period' => '27/10/2026 – 28/10/2026', 'duration' => '2 Hari', 'desc' => 'Urusan perbankan & administrasi pajak', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Yanto Nugroho', 'nip' => 'MTR-2024-006', 'department' => 'Technology & IT', 'type' => 'Cuti Sakit', 'period' => '21/10/2026 – 22/10/2026', 'duration' => '2 Hari', 'desc' => 'Istirahat pasca tindakan dokter gigi', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Yanti Kusuma', 'nip' => 'MTR-2024-007', 'department' => 'Customer Success', 'type' => 'Cuti Tahunan', 'period' => '29/10/2026 – 31/10/2026', 'duration' => '3 Hari', 'desc' => 'Urusan keluarga di Jawa Barat', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Putra Pratama', 'nip' => 'MTR-2024-008', 'department' => 'Technology & IT', 'type' => 'Cuti Tahunan', 'period' => '24/10/2026 – 25/10/2026', 'duration' => '2 Hari', 'desc' => 'Menghadiri pernikahan sahabat karib', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Dani Firmansyah', 'nip' => 'MTR-2024-009', 'department' => 'Sales & Business', 'type' => 'Cuti Tahunan', 'period' => '26/10/2026 – 27/10/2026', 'duration' => '2 Hari', 'desc' => 'Mengantar orang tua kontrol kesehatan', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
            ['name' => 'Dimas Prasetyo', 'nip' => 'MTR-2024-003', 'department' => 'Product & Design', 'type' => 'Cuti Tahunan', 'period' => '30/10/2026 – 31/10/2026', 'duration' => '2 Hari', 'desc' => 'Istirahat dan urusan perpanjangan masa sewa rumah', 'status' => 'Menunggu Keputusan', 'status_color' => 'bg-amber-50 text-amber-700 border-amber-200'],
        ];

        // 4. Data Cuti Ditolak (2)
        $rejectedList = [
            ['name' => 'Dimas Prasetyo', 'nip' => 'MTR-2024-003', 'department' => 'Product & Design', 'type' => 'Cuti Tahunan', 'period' => '01/10/2026 – 03/10/2026', 'duration' => '3 Hari', 'desc' => 'Liburan ke pantai bersama teman', 'reason' => 'Jadwal bertepatan dengan masa rilis sprint project MBKM.', 'status' => 'Ditolak', 'status_color' => 'bg-rose-50 text-rose-700 border-rose-200'],
            ['name' => 'Dani Firmansyah', 'nip' => 'MTR-2024-009', 'department' => 'Sales & Business', 'type' => 'Cuti Tahunan', 'period' => '05/10/2026 – 08/10/2026', 'duration' => '4 Hari', 'desc' => 'Cuti mendadak ke luar pulau', 'reason' => 'Target closing akhir kuartal dan tim sales sedang kekurangan personil on-site.', 'status' => 'Ditolak', 'status_color' => 'bg-rose-50 text-rose-700 border-rose-200'],
        ];
    @endphp

    // SIMPAN DATA KE WINDOW OBJECT
    window.CARD_MODAL_DATA = {
        total_pegawai: {
            title: 'Daftar Seluruh Pegawai Aktif',
            subtitle: 'Data seluruh pegawai dan mitra kerja yang saat ini berstatus aktif.',
            iconBg: 'bg-[#5B8DEF]',
            badgeCls: 'bg-blue-100 text-blue-700',
            data: @json($employeeList)
        },
        disetujui: {
            title: 'Daftar Cuti Pegawai yang Disetujui',
            subtitle: 'Pengajuan cuti yang telah diverifikasi dan disetujui oleh admin bulan ini.',
            iconBg: 'bg-[#48BB88]',
            badgeCls: 'bg-emerald-100 text-emerald-700',
            data: @json($approvedList)
        },
        pending: {
            title: 'Daftar Pengajuan Cuti (Menunggu Keputusan)',
            subtitle: 'Pengajuan cuti mitra kerja yang sedang antre dan menunggu persetujuan admin.',
            iconBg: 'bg-[#DDA022]',
            badgeCls: 'bg-amber-100 text-amber-700',
            data: @json($pendingList)
        },
        ditolak: {
            title: 'Daftar Pengajuan Cuti yang Ditolak',
            subtitle: 'Pengajuan cuti yang ditolak oleh admin beserta alasan penolakannya.',
            iconBg: 'bg-[#C12132]',
            badgeCls: 'bg-rose-100 text-rose-700',
            data: @json($rejectedList)
        }
    };

    let currentCardType = 'total_pegawai';
    let currentFilterText = '';

    /** Buka Modal berdasarkan jenis kartu */
    function openCardModal(type) {
        currentCardType = type || 'total_pegawai';
        currentFilterText = '';

        const searchInput = document.getElementById('cardModalSearchInput');
        if (searchInput) searchInput.value = '';

        updateCardModalUI();

        const modal = document.getElementById('cardDetailModal');
        const content = document.getElementById('cardModalContent');

        modal.classList.remove('hidden');
        modal.classList.add('flex');
        document.body.classList.add('overflow-hidden');

        requestAnimationFrame(() => {
            content.classList.remove('scale-95', 'opacity-0');
            content.classList.add('scale-100', 'opacity-100');
        });
    }

    /** Tutup Modal */
    function closeCardModal() {
        const modal = document.getElementById('cardDetailModal');
        const content = document.getElementById('cardModalContent');

        content.classList.remove('scale-100', 'opacity-100');
        content.classList.add('scale-95', 'opacity-0');

        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            document.body.classList.remove('overflow-hidden');
        }, 200);
    }

    /** Ganti Tab di dalam Modal */
    function switchCardTab(type) {
        currentCardType = type;
        updateCardModalUI();
    }

    /** Cari Data */
    function searchCardModal(query) {
        currentFilterText = query.toLowerCase().trim();
        renderCardItems();
    }

    /** Render Tampilan Modal */
    function updateCardModalUI() {
        const config = window.CARD_MODAL_DATA[currentCardType];
        if (!config) return;

        // Update Title & Subtitle
        document.getElementById('cardModalTitle').innerText = config.title;
        document.getElementById('cardModalSubtitle').innerText = config.subtitle;

        // Update Icon background
        const iconWrap = document.getElementById('cardModalIconWrap');
        iconWrap.className = `w-12 h-12 rounded-2xl flex items-center justify-center text-white shrink-0 shadow-sm transition-colors ${config.iconBg}`;

        // Update Count Badge
        const badge = document.getElementById('cardModalCountBadge');
        badge.innerText = config.data.length;
        badge.className = `px-2.5 py-0.5 rounded-full text-xs font-bold ${config.badgeCls}`;

        // Update Tab Buttons
        ['total_pegawai', 'disetujui', 'pending', 'ditolak'].forEach(t => {
            const btn = document.getElementById(`tabBtn_${t}`);
            if (btn) {
                if (t === currentCardType) {
                    btn.className = `px-3.5 py-1.5 rounded-xl text-xs font-bold shadow-xs transition-all cursor-pointer bg-[#C12132] text-white`;
                } else {
                    btn.className = `px-3.5 py-1.5 rounded-xl text-xs font-medium text-gray-600 hover:text-[#C12132] hover:bg-gray-100 transition-all cursor-pointer`;
                }
            }
        });

        renderCardItems();
    }

    /** Render Daftar Item */
    function renderCardItems() {
        const config = window.CARD_MODAL_DATA[currentCardType];
        const container = document.getElementById('cardModalListContainer');
        const footerCount = document.getElementById('cardModalFooterCount');

        let filtered = config.data;
        if (currentFilterText) {
            filtered = config.data.filter(item => {
                const name = (item.name || '').toLowerCase();
                const nip = (item.nip || '').toLowerCase();
                const dept = (item.department || '').toLowerCase();
                const desc = (item.desc || '').toLowerCase();
                return name.includes(currentFilterText) || nip.includes(currentFilterText) || dept.includes(currentFilterText) || desc.includes(currentFilterText);
            });
        }

        footerCount.innerText = `Menampilkan ${filtered.length} dari ${config.data.length} data`;

        if (filtered.length === 0) {
            container.innerHTML = `
                <div class="py-12 flex flex-col items-center justify-center text-center">
                    <div class="w-12 h-12 rounded-2xl bg-gray-100 flex items-center justify-center text-gray-400 mb-3">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z"/></svg>
                    </div>
                    <p class="text-sm font-semibold text-[#2D2D2D]">Tidak ada data ditemukan</p>
                    <p class="text-xs text-[#8C8C8C] mt-1">Coba kata kunci pencarian yang lain.</p>
                </div>
            `;
            return;
        }

        let html = '';
        filtered.forEach((item, index) => {
            // Inisial Nama untuk Avatar
            const initials = item.name.split(' ').map(n => n[0]).slice(0, 2).join('').toUpperCase();
            const colors = ['bg-blue-100 text-blue-700', 'bg-emerald-100 text-emerald-700', 'bg-amber-100 text-amber-700', 'bg-purple-100 text-purple-700', 'bg-rose-100 text-rose-700'];
            const avatarColor = colors[index % colors.length];

            html += `
                <div class="py-4 flex flex-col sm:flex-row sm:items-center justify-between gap-4 hover:bg-gray-50/70 rounded-2xl px-3 transition-colors">
                    <div class="flex items-start sm:items-center gap-3.5 min-w-0">
                        <div class="w-11 h-11 rounded-2xl ${avatarColor} font-bold text-xs flex items-center justify-center shrink-0 shadow-xs">
                            ${initials}
                        </div>
                        <div class="min-w-0">
                            <div class="flex items-center gap-2">
                                <h4 class="text-sm font-bold text-[#2D2D2D] truncate">${item.name}</h4>
                                <span class="text-[11px] text-gray-400 font-mono">(${item.nip})</span>
                            </div>
                            <p class="text-xs text-[#5D5D5D] mt-0.5 truncate">
                                <span>${item.position}</span>
                                <span class="mx-1.5">•</span>
                                <span class="text-gray-400">${item.department}</span>
                            </p>
                            ${item.desc ? `
                                <p class="text-[11px] text-[#8C8C8C] mt-1 bg-gray-50 px-2.5 py-1 rounded-lg border border-gray-100 line-clamp-1">
                                    <strong class="text-gray-600">Alasan:</strong> ${item.desc}
                                </p>
                            ` : ''}
                            ${item.reason ? `
                                <p class="text-[11px] text-rose-600 mt-1 bg-rose-50/60 px-2.5 py-1 rounded-lg border border-rose-100 line-clamp-1">
                                    <strong>Alasan Ditolak:</strong> ${item.reason}
                                </p>
                            ` : ''}
                        </div>
                    </div>

                    <div class="flex sm:flex-col items-center sm:items-end justify-between sm:justify-center gap-1 shrink-0 pt-2 sm:pt-0 border-t sm:border-0 border-gray-100">
                        ${item.type ? `
                            <span class="text-xs font-bold text-[#2D2D2D]">${item.type} <span class="text-xs font-normal text-gray-500">(${item.duration})</span></span>
                            <span class="text-[11px] text-[#8C8C8C]">${item.period}</span>
                        ` : `
                            <span class="text-xs font-bold text-[#2D2D2D]">${item.phone}</span>
                            <span class="text-[11px] text-[#8C8C8C]">${item.email}</span>
                        `}
                        
                        <div class="mt-1">
                            ${item.status ? `
                                <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold border ${item.status_color}">
                                    ${item.status}
                                </span>
                            ` : `
                                <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold border ${item.tag_color}">
                                    ${item.tag}
                                </span>
                            `}
                        </div>
                    </div>
                </div>
            `;
        });

        container.innerHTML = html;
    }

    // Event listener: Tutup jika klik backdrop di luar konten
    document.addEventListener('DOMContentLoaded', function () {
        const modal = document.getElementById('cardDetailModal');
        if (modal) {
            modal.addEventListener('click', function (e) {
                if (e.target === modal) closeCardModal();
            });
        }

        // Tutup jika tekan ESC
        document.addEventListener('keydown', function (e) {
            if (e.key === 'Escape') {
                const modal = document.getElementById('cardDetailModal');
                if (modal && !modal.classList.contains('hidden')) {
                    closeCardModal();
                }
            }
        });
    });
</script>
