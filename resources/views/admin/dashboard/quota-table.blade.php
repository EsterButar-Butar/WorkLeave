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
                    $demoList = [
                        ['name' => 'Siti', 'hak' => 12, 'terpakai' => 4, 'sisa' => 8, 'sakit' => 2, 'slug' => 'siti'],
                        ['name' => 'Ayu', 'hak' => 12, 'terpakai' => 7, 'sisa' => 5, 'sakit' => 4, 'slug' => 'ayu'],
                        ['name' => 'Putri', 'hak' => 12, 'terpakai' => 5, 'sisa' => 7, 'sakit' => 3, 'slug' => 'putri'],
                        ['name' => 'Yanto', 'hak' => 12, 'terpakai' => 4, 'sisa' => 8, 'sakit' => 2, 'slug' => 'yanto'],
                        ['name' => 'Yanti', 'hak' => 12, 'terpakai' => 5, 'sisa' => 7, 'sakit' => 4, 'slug' => 'yanti'],
                        ['name' => 'Putra', 'hak' => 12, 'terpakai' => 3, 'sisa' => 9, 'sakit' => 2, 'slug' => 'putra'],
                        ['name' => 'Dani', 'hak' => 12, 'terpakai' => 3, 'sisa' => 9, 'sakit' => 2, 'slug' => 'dani'],
                    ];

                    $rows = [];
                    $counter = 1;

                    // Sambungkan user database jika ada yang cocok dengan nama demo
                    foreach ($demoList as $demo) {
                        $matchedUser = null;
                        if (isset($dbEmployees) && $dbEmployees->count() > 0) {
                            $matchedUser = $dbEmployees->first(function($u) use ($demo) {
                                return stripos($u->name, $demo['name']) !== false;
                            });
                        }

                        if ($matchedUser) {
                            $currentYear = (int) date('Y');
                            $balance = \App\Models\LeaveBalance::where('user_id', $matchedUser->id)->where('year', $currentYear)->first();
                            $hak = $balance->initial_quota ?? $demo['hak'];
                            $terpakai = $balance->used_quota ?? \App\Models\LeaveRequest::where('user_id', $matchedUser->id)->where('status', \App\Enums\LeaveStatus::APPROVED)->whereHas('leaveType', fn($q)=>$q->where('code', 'ANNUAL'))->sum('total_days');
                            $sisa = $balance->remaining_quota ?? ($hak - $terpakai);
                            $sakit = \App\Models\LeaveRequest::where('user_id', $matchedUser->id)->where('status', \App\Enums\LeaveStatus::APPROVED)->whereHas('leaveType', fn($q)=>$q->where('code', 'SICK'))->sum('total_days');

                            $rows[] = [
                                'no' => $counter++,
                                'name' => $demo['name'],
                                'hak' => $hak,
                                'terpakai' => $terpakai > 0 ? (int)$terpakai : $demo['terpakai'],
                                'sisa' => $sisa > 0 ? (int)$sisa : $demo['sisa'],
                                'sakit' => $sakit > 0 ? (int)$sakit : $demo['sakit'],
                                'target' => $matchedUser->id,
                            ];
                        } else {
                            $demo['no'] = $counter++;
                            $demo['target'] = $demo['slug'];
                            $rows[] = $demo;
                        }
                    }

                    // Tambahkan user database tambahan yang belum ada di daftar demo (misal Budi Santoso, Dimas)
                    if (isset($dbEmployees) && $dbEmployees->count() > 0) {
                        foreach ($dbEmployees as $otherUser) {
                            $alreadyInList = false;
                            foreach ($rows as $r) {
                                if (isset($r['target']) && $r['target'] === $otherUser->id) {
                                    $alreadyInList = true;
                                    break;
                                }
                            }

                            if (!$alreadyInList) {
                                $currentYear = (int) date('Y');
                                $balance = \App\Models\LeaveBalance::where('user_id', $otherUser->id)->where('year', $currentYear)->first();
                                $hak = $balance->initial_quota ?? 12;
                                $terpakai = $balance->used_quota ?? \App\Models\LeaveRequest::where('user_id', $otherUser->id)->where('status', \App\Enums\LeaveStatus::APPROVED)->whereHas('leaveType', fn($q)=>$q->where('code', 'ANNUAL'))->sum('total_days');
                                $sisa = $balance->remaining_quota ?? ($hak - $terpakai);
                                $sakit = \App\Models\LeaveRequest::where('user_id', $otherUser->id)->where('status', \App\Enums\LeaveStatus::APPROVED)->whereHas('leaveType', fn($q)=>$q->where('code', 'SICK'))->sum('total_days');

                                $rows[] = [
                                    'no' => $counter++,
                                    'name' => $otherUser->name,
                                    'hak' => $hak,
                                    'terpakai' => (int) $terpakai,
                                    'sisa' => (int) $sisa,
                                    'sakit' => (int) $sakit,
                                    'target' => $otherUser->id,
                                ];
                            }
                        }
                    }
                @endphp

                @foreach($rows as $emp)
                <tr class="hover:bg-[#FFF5F6]/40 transition-colors">
                    <td class="py-4 px-3 text-center text-[#5D5D5D]">{{ $emp['no'] }}</td>
                    <td class="py-4 px-4 font-semibold text-[#2D2D2D] whitespace-nowrap">{{ $emp['name'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['hak'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['terpakai'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['sisa'] }}</td>
                    <td class="py-4 px-4 text-center font-medium">{{ $emp['sakit'] }}</td>
                    <td class="py-4 px-4 text-center">
                        <a href="{{ url('/admin/employee/' . ($emp['target'] ?? strtolower($emp['name']))) }}"
                           data-riwayat-modal
                           class="inline-block px-5 py-1.5 rounded-lg border border-[#48BB88] text-[#48BB88] hover:bg-[#48BB88] hover:text-white font-medium text-xs transition-all shadow-2xs cursor-pointer">
                            Detail
                        </a>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
