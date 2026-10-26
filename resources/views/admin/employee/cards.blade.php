<!-- 4 KARTU RINGKASAN KUOTA PEGAWAI -->
<div class="grid grid-cols-2 sm:grid-cols-4 gap-3 sm:gap-4">

    <!-- Card 1: Hak Cuti Tahunan -->
    <div class="bg-[#F0F5FF] rounded-2xl px-5 py-3.5 border border-blue-100/60 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
        <span class="text-[11px] font-semibold text-[#3B82F6] block">Hak Cuti Tahunan</span>
        <span class="text-xl sm:text-[22px] font-extrabold text-[#2563EB] leading-tight block mt-1">{{ $quota['hak'] ?? 12 }} hari</span>
    </div>

    <!-- Card 2: Cuti Terpakai -->
    <div class="bg-[#E8F7F0] rounded-2xl px-5 py-3.5 border border-emerald-100/60 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
        <span class="text-[11px] font-semibold text-[#10B981] block">Cuti Terpakai</span>
        <span class="text-xl sm:text-[22px] font-extrabold text-[#10B981] leading-tight block mt-1">{{ $quota['terpakai'] ?? 0 }} hari</span>
    </div>

    <!-- Card 3: Sisa Cuti -->
    <div class="bg-[#FFF9EB] rounded-2xl px-5 py-3.5 border border-amber-100/60 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
        <span class="text-[11px] font-semibold text-[#D97706] block">Sisa Cuti</span>
        <span class="text-xl sm:text-[22px] font-extrabold text-[#D97706] leading-tight block mt-1">{{ $quota['sisa'] ?? 12 }} hari</span>
    </div>

    <!-- Card 4: Cuti Sakit -->
    <div class="bg-[#FFF0F2] rounded-2xl px-5 py-3.5 border border-rose-100/60 shadow-[0_2px_8px_rgba(0,0,0,0.02)]">
        <span class="text-[11px] font-semibold text-[#EF4444] block">Cuti Sakit</span>
        <span class="text-xl sm:text-[22px] font-extrabold text-[#EF4444] leading-tight block mt-1">{{ $quota['sakit'] ?? 0 }} hari</span>
    </div>

</div>
