<!-- TABEL KUOTA CUTI PEGAWAI SESUAI DESAIN -->
<div class="bg-white rounded-2xl p-6 border border-gray-100 shadow-[0_2px_12px_rgba(0,0,0,0.02)]">
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm">
            <thead>
                <tr class="border-b border-gray-100 text-xs font-semibold text-[#2D2D2D]">
                    <th class="pb-4 px-3 text-center w-12">No</th>
                    <th class="pb-4 px-4">Nama Pegawai</th>
                    <th class="pb-4 px-4 text-center">Hak Cuti Tahunan</th>
                    <th class="pb-4 px-4 text-center">Total Cuti terpakai</th>
                    <th class="pb-4 px-4 text-center">Sisa Cuti Tahunan</th>
                    <th class="pb-4 px-4 text-center">Total Cuti Sakit</th>
                    <th class="pb-4 px-4 text-center">Riwayat Cuti</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs text-[#2D2D2D]">
                @php
                    $employees = [
                        ['no' => 1, 'name' => 'Siti', 'hak' => 12, 'terpakai' => 4, 'sisa' => 8, 'sakit' => 2],
                        ['no' => 2, 'name' => 'Ayu', 'hak' => 12, 'terpakai' => 7, 'sisa' => 5, 'sakit' => 4],
                        ['no' => 3, 'name' => 'Putri', 'hak' => 12, 'terpakai' => 5, 'sisa' => 7, 'sakit' => 3],
                        ['no' => 4, 'name' => 'Yanto', 'hak' => 12, 'terpakai' => 4, 'sisa' => 8, 'sakit' => 2],
                        ['no' => 5, 'name' => 'Yanti', 'hak' => 12, 'terpakai' => 5, 'sisa' => 7, 'sakit' => 4],
                        ['no' => 6, 'name' => 'Putra', 'hak' => 12, 'terpakai' => 3, 'sisa' => 9, 'sakit' => 2],
                        ['no' => 7, 'name' => 'Dani', 'hak' => 12, 'terpakai' => 3, 'sisa' => 9, 'sakit' => 2],
                    ];
                @endphp

                @foreach($employees as $emp)
                <tr class="hover:bg-[#FFF5F6]/40 transition-colors">
                    <td class="py-4 px-3 text-center text-[#5D5D5D]">{{ $emp['no'] }}</td>
                    <td class="py-4 px-4 font-semibold text-[#2D2D2D] whitespace-nowrap">{{ $emp['name'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['hak'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['terpakai'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['sisa'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['sakit'] }}</td>
                    <td class="py-4 px-4 text-center">
                        <a href="{{ url('/admin/employee/' . strtolower($emp['name'])) }}"
                           data-riwayat-modal
                           class="inline-block px-5 py-1.5 rounded-lg border border-[#48BB88] text-[#48BB88] hover:bg-[#48BB88] hover:text-white font-medium text-xs transition-all shadow-2xs">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
