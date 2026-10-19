<!-- TOMBOL BUKA KEMBALI NOTIFIKASI (JIKA PERNAH DITUTUP) -->
<button type="button" id="reopenNotificationBtn" onclick="openLeaveNotification()"
        class="hidden items-center gap-2.5 px-5 py-3 rounded-2xl bg-white border border-gray-100 shadow-[0_4px_20px_rgba(0,0,0,0.05)] hover:shadow-md hover:border-red-100 transition-all text-xs font-semibold text-[#2D2D2D] cursor-pointer group">
    <div class="w-7 h-7 rounded-lg bg-[#FFF9EB] flex items-center justify-center text-[#D97706] group-hover:scale-110 transition-transform">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-[#EAB308]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
        </svg>
    </div>
    <span class="font-bold text-[#C12132]">Pengajuan Cuti</span>
    <span class="w-2 h-2 rounded-full bg-[#EAB308]"></span>
</button>

<!-- CARD NOTIFIKASI PENGAJUAN CUTI (SESUAI PERSIS DESAIN FIGMA) -->
<div id="leaveRequestPopup" 
     class="w-full sm:w-[470px] bg-white rounded-3xl p-5 sm:p-6 shadow-[0_12px_40px_rgba(0,0,0,0.08)] border border-gray-100 transition-all duration-300 relative text-[#2D2D2D]">
    
    <!-- 1. Header Notifikasi -->
    <div class="flex items-start justify-between gap-3">
        <div class="flex items-center gap-3">
            <div class="w-11 h-11 rounded-2xl bg-[#FFF9EB] flex items-center justify-center text-[#D97706] shrink-0">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-[#EAB308]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                </svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-[#2D2D2D] leading-tight">Pengajuan cuti masuk</h3>
                <p class="text-[11px] text-[#8C8C8C] mt-0.5">Menunggu keputusan admin</p>
            </div>
        </div>

        <div class="flex items-center gap-2 shrink-0">
            <span class="px-3.5 py-1 rounded-full bg-[#FEF9E7] text-[#D97706] text-xs font-semibold whitespace-nowrap">
                Menunggu
            </span>
            <button type="button" onclick="closeLeaveNotification()" class="p-1 text-gray-300 hover:text-gray-500 rounded-lg transition-colors cursor-pointer" title="Tutup Notifikasi">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>
        </div>
    </div>

    <!-- 2. Deskripsi Permohonan -->
    <div class="text-xs text-[#4A4A4A] leading-relaxed mt-3.5 space-y-0.5">
        <p>Siti mengajukan cuti tahunan untuk tanggal 11/10/2026–13/10/2026.</p>
        <p>Total cuti terpakai: 4 hari dari 12 hari.</p>
    </div>

    <!-- 3. Timestamp & Link Toggle Detail -->
    <div class="text-xs text-[#8C8C8C] flex items-center gap-1.5 mt-2.5">
        <span>Hari ini, 09:41</span>
        <span>•</span>
        <button type="button" onclick="togglePopupDetails()" id="btnDetailToggle" class="text-[#C12132] font-semibold underline underline-offset-2 hover:text-[#9B0010] cursor-pointer transition-colors">
            Lihat detail pengajuan
        </button>
    </div>

    <!-- 4. Bagian Rincian Tambahan (Muncul saat tombol 'Lihat detail pengajuan' diklik) -->
    <div id="popupDetailsExpanded" class="hidden mt-4 pt-4 border-t border-gray-100 space-y-3 text-xs">
        
        <!-- Jenis Cuti -->
        <div class="grid grid-cols-[130px_1fr] items-center gap-2">
            <span class="text-[#5D5D5D]">Jenis Cuti</span>
            <div>
                <span class="inline-block px-3 py-0.5 rounded-lg border border-[#34D399] bg-[#ECFDF5]/50 text-[#10B981] font-semibold text-xs whitespace-nowrap">
                    Cuti Tahunan
                </span>
            </div>
        </div>

        <!-- Periode Cuti -->
        <div class="grid grid-cols-[130px_1fr] items-center gap-2">
            <span class="text-[#5D5D5D]">Periode Cuti</span>
            <span class="font-bold text-[#2D2D2D] whitespace-nowrap">12 Oktober 2026 – 14 Oktober 2026</span>
        </div>

        <!-- Durasi Cuti -->
        <div class="grid grid-cols-[130px_1fr] items-center gap-2">
            <span class="text-[#5D5D5D]">Durasi Cuti</span>
            <span class="font-bold text-[#2D2D2D]">2 Hari</span>
        </div>

        <!-- Keterangan -->
        <div class="grid grid-cols-[130px_1fr] items-center gap-2">
            <span class="text-[#5D5D5D]">Keterangan</span>
            <span class="font-bold text-[#2D2D2D]">Urusan keluarga</span>
        </div>

        <!-- Dokumen Pendukung -->
        <div class="grid grid-cols-[130px_1fr] items-center gap-2 pt-0.5">
            <span class="text-[#5D5D5D]">Dokumen Pendukung</span>
            <div class="p-2.5 rounded-xl border border-gray-200 bg-white flex items-center justify-between gap-3 hover:border-red-200 transition-colors shadow-xs">
                <div class="flex items-center gap-2.5 min-w-0">
                    <div class="w-8 h-8 rounded-lg bg-red-50 flex items-center justify-center shrink-0">
                        <svg class="w-5 h-5 text-[#C12132]" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <span class="font-semibold text-[#2D2D2D] block truncate text-xs">surat__pengajuan__cuti.pdf</span>
                        <span class="text-[10px] text-[#8C8C8C] block mt-0.5">245 KB</span>
                    </div>
                </div>
                <button type="button" class="p-1 text-gray-400 hover:text-[#C12132] transition-colors shrink-0 cursor-pointer" title="Unduh">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                    </svg>
                </button>
            </div>
        </div>

    </div>

    <!-- 5. Tiga Tombol Aksi: Setujui, Tunda, Tolak -->
    <div class="grid grid-cols-3 gap-3 pt-4 mt-1">
        <!-- Setujui (Hijau) -> Langsung masuk ke Riwayat Pengajuan Cuti Siti dengan status Disetujui -->
        <a href="{{ url('/admin/employee/siti?approved=1') }}"
           class="w-full py-2.5 rounded-xl bg-[#E6F8F0] hover:bg-[#d1f2e4] text-[#10B981] font-bold text-xs transition-colors shadow-xs text-center cursor-pointer inline-flex items-center justify-center">
            Setujui
        </a>

        <!-- Tunda (Kuning) -->
        <button type="button" onclick="handleLeaveAction('Tunda')"
                class="w-full py-2.5 rounded-xl bg-[#FEF9E7] hover:bg-[#fdf0cc] text-[#D97706] font-bold text-xs transition-colors shadow-xs text-center cursor-pointer">
            Tunda
        </button>

        <!-- Tolak (Merah) -->
        <button type="button" onclick="handleLeaveAction('Tolak')"
                class="w-full py-2.5 rounded-xl bg-[#FDECEC] hover:bg-[#fcd7d7] text-[#DC2626] font-bold text-xs transition-colors shadow-xs text-center cursor-pointer">
            Tolak
        </button>
    </div>

</div>

<!-- SCRIPT INTERAKSI NOTIFIKASI -->
<script>
    function togglePopupDetails() {
        const details = document.getElementById('popupDetailsExpanded');
        const btn = document.getElementById('btnDetailToggle');
        
        if (details.classList.contains('hidden')) {
            details.classList.remove('hidden');
            btn.innerText = 'Sembunyikan detail';
        } else {
            details.classList.add('hidden');
            btn.innerText = 'Lihat detail pengajuan';
        }
    }

    function closeLeaveNotification() {
        const card = document.getElementById('leaveRequestPopup');
        const reopenBtn = document.getElementById('reopenNotificationBtn');
        if (card) card.classList.add('hidden');
        if (reopenBtn) {
            reopenBtn.classList.remove('hidden');
            reopenBtn.classList.add('flex');
        }
    }

    function openLeaveNotification() {
        const card = document.getElementById('leaveRequestPopup');
        const reopenBtn = document.getElementById('reopenNotificationBtn');
        if (reopenBtn) {
            reopenBtn.classList.add('hidden');
            reopenBtn.classList.remove('flex');
        }
        if (card) card.classList.remove('hidden');
    }

    function handleLeaveAction(action) {
        alert('Pengajuan cuti berhasil di-' + action + '!');
        closeLeaveNotification();
    }
</script>
