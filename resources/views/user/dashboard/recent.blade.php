<div class="bg-white rounded-3xl p-6 border border-gray-100 shadow-[0_4px_24px_rgba(0,0,0,0.06)] space-y-4">
    <div class="flex items-center justify-between pb-1">
        <h2 class="text-base font-bold text-[#2D2D2D]">Riwayat Cuti Terbaru</h2>
        <a href="{{ route('leave.history') }}" class="text-xs font-semibold text-[#C12132] hover:text-[#9B0010] flex items-center gap-1 transition-colors">
            Lihat Semua
            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                <path stroke-linecap="round" stroke-linejoin="round" d="m8.25 4.5 7.5 7.5-7.5 7.5" />
            </svg>
        </a>
    </div>

    <div class="space-y-3">
        @forelse ($recentRequests ?? [] as $req)
            @php
                $statusVal = $req->status->value ?? $req->status;
                $statusClass = match($statusVal) {
                    'approved' => 'bg-[#DCFCE7]/80 border border-[#BBF7D0] text-[#16A34A]',
                    'rejected' => 'bg-[#FEE2E2]/80 border border-[#FECACA] text-[#DC2626]',
                    'cancelled' => 'bg-gray-100 border border-gray-200 text-gray-600',
                    default => 'bg-[#FEF3C7]/80 border border-[#FDE68A] text-[#D97706]',
                };
                $statusLabel = match($statusVal) {
                    'approved' => 'Disetujui',
                    'rejected' => 'Ditolak',
                    'cancelled' => 'Dibatalkan',
                    default => 'Menunggu',
                };
                $periodFormatted = ($req->start_date === $req->end_date)
                    ? \Carbon\Carbon::parse($req->start_date)->translatedFormat('d F Y')
                    : (\Carbon\Carbon::parse($req->start_date)->translatedFormat('d') . ' - ' . \Carbon\Carbon::parse($req->end_date)->translatedFormat('d F Y'));
            @endphp
            <div class="p-3.5 rounded-2xl bg-white border border-gray-100 flex items-center justify-between gap-3 shadow-xs hover:border-gray-200 transition-all">
                <div class="flex items-center gap-3.5 min-w-0">
                    <div class="w-11 h-11 rounded-2xl bg-[#FFF5F6] border border-red-100 text-[#C12132] flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m2.25 0H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-bold text-[#2D2D2D] truncate">{{ $req->leaveType->name ?? 'Cuti' }}</h4>
                        <p class="text-[11px] text-[#5D5D5D] truncate mt-0.5">{{ $periodFormatted }} ({{ $req->total_days }} hari)</p>
                    </div>
                </div>
                <div class="shrink-0">
                    <span class="px-4 py-1.5 rounded-xl {{ $statusClass }} text-xs font-semibold">
                        {{ $statusLabel }}
                    </span>
                </div>
            </div>
        @empty
            <div class="p-8 text-center bg-gray-50/50 rounded-2xl border border-dashed border-gray-200">
                <p class="text-xs text-gray-500 font-medium">Belum ada riwayat pengajuan cuti</p>
                <a href="{{ route('leave.create') }}" class="inline-flex items-center gap-1 mt-3 px-3 py-1.5 bg-[#C12132] text-white text-[11px] font-semibold rounded-xl hover:bg-[#9B0010] transition-all">
                    Ajukan Cuti Baru
                </a>
            </div>
        @endforelse
    </div>
</div>