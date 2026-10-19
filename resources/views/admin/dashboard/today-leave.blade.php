<!-- WIDGET PEGAWAI CUTI SAAT INI SESUAI DESAIN -->
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.02)]">
    <div class="mb-5">
        <h2 class="text-sm font-bold text-[#2D2D2D]">Pegawai Cuti Saat Ini</h2>
    </div>

    <!-- List Pegawai Cuti -->
    <div class="space-y-4">
        @php
            $currentLeaves = [
                [
                    'name' => 'Titi',
                    'period' => '11/10/2026-13/10/2026',
                    'type' => 'Cuti Tahunan',
                    'icon_border' => 'border-emerald-300',
                    'icon_text' => 'text-emerald-500',
                    'badge_border' => 'border-emerald-300',
                    'badge_text' => 'text-emerald-500'
                ],
                [
                    'name' => 'Siti',
                    'period' => '11/10/2026-13/10/2026',
                    'type' => 'Cuti Tahunan',
                    'icon_border' => 'border-rose-300',
                    'icon_text' => 'text-rose-500',
                    'badge_border' => 'border-rose-300',
                    'badge_text' => 'text-rose-500'
                ],
                [
                    'name' => 'Putri',
                    'period' => '11/10/2026-13/10/2026',
                    'type' => 'Cuti Tahunan',
                    'icon_border' => 'border-emerald-300',
                    'icon_text' => 'text-emerald-500',
                    'badge_border' => 'border-emerald-300',
                    'badge_text' => 'text-emerald-500'
                ],
            ];
        @endphp

        @foreach($currentLeaves as $item)
        <div class="p-3.5 rounded-xl border border-gray-50 flex items-center justify-between gap-3 hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3 min-w-0">
                <div class="w-10 h-10 rounded-full border {{ $item['icon_border'] }} {{ $item['icon_text'] }} flex items-center justify-center shrink-0">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                    </svg>
                </div>
                <div class="min-w-0">
                    <h4 class="text-xs font-bold text-[#2D2D2D] truncate">{{ $item['name'] }}</h4>
                    <p class="text-[11px] text-[#8C8C8C] truncate mt-0.5">{{ $item['period'] }}</p>
                </div>
            </div>
            <span class="px-3 py-1 rounded-lg border {{ $item['badge_border'] }} {{ $item['badge_text'] }} text-[11px] font-medium shrink-0">
                {{ $item['type'] }}
            </span>
        </div>
        @endforeach
    </div>
</div>
