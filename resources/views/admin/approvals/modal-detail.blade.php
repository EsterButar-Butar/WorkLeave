<!-- MODAL POPUP DETAIL & APPROVAL ACTION (LAYAR 3) -->
<div id="approvalModal" class="fixed inset-0 bg-black/40 backdrop-blur-xs z-50 hidden flex items-center justify-center p-4 transition-opacity duration-300">
    <div class="bg-white rounded-3xl p-7 max-w-lg w-full shadow-2xl border border-gray-100 relative animate-in fade-in zoom-in-95 duration-200">
        
        <!-- Header Modal -->
        <div class="flex items-center justify-between pb-4 border-b border-gray-100">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-2xl bg-amber-50 text-amber-500 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                    </svg>
                </div>
                <div>
                    <h3 class="text-base font-bold text-[#2D2D2D]">Pengajuan Cuti Masuk</h3>
                    <p class="text-xs text-[#5D5D5D] mt-0.5">Detail permohonan cuti pegawai</p>
                </div>
            </div>
            
            <button type="button" onclick="closeApprovalModal()" class="w-8 h-8 rounded-full bg-gray-50 hover:bg-gray-100 text-gray-400 hover:text-gray-700 flex items-center justify-center transition-colors">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Detail Pengajuan -->
        <div class="py-5 space-y-4">
            
            <!-- Box Ringkasan Pemohon -->
            <div class="p-4 rounded-2xl bg-[#FFFBFB] border border-red-50">
                <p class="text-xs text-[#5D5D5D] leading-relaxed">
                    <span id="modalEmployeeName" class="font-bold text-[#2D2D2D]">Siti Rahma</span> mengajukan 
                    <span id="modalLeaveType" class="font-bold text-[#C12132]">Cuti Tahunan</span> untuk rentang waktu 
                    <span id="modalDuration" class="font-semibold text-[#2D2D2D]">5 Hari (10/11/2024 - 15/11/2024)</span>.
                </p>
                <div class="mt-2 flex items-center gap-2">
                    <span class="text-[11px] text-[#8C8C8C]">Status saat ini:</span>
                    <span id="modalStatusBadge" class="px-2.5 py-0.5 rounded-full text-[10px] font-bold bg-[#FFFBEB] text-[#F59E0B]">
                        Menunggu Persetujuan
                    </span>
                </div>
            </div>

            <!-- List Rincian Informasi -->
            <div class="grid grid-cols-2 gap-3 text-xs">
                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="text-[#8C8C8C] block text-[11px]">Sisa Kuota Cuti</span>
                    <span class="font-bold text-[#2D2D2D] mt-0.5 block text-sm">8 Hari</span>
                </div>
                <div class="p-3 rounded-xl bg-gray-50 border border-gray-100">
                    <span class="text-[#8C8C8C] block text-[11px]">Tipe Permohonan</span>
                    <span class="font-bold text-[#2D2D2D] mt-0.5 block text-sm">Cuti Berbayar</span>
                </div>
            </div>

            <!-- Alasan / Keterangan -->
            <div class="text-xs">
                <label class="text-[#8C8C8C] font-semibold block mb-1">Alasan / Keterangan Pengajuan:</label>
                <div class="p-3.5 rounded-xl bg-gray-50 border border-gray-100 text-[#2D2D2D] leading-relaxed" id="modalNote">
                    Ada acara keluarga di luar kota yang membutuhkan kehadiran langsung.
                </div>
            </div>

            <!-- Lampiran Berkas -->
            <div class="text-xs">
                <label class="text-[#8C8C8C] font-semibold block mb-1">Dokumen Pendukung / Lampiran:</label>
                <div class="p-3 rounded-xl border border-gray-200 bg-white flex items-center justify-between hover:border-red-200 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg bg-red-50 text-[#C12132] flex items-center justify-center font-bold text-xs shrink-0">
                            PDF
                        </div>
                        <span id="modalFileName" class="font-medium text-[#2D2D2D] truncate max-w-[200px]">surat_pengajuan_cuti.pdf</span>
                    </div>
                    <a href="#" class="px-3 py-1 rounded-lg bg-gray-50 hover:bg-red-50 text-[#C12132] font-semibold text-[11px] transition-colors">
                        Unduh
                    </a>
                </div>
            </div>

        </div>

        <!-- Footer Tombol Aksi (Setujui / Tolak / Tutup) -->
        <div class="pt-4 border-t border-gray-100 flex items-center justify-end gap-3">
            <button type="button" onclick="closeApprovalModal()"
                    class="px-5 py-2.5 rounded-xl bg-gray-100 hover:bg-gray-200 text-[#5D5D5D] font-medium text-xs transition-colors">
                Batal
            </button>
            <button type="button" onclick="confirmAction('reject')"
                    class="px-5 py-2.5 rounded-xl bg-[#EF4444] hover:bg-[#DC2626] text-white font-semibold text-xs shadow-md shadow-rose-500/20 transition-all">
                Tolak
            </button>
            <button type="button" onclick="confirmAction('approve')"
                    class="px-6 py-2.5 rounded-xl bg-[#10B981] hover:bg-[#059669] text-white font-semibold text-xs shadow-md shadow-emerald-500/20 transition-all">
                Setujui
            </button>
        </div>

    </div>
</div>

<!-- SCRIPT UNTUK BUKA/TUTUP MODAL -->
<script>
    function openApprovalModal(name, type, duration, note, file, status) {
        document.getElementById('modalEmployeeName').innerText = name;
        document.getElementById('modalLeaveType').innerText = type;
        document.getElementById('modalDuration').innerText = duration;
        document.getElementById('modalNote').innerText = note;
        document.getElementById('modalFileName').innerText = file;
        
        const modal = document.getElementById('approvalModal');
        modal.classList.remove('hidden');
    }

    function closeApprovalModal() {
        const modal = document.getElementById('approvalModal');
        modal.classList.add('hidden');
    }

    function confirmAction(actionType) {
        if (actionType === 'approve') {
            alert('Pengajuan cuti berhasil disetujui!');
        } else {
            alert('Pengajuan cuti telah ditolak.');
        }
        closeApprovalModal();
    }
</script>
