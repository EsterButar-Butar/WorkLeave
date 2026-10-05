<?php

namespace Database\Seeders;

use App\Enums\UserRole;
use App\Models\LeaveBalance;
use App\Models\LeaveType;
use App\Models\User;
use Illuminate\Database\Seeder;

class LeaveBalanceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $year = (int) date('Y');
        $mitras = User::where('role', UserRole::MITRA)->get();
        $leaveTypes = LeaveType::all();

        foreach ($mitras as $mitra) {
            foreach ($leaveTypes as $type) {
                // Untuk Cuti Tahunan, berikan kuota bawaan (12)
                $quota = $type->default_quota;

                LeaveBalance::firstOrCreate(
                    [
                        'user_id' => $mitra->id,
                        'leave_type_id' => $type->id,
                        'year' => $year,
                    ],
                    [
                        'initial_quota' => $quota,
                        'used_quota' => 0,
                        'remaining_quota' => $quota,
                    ]
                );
            }
        }
    }
}
