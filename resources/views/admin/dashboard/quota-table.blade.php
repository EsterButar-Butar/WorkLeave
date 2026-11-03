<!-- TABEL KUOTA CUTI PEGAWAI SESUAI DATABASE REAL -->
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
                    <th class="pb-4 px-4 text-center">Jatah Cuti Bersalin</th>
                    <th class="pb-4 px-4 text-center">Riwayat Cuti</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50 text-xs text-[#2D2D2D]">
                @php
                    $currentYear = (int) date('Y');
                    $counter = 1;
                @endphp

                @forelse($dbEmployees ?? [] as $employee)
                    @php
                        // Ambil kuota tahunan mitra dari tabel leave_balances
                        $balance = \App\Models\LeaveBalance::where('user_id', $employee->id)
                            ->where('year', $currentYear)
                            ->whereHas('leaveType', fn($q) => $q->where('code', 'ANNUAL'))
                            ->first();

                        $hak = $balance->initial_quota ?? 12;
                        
                        // Hitung total cuti tahunan yang telah disetujui (APPROVED)
                        $terpakai = $balance->used_quota ?? \App\Models\LeaveRequest::where('user_id', $employee->id)
                            ->where('status', \App\Enums\LeaveStatus::APPROVED)
                            ->whereYear('start_date', $currentYear)
                            ->whereHas('leaveType', fn($q) => $q->where('code', 'ANNUAL'))
                            ->sum('total_days');

                        $sisa = $balance->remaining_quota ?? max(0, $hak - $terpakai);

                        // Hitung total cuti sakit yang telah disetujui (APPROVED)
                        $sakit = \App\Models\LeaveRequest::where('user_id', $employee->id)
                            ->where('status', \App\Enums\LeaveStatus::APPROVED)
                            ->whereYear('start_date', $currentYear)
                            ->whereHas('leaveType', fn($q) => $q->where('code', 'SICK'))
                            ->sum('total_days');

                        // Cek apakah mitra ini pernah/sedang mengajukan cuti bersalin
                        $hasMaternity = \App\Models\LeaveRequest::where('user_id', $employee->id)
                            ->whereHas('leaveType', fn($q) => $q->where('code', 'MATERNITY'))
                            ->exists();

                        $maternityBalance = \App\Models\LeaveBalance::where('user_id', $employee->id)
                            ->where('year', $currentYear)
                            ->whereHas('leaveType', fn($q) => $q->where('code', 'MATERNITY'))
                            ->first();

                        $jatahBersalin = $maternityBalance->initial_quota ?? 90;
                    @endphp
                    <tr class="hover:bg-[#FFF5F6]/40 transition-colors">
                        <td class="py-4 px-3 text-center text-[#5D5D5D]">{{ $counter++ }}</td>
                        <td class="py-4 px-4 font-semibold text-[#2D2D2D] whitespace-nowrap">{{ $employee->name }}</td>
                        <td class="py-4 px-4 text-center font-medium">{{ (int) $hak }}</td>
                        <td class="py-4 px-4 text-center font-medium">{{ (int) $terpakai }}</td>
                        <td class="py-4 px-4 text-center font-medium">{{ (int) $sisa }}</td>
                        <td class="py-4 px-4 text-center font-medium">{{ (int) $sakit }}</td>
                        <td class="py-4 px-4 text-center font-medium">
                            @if($hasMaternity)
                                {{ (int) $jatahBersalin }}
                            @else
                                <span class="text-gray-400 font-normal">-</span>
                            @endif
                        </td>
                        <td class="py-4 px-4 text-center">
                            <a href="{{ url('/admin/employee/' . $employee->id) }}"
                                data-riwayat-modal
                                class="inline-block px-5 py-1.5 rounded-lg border border-[#48BB88] text-[#48BB88] hover:bg-[#48BB88] hover:text-white font-medium text-xs transition-all shadow-2xs cursor-pointer">
                                Detail
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="8" class="py-12 text-center text-gray-400">
                            <div class="flex flex-col items-center justify-center space-y-2">
                                <svg class="w-8 h-8 text-gray-300" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15 19.128a9.38 9.38 0 0 0 2.625.372 9.337 9.337 0 0 0 4.121-.952 4.125 4.125 0 0 0-7.533-2.493M15 19.128v-.003c0-1.113-.285-2.16-.786-3.07M15 19.128v.106A12.318 12.318 0 0 1 8.624 21c-2.331 0-4.512-.645-6.374-1.766l-.001-.109a6.375 6.375 0 0 1 11.964-3.07M12 6.375a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0Zm8.25 2.25a2.625 2.625 0 1 1-5.25 0 2.625 2.625 0 0 1 5.25 0Z" />
                                </svg>
                                <span class="text-xs">Belum ada pegawai/mitra yang terdaftar.</span>
                            </div>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>