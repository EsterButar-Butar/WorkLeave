<!-- TABEL RIWAYAT PENGAJUAN CUTI PEGAWAI -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
    <div class="p-4 sm:p-5 border-b border-gray-100 flex items-center justify-between">
        <div>
            <h3 class="text-sm font-bold text-[#2D2D2D]">Daftar Riwayat Pengajuan Cuti</h3>
            <p class="text-xs text-[#8C8C8C] mt-0.5">Catatan lengkap tanggal pengajuan, hari cuti, dan keputusan status</p>
        </div>
        <span class="px-3 py-1 rounded-full text-xs font-bold bg-gray-100 text-gray-700">
            {{ count($records ?? []) }} Riwayat
        </span>
    </div>

    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-[#2D2D2D]">
                    <th class="py-3.5 px-3 text-center w-12">No</th>
                    <th class="py-3.5 px-4 whitespace-nowrap">Kapan Diajukan</th>
                    <th class="py-3.5 px-4 whitespace-nowrap">Hari & Tanggal Cuti</th>
                    <th class="py-3.5 px-3 text-center whitespace-nowrap">Durasi</th>
                    <th class="py-3.5 px-4 whitespace-nowrap">Jenis Cuti</th>
                    <th class="py-3.5 px-5">Keperluan / Alasan</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Status</th>
                    <th class="py-3.5 px-4 text-center whitespace-nowrap">Dokumen</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs text-[#2D2D2D]">
                @forelse($records ?? [] as $index => $rec)
                <tr class="{{ !empty($rec['is_from_notification']) ? 'bg-[#E6F8F0]/30 hover:bg-[#E6F8F0]/50' : 'hover:bg-gray-50/50' }} transition-colors">
                    <!-- 1. Nomor Urut -->
                    <td class="py-4 px-3 text-center font-medium text-[#8C8C8C]">{{ $index + 1 }}</td>

                    <!-- 2. Kapan Diajukan (Tgl & Hari Pengajuan) -->
                    <td class="py-4 px-4 whitespace-nowrap font-medium text-[#2D2D2D]">
                        <div class="flex items-center gap-1.5">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6h4.5m4.5 0a9 9 0 1 1-18 0 9 9 0 0 1 18 0Z" />
                            </svg>
                            <span>{{ $rec['applied'] ?? '-' }}</span>
                        </div>
                    </td>

                    <!-- 3. Hari & Tanggal Cuti (Hari apa aja & periode) -->
                    <td class="py-4 px-4 whitespace-nowrap">
                        <div class="font-bold text-[#2D2D2D]">{{ $rec['days_name'] ?? 'Hari Kerja' }}</div>
                        <div class="text-[11px] text-[#8C8C8C] mt-0.5">{{ $rec['period'] ?? ($rec['start'] . ' – ' . $rec['end']) }}</div>
                    </td>

                    <!-- 4. Durasi -->
                    <td class="py-4 px-3 text-center whitespace-nowrap">
                        <span class="inline-block px-2.5 py-1 rounded-lg bg-gray-100 font-bold text-[#2D2D2D]">
                            {{ $rec['duration'] ?? '1 hari' }}
                        </span>
                    </td>

                    <!-- 5. Jenis Cuti -->
                    <td class="py-4 px-4 whitespace-nowrap font-semibold text-[#2D2D2D]">
                        <div class="flex items-center gap-2">
                            <span class="w-1.5 h-4 rounded-full {{ $rec['accent'] ?? 'bg-blue-500' }} shrink-0"></span>
                            <span>{{ $rec['type'] ?? 'Cuti' }}</span>
                        </div>
                    </td>

                    <!-- 6. Keterangan / Alasan -->
                    <td class="py-4 px-5 text-[#5D5D5D] max-w-[220px]">
                        <span class="line-clamp-2" title="{{ $rec['note'] ?? '-' }}">{{ $rec['note'] ?? '-' }}</span>
                    </td>

                    <!-- 7. Status Pengajuan -->
                    <td class="py-4 px-4 text-center whitespace-nowrap">
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-bold border {{ $rec['status_bg'] ?? 'bg-gray-100' }} {{ $rec['status_text'] ?? 'text-gray-700' }}">
                            {{ $rec['status'] ?? 'Menunggu' }}
                        </span>
                    </td>

                    <!-- 8. Dokumen Lampiran -->
                    <td class="py-4 px-4 text-center whitespace-nowrap">
                        @if(!empty($rec['file']) && $rec['file'] !== '-')
                            <span class="inline-flex items-center gap-1 px-2.5 py-1 rounded-lg bg-gray-50 border border-gray-200 text-[#5D5D5D] text-[11px] max-w-[120px] truncate" title="{{ $rec['file'] }}">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="m18.375 12.739-7.693 7.693a4.5 4.5 0 0 1-6.364-6.364l10.94-10.94A3 3 0 1 1 19.5 7.372L8.552 18.32m.009-.01-.01.01m5.699-9.941-7.81 7.81a1.5 1.5 0 0 0 2.112 2.13" />
                                </svg>
                                <span class="truncate">{{ $rec['file'] }}</span>
                            </span>
                        @else
                            <span class="text-gray-300">-</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" class="py-12 text-center text-xs text-gray-400">
                        Belum ada riwayat pengajuan cuti yang tercatat untuk pegawai ini.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <!-- Catatan Kaki Informasi -->
    <div class="p-4 bg-gray-50/50 border-t border-gray-100 flex items-center justify-between text-xs text-[#8C8C8C]">
        <div class="flex items-center gap-2">
            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
            </svg>
            <span>Riwayat menampilkan permohonan yang disetujui, sedang menunggu keputusan, maupun yang ditolak.</span>
        </div>
        <span class="font-medium text-gray-500">Tahun 2026</span>
    </div>
</div>
