<!-- TABEL RIWAYAT CUTI PEGAWAI (SESUAI GAMBAR) -->
<div class="bg-white rounded-2xl border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.02)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="bg-gray-50/70 border-b border-gray-100 text-xs font-semibold text-[#2D2D2D]">
                    <th class="py-3.5 px-5">Jenis Cuti</th>
                    <th class="py-3.5 px-4">Tgl. Mulai</th>
                    <th class="py-3.5 px-4">Tgl. Selesai</th>
                    <th class="py-3.5 px-4">Durasi</th>
                    <th class="py-3.5 px-4">Tgl. Pengajuan</th>
                    <th class="py-3.5 px-4 text-center">Status</th>
                    <th class="py-3.5 px-5">Keterangan</th>
                    <th class="py-3.5 px-5 text-center">Dokumen Pendukung</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-xs text-[#2D2D2D]">
                @php
                    $records = [
                        [
                            'type' => 'Cuti Tahunan',
                            'accent' => 'bg-blue-500',
                            'start' => '11/10/2026',
                            'end' => '13/10/2026',
                            'duration' => '2 hari',
                            'applied' => '09/10/2026',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#E6F8F0]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Urusan keluarga',
                            'file' => 'surat__pengajuan__cuti.pdf',
                            'is_from_notification' => true,
                        ],
                        [
                            'type' => 'Cuti Tahunan',
                            'accent' => 'bg-blue-500',
                            'start' => '03/02/2026',
                            'end' => '04/02/2026',
                            'duration' => '2 hari',
                            'applied' => '28/01/2026',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#E6F8F0]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Urusan keluarga',
                            'file' => 'surat_keluarga.pdf'
                        ],
                        [
                            'type' => 'Cuti Tahunan',
                            'accent' => 'bg-blue-500',
                            'start' => '15/04/2026',
                            'end' => '16/04/2026',
                            'duration' => '2 hari',
                            'applied' => '10/04/2026',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#E6F8F0]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Wisuda dan meng..',
                            'file' => 'undangan_wisuda.pdf'
                        ],
                        [
                            'type' => 'Cuti Sakit',
                            'accent' => 'bg-rose-500',
                            'start' => '10/06/2026',
                            'end' => '11/06/2026',
                            'duration' => '2 hari',
                            'applied' => '10/06/2026',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#E6F8F0]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Sakit ringan',
                            'file' => 'surat_dokter.pdf'
                        ],
                        [
                            'type' => 'Cuti Tahunan',
                            'accent' => 'bg-blue-500',
                            'start' => '20/08/2026',
                            'end' => '21/08/2026',
                            'duration' => '2 hari',
                            'applied' => '15/08/2026',
                            'status' => 'Menunggu',
                            'status_bg' => 'bg-[#FEF9E7]',
                            'status_text' => 'text-[#D97706]',
                            'note' => 'Liburan singkat',
                            'file' => 'tiket_liburan.pdf'
                        ],
                        [
                            'type' => 'Cuti Tahunan',
                            'accent' => 'bg-rose-500',
                            'start' => '05/03/2026',
                            'end' => '06/03/2026',
                            'duration' => '2 hari',
                            'applied' => '01/03/2026',
                            'status' => 'Ditolak',
                            'status_bg' => 'bg-[#FDECEC]',
                            'status_text' => 'text-[#DC2626]',
                            'note' => 'Tidak ada alasan',
                            'file' => 'surat_permohonan.pdf'
                        ],
                    ];
                @endphp

                @foreach($records as $rec)
                <tr class="{{ !empty($rec['is_from_notification']) ? 'bg-[#E6F8F0]/30 hover:bg-[#E6F8F0]/50' : 'hover:bg-gray-50/50' }} transition-colors">
                    <!-- Jenis Cuti dengan Bar Aksen Warna Vertikal -->
                    <td class="py-4 px-5 font-semibold text-[#2D2D2D] whitespace-nowrap">
                        <div class="flex items-center gap-2.5">
                            <span class="w-1 h-5 rounded-full {{ $rec['accent'] }} shrink-0"></span>
                            <span>{{ $rec['type'] }}</span>
                            @if(!empty($rec['is_from_notification']))
                            <span class="px-2 py-0.5 rounded-md bg-[#E6F8F0] border border-emerald-200 text-[#10B981] text-[10px] font-bold">
                                Baru Disetujui
                            </span>
                            @endif
                        </div>
                    </td>
                    <td class="py-4 px-4 whitespace-nowrap text-[#5D5D5D]">{{ $rec['start'] }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-[#5D5D5D]">{{ $rec['end'] }}</td>
                    <td class="py-4 px-4 font-semibold whitespace-nowrap text-[#2D2D2D]">{{ $rec['duration'] }}</td>
                    <td class="py-4 px-4 whitespace-nowrap text-[#5D5D5D]">{{ $rec['applied'] }}</td>
                    
                    <!-- Status Badge Pill -->
                    <td class="py-4 px-4 text-center whitespace-nowrap">
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold {{ $rec['status_bg'] }} {{ $rec['status_text'] }}">
                            {{ $rec['status'] }}
                        </span>
                    </td>
                    
                    <!-- Keterangan -->
                    <td class="py-4 px-5 text-[#5D5D5D] max-w-[180px] truncate">{{ $rec['note'] }}</td>
                    
                    <!-- Dokumen Pendukung & Icon Download -->
                    <td class="py-4 px-5 text-center whitespace-nowrap">
                        <div class="flex items-center justify-center gap-2">
                            <span class="inline-block px-3 py-1 rounded-lg bg-gray-100 text-[#5D5D5D] text-[11px] font-medium truncate max-w-[150px]">
                                {{ $rec['file'] }}
                            </span>
                            <button type="button" class="p-1.5 text-gray-500 hover:text-[#C12132] hover:bg-red-50 rounded-lg transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 0 0 5.25 21h13.5A2.25 2.25 0 0 0 21 18.75V16.5M16.5 12 12 16.5m0 0L7.5 12m4.5 4.5V3" />
                                </svg>
                            </button>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Catatan Kaki Informasi -->
    <div class="p-4 bg-gray-50/50 border-t border-gray-100 flex items-center gap-2 text-xs text-[#8C8C8C]">
        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-gray-400 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="m11.25 11.25.041-.02a.75.75 0 0 1 1.063.852l-.708 2.836a.75.75 0 0 0 1.063.853l.041-.021M21 12a9 9 0 1 1-18 0 9 9 0 0 1 18 0Zm-9-3.75h.008v.008H12V8.25Z" />
        </svg>
        <span>Saldo cuti dihitung dari pengajuan yang berstatus Disetujui saja.</span>
    </div>
</div>
