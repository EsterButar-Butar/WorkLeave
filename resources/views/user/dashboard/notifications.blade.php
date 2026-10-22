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
        <span class="text-[10px] text-[#5D5D5D] bg-gray-100 px-2 py-0.5 rounded-full font-medium">Terbaru</span>
    </div>

    <!-- List Item Notifikasi -->
    <div class="space-y-2">
        <!-- Notifikasi Item -->
        <div class="p-3 rounded-2xl transition-colors relative" :class="notifRead ? 'bg-white border border-gray-100' : 'bg-red-50/40 border border-red-100/60'">
            
            <!-- Titik merah kecil di dalam kotak notifikasi jika belum dibaca (unread) -->
            <span x-show="!notifRead" class="absolute top-3.5 right-3.5 w-2 h-2 bg-[#FA232B] rounded-full"></span>

            <div class="pr-4 space-y-1.5">
                <p class="text-xs font-semibold text-[#2D2D2D]">Status Pengajuan Cuti</p>
                <p class="text-[11px] text-[#5D5D5D] leading-relaxed">
                    Pengajuan cuti tahunan kamu untuk tanggal 18-21 Sept 2026 telah ditinjau oleh admin.
                </p>
                
                <!-- Badge Status -->
                <div class="flex items-center gap-2 pt-1">
                    <span class="px-2.5 py-1 rounded-lg bg-[#DCFCE7] text-[#16A34A] font-semibold text-[10px]">Diterima</span>
                </div>
            </div>
        </div>
    </div>
</div>