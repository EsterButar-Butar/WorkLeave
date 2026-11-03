<!-- WIDGET PEGAWAI CUTI SAAT INI SESUAI DATABASE REAL -->
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.02)]">
    <div class="mb-5 flex items-center justify-between">
        <div>
            <h2 class="text-sm font-bold text-[#2D2D2D]">Pegawai Cuti Saat Ini</h2>
            <p class="text-[11px] text-[#8C8C8C] mt-0.5">{{ \Carbon\Carbon::now()->translatedFormat('l, d F Y') }}</p>
        </div>
        <span class="px-2.5 py-0.5 rounded-full text-xs font-bold {{ isset($dbTodayLeaves) && $dbTodayLeaves->count() > 0 ? 'bg-emerald-50 text-emerald-600 border border-emerald-200' : 'bg-gray-100 text-gray-500' }}">
            {{ isset($dbTodayLeaves) ? $dbTodayLeaves->count() : 0 }} Pegawai
        </span>
    </div>

    <!-- List Pegawai Cuti -->
    <div class="space-y-3">
        @forelse($dbTodayLeaves ?? [] as $index => $item)
            @php
                $startFmt = \Carbon\Carbon::parse($item->start_date)->format('d/m/Y');
                $endFmt = \Carbon\Carbon::parse($item->end_date)->format('d/m/Y');
                $period = ($startFmt === $endFmt) ? $startFmt : ($startFmt . ' – ' . $endFmt);
                $isSick = $item->leaveType && str_contains(strtolower($item->leaveType->name), 'sakit');
                $iconBorder = $isSick ? 'border-rose-300 text-rose-500' : 'border-emerald-300 text-emerald-500';
                $badgeBorder = $isSick ? 'border-rose-300 text-rose-500 bg-rose-50/50' : 'border-emerald-300 text-emerald-500 bg-emerald-50/50';
            @endphp
            <div class="p-3.5 rounded-xl border border-gray-100 flex items-center justify-between gap-3 hover:bg-gray-50/80 transition-colors">
                <div class="flex items-center gap-3 min-w-0">
                    <div class="w-10 h-10 rounded-full border {{ $iconBorder }} flex items-center justify-center shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                        </svg>
                    </div>
                    <div class="min-w-0">
                        <h4 class="text-xs font-bold text-[#2D2D2D] truncate">{{ $item->user->name ?? 'Pegawai' }}</h4>
                        <p class="text-[11px] text-[#8C8C8C] truncate mt-0.5">{{ $period }}</p>
                    </div>
                </div>
                <span class="px-3 py-1 rounded-lg border {{ $badgeBorder }} text-[11px] font-medium shrink-0">
                    {{ $item->leaveType->name ?? 'Cuti' }}
                </span>
            </div>
        @empty
            <div class="py-8 text-center bg-gray-50/60 rounded-xl border border-dashed border-gray-200">
                <div class="w-10 h-10 rounded-full bg-white border border-gray-200 mx-auto flex items-center justify-center text-gray-400 mb-2 shadow-2xs">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M6.75 3v2.25M17.25 3v2.25M3 18.75V7.5a2.25 2.25 0 0 1 2.25-2.25h13.5A2.25 2.25 0 0 1 21 7.5v11.25m-18 0A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75m-18 0v-7.5A2.25 2.25 0 0 1 5.25 9h13.5A2.25 2.25 0 0 1 21 11.25v7.5" />
                    </svg>
                </div>
                <p class="text-xs text-gray-500 font-medium">Tidak ada pegawai yang cuti hari ini</p>
                <p class="text-[10px] text-gray-400 mt-0.5">Semua pegawai sedang bekerja aktif.</p>
            </div>
        @endforelse
    </div>
</div>
