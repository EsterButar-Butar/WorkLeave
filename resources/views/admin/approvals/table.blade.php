<!-- TABEL DAFTAR PENGAJUAN CUTI (LAYAR 2) -->
<div class="bg-white rounded-3xl p-6 lg:p-7 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.03)]">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
        <div>
            <h2 class="text-lg font-bold text-[#2D2D2D]">Daftar Pengajuan Masuk</h2>
            <p class="text-xs text-[#5D5D5D] mt-0.5">Tinjau, setujui, atau tolak permohonan cuti pegawai.</p>
        </div>

        <!-- Filter Status Mini Tabs -->
        <div class="flex items-center gap-2 bg-[#F8FAFC] p-1 rounded-xl border border-gray-100 text-xs">
            <button type="button" class="px-3 py-1.5 rounded-lg bg-white font-semibold text-[#C12132] shadow-2xs">Semua</button>
            <button type="button" class="px-3 py-1.5 rounded-lg text-[#5D5D5D] hover:text-[#2D2D2D]">Menunggu</button>
            <button type="button" class="px-3 py-1.5 rounded-lg text-[#5D5D5D] hover:text-[#2D2D2D]">Disetujui</button>
            <button type="button" class="px-3 py-1.5 rounded-lg text-[#5D5D5D] hover:text-[#2D2D2D]">Ditolak</button>
        </div>
    </div>

    <!-- Table Responsive Container -->
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-[11px] font-semibold text-[#8C8C8C] uppercase tracking-wider">
                    <th class="pb-3 px-4">Jenis Cuti</th>
                    <th class="pb-3 px-4">Nama Pegawai</th>
                    <th class="pb-3 px-3">Tgl Diajukan</th>
                    <th class="pb-3 px-3">Durasi</th>
                    <th class="pb-3 px-3 text-center">Status</th>
                    <th class="pb-3 px-4">Keterangan</th>
                    <th class="pb-3 px-3 text-center">Lampiran</th>
                    <th class="pb-3 px-3 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs text-[#2D2D2D]">
                @php
                    $requests = [
                        [
                            'id' => 1,
                            'type' => 'Cuti Tahunan',
                            'name' => 'Siti Rahma',
                            'applied_date' => '08/11/2024',
                            'duration' => '5 Hari (10-15 Nov)',
                            'status' => 'Menunggu',
                            'status_bg' => 'bg-[#FFFBEB]',
                            'status_text' => 'text-[#F59E0B]',
                            'note' => 'Ada acara keluarga di luar kota',
                            'file' => 'surat_pengajuan_cuti.pdf'
                        ],
                        [
                            'id' => 2,
                            'type' => 'Cuti Sakit',
                            'name' => 'Budi Santoso',
                            'applied_date' => '05/11/2024',
                            'duration' => '3 Hari (06-08 Nov)',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#ECFDF5]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Rawat inap gejala tipes',
                            'file' => 'surat_dokter.pdf'
                        ],
                        [
                            'id' => 3,
                            'type' => 'Cuti Melahirkan',
                            'name' => 'Putri Ayu',
                            'applied_date' => '01/11/2024',
                            'duration' => '90 Hari (10 Nov-10 Feb)',
                            'status' => 'Disetujui',
                            'status_bg' => 'bg-[#ECFDF5]',
                            'status_text' => 'text-[#10B981]',
                            'note' => 'Persalinan anak pertama',
                            'file' => 'surat_keterangan_bidan.pdf'
                        ],
                        [
                            'id' => 4,
                            'type' => 'Cuti Tahunan',
                            'name' => 'Taufik Hidayat',
                            'applied_date' => '28/10/2024',
                            'duration' => '2 Hari (02-03 Nov)',
                            'status' => 'Menunggu',
                            'status_bg' => 'bg-[#FFFBEB]',
                            'status_text' => 'text-[#F59E0B]',
                            'note' => 'Keperluan renovasi rumah',
                            'file' => 'surat_izin.pdf'
                        ],
                        [
                            'id' => 5,
                            'type' => 'Cuti Tahunan',
                            'name' => 'Rian Pratama',
                            'applied_date' => '20/10/2024',
                            'duration' => '4 Hari (25-28 Okt)',
                            'status' => 'Ditolak',
                            'status_bg' => 'bg-[#FEF2F2]',
                            'status_text' => 'text-[#EF4444]',
                            'note' => 'Beban pekerjaan proyek sedang tinggi',
                            'file' => 'surat_pengajuan.pdf'
                        ],
                    ];
                @endphp

                @foreach($requests as $req)
                <tr class="hover:bg-[#FFF5F6]/40 transition-colors">
                    <td class="py-4 px-4 font-semibold text-[#2D2D2D] whitespace-nowrap">{{ $req['type'] }}</td>
                    <td class="py-4 px-4 font-medium text-[#2D2D2D] whitespace-nowrap">{{ $req['name'] }}</td>
                    <td class="py-4 px-3 text-[#5D5D5D] whitespace-nowrap">{{ $req['applied_date'] }}</td>
                    <td class="py-4 px-3 font-medium text-[#2D2D2D] whitespace-nowrap">{{ $req['duration'] }}</td>
                    <td class="py-4 px-3 text-center whitespace-nowrap">
                        <span class="inline-block px-3 py-1 rounded-full text-[11px] font-semibold {{ $req['status_bg'] }} {{ $req['status_text'] }}">
                            {{ $req['status'] }}
                        </span>
                    </td>
                    <td class="py-4 px-4 text-[#5D5D5D] max-w-xs truncate">{{ $req['note'] }}</td>
                    <td class="py-4 px-3 text-center whitespace-nowrap">
                        <a href="#" class="inline-flex items-center gap-1.5 text-xs text-[#C12132] hover:underline font-medium">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 14.25v-2.625a3.375 3.375 0 0 0-3.375-3.375h-1.5A1.125 1.125 0 0 1 13.5 7.125v-1.5a3.375 3.375 0 0 0-3.375-3.375H8.25m0 12.75h7.5m-7.5 3H12M10.5 2.25H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                            </svg>
                            <span class="truncate max-w-[100px]">{{ $req['file'] }}</span>
                        </a>
                    </td>
                    <td class="py-4 px-3 text-center">
                        <button type="button"
                                onclick="openApprovalModal('{{ $req['name'] }}', '{{ $req['type'] }}', '{{ $req['duration'] }}', '{{ $req['note'] }}', '{{ $req['file'] }}', '{{ $req['status'] }}')"
                                class="inline-flex items-center gap-1.5 px-3.5 py-1.5 rounded-xl bg-white border border-gray-200 text-[#5D5D5D] hover:bg-[#FFF5F6] hover:text-[#C12132] hover:border-[#F4D3D4] font-medium text-xs transition-all shadow-2xs">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M2.036 12.322a1.012 1.012 0 0 1 0-.639C3.423 7.51 7.36 4.5 12 4.5c4.638 0 8.573 3.007 9.963 7.178.07.207.07.431 0 .639C20.577 16.49 16.64 19.5 12 19.5c-4.638 0-8.573-3.007-9.963-7.178Z" />
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 1 1-6 0 3 3 0 0 1 6 0Z" />
                            </svg>
                            <span>Detail</span>
                        </button>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
