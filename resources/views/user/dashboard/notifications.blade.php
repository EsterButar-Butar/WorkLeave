<!-- Dropdown Notifikasi -->
<div x-show="openNotif" 
     @click.away="openNotif = false"
     x-transition:enter="transition ease-out duration-100"
     x-transition:enter-start="transform opacity-0 scale-95"
     x-transition:enter-end="transform opacity-100 scale-100"
     x-transition:leave="transition ease-in duration-75"
     x-transition:leave-start="transform opacity-100 scale-100"
     x-transition:leave-end="transform opacity-0 scale-95"
     class="absolute right-0 mt-2 w-80 sm:w-96 bg-white rounded-2xl shadow-[0_10px_30px_rgba(0,0,0,0.1)] border border-gray-100 p-4 z-50 hidden space-y-3"
     :class="{ 'hidden': !openNotif }">
    
    <!-- Header Notifikasi -->
    <div class="flex items-center justify-between pb-2 border-b border-gray-100">
        <h4 class="text-xs font-bold text-[#2D2D2D]">Notifikasi</h4>
        @if(isset($userNotifications) && $userNotifications->isNotEmpty())
            <span class="text-[10px] text-[#5D5D5D] bg-gray-100 px-2 py-0.5 rounded-full font-medium">Terbaru</span>
        @else
            <span class="text-[10px] text-[#5D5D5D] bg-gray-100 px-2 py-0.5 rounded-full font-medium">Kosong</span>
        @endif
    </div>

    <!-- List Item Notifikasi -->
    <div class="space-y-2 max-h-80 overflow-y-auto">
        @forelse ($userNotifications ?? [] as $index => $notif)
            @php
                $statusVal = $notif->status instanceof \App\Enums\LeaveStatus ? $notif->status->value : $notif->status;
                
                $startDate = \Carbon\Carbon::parse($notif->start_date);
                $endDate = \Carbon\Carbon::parse($notif->end_date);
                if ($startDate->isSameDay($endDate)) {
                    $periodFormatted = $startDate->translatedFormat('d M Y');
                } elseif ($startDate->isSameMonth($endDate)) {
                    $periodFormatted = $startDate->translatedFormat('d') . '-' . $endDate->translatedFormat('d M Y');
                } else {
                    $periodFormatted = $startDate->translatedFormat('d M') . ' - ' . $endDate->translatedFormat('d M Y');
                }

                $typeName = strtolower($notif->leaveType->name ?? 'cuti');

                if ($statusVal === 'approved') {
                    $badgeText = 'Diterima';
                    $badgeClass = 'bg-[#DCFCE7] text-[#16A34A]';
                    $message = "Pengajuan {$typeName} kamu untuk tanggal {$periodFormatted} telah ditinjau dan disetujui oleh admin.";
                } elseif ($statusVal === 'rejected') {
                    $badgeText = 'Ditolak';
                    $badgeClass = 'bg-[#FEE2E2] text-[#DC2626]';
                    $message = "Pengajuan {$typeName} kamu untuk tanggal {$periodFormatted} telah ditolak oleh admin." . ($notif->rejection_reason ? " (Alasan: {$notif->rejection_reason})" : '');
                } else {
                    $badgeText = 'Menunggu';
                    $badgeClass = 'bg-[#FEF3C7] text-[#D97706]';
                    $message = "Pengajuan {$typeName} kamu untuk tanggal {$periodFormatted} sedang menunggu peninjauan dan keputusan admin.";
                }

                $timeAgo = ($notif->action_at ?? $notif->updated_at)->diffForHumans();
            @endphp

            <!-- Notifikasi Item -->
            <div class="p-3 rounded-2xl transition-colors relative" :class="notifRead ? 'bg-white border border-gray-100' : '{{ $index === 0 ? "bg-red-50/40 border border-red-100/60" : "bg-white border border-gray-100" }}'">
                @if($index === 0)
                    <!-- Titik merah kecil di dalam kotak notifikasi jika belum dibaca (unread) -->
                    <span x-show="!notifRead" class="absolute top-3.5 right-3.5 w-2 h-2 bg-[#FA232B] rounded-full"></span>
                @endif

                <div class="pr-4 space-y-1.5">
                    <div class="flex items-center justify-between">
                        <p class="text-xs font-semibold text-[#2D2D2D]">Status Pengajuan Cuti</p>
                        <span class="text-[10px] text-[#8C8C8C]">{{ $timeAgo }}</span>
                    </div>
                    <p class="text-[11px] text-[#5D5D5D] leading-relaxed">
                        {{ $message }}
                    </p>
                    
                    <!-- Badge Status -->
                    <div class="flex items-center justify-between pt-1">
                        <span class="px-2.5 py-1 rounded-lg {{ $badgeClass }} font-semibold text-[10px]">{{ $badgeText }}</span>
                        <a href="{{ route('leave.history') }}" class="text-[10px] text-[#C12132] hover:underline font-medium">Lihat Riwayat &rarr;</a>
                    </div>
                </div>
            </div>
        @empty
            <!-- Tampilan Kosong Ketika Belum Ada Pengajuan Cuti Sama Sekali -->
            <div class="py-6 px-4 text-center">
                <div class="w-10 h-10 rounded-full bg-gray-50 border border-gray-100 text-gray-400 flex items-center justify-center mx-auto mb-2.5">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 0 0 5.454-1.31A8.967 8.967 0 0 1 18 9.75V9A6 6 0 0 0 6 9v.75a8.967 8.967 0 0 1-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 0 1-5.714 0m5.714 0a3 3 0 1 1-5.714 0" />
                    </svg>
                </div>
                <p class="text-xs font-semibold text-[#2D2D2D]">Belum Ada Notifikasi</p>
                <p class="text-[11px] text-[#5D5D5D] mt-1 leading-relaxed">Notifikasi akan otomatis muncul setelah Anda mengajukan cuti.</p>
            </div>
        @endforelse
    </div>
</div>