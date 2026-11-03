<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('workleave:clean-dummy', function () {
    $this->info('Membersihkan data dummy (Siti, Ayu, Putri, dll)...');
    
    // Daftar email dummy dari seeder lama
    $dummyEmails = [
        'siti@workleave.test',
        'ayu@workleave.test',
        'putri@workleave.test',
        'yanto@workleave.test',
        'yanti@workleave.test',
        'putra@workleave.test',
        'dani@workleave.test',
        'budi@workleave.test',
        'dimas@workleave.test',
    ];

    $dummyUsers = \App\Models\User::whereIn('email', $dummyEmails)->get();
    foreach ($dummyUsers as $u) {
        $reqIds = \App\Models\LeaveRequest::where('user_id', $u->id)->pluck('id');
        if ($reqIds->isNotEmpty()) {
            \App\Models\LeaveApproval::whereIn('leave_request_id', $reqIds)->delete();
            \App\Models\LeaveRequest::whereIn('id', $reqIds)->delete();
        }
        \App\Models\LeaveBalance::where('user_id', $u->id)->delete();
        $u->delete();
        $this->line("- Akun dummy {$u->name} ({$u->email}) beserta riwayat cutinya telah dihapus.");
    }

    $this->info('Pembersihan selesai! Database kini default dan bersih, siap untuk registrasi pengguna asli.');
})->purpose('Bersihkan data pegawai dan pengajuan cuti dummy dari database.');
