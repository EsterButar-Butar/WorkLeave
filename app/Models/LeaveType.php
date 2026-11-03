<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveType extends Model
{
    use HasFactory;

    // Atribut jenis cuti yang dapat diisi secara mass-assignment
    protected $fillable = [
        'name',
        'code',
        'default_quota',
    ];

    // Casting jatah kuota default ke tipe data integer
    protected function casts(): array
    {
        return [
            'default_quota' => 'integer',
        ];
    }

    // Relasi ke tabel saldo kuota cuti milik seluruh user
    public function leaveBalances(): HasMany
    {
        return $this->hasMany(LeaveBalance::class);
    }

    // Relasi ke riwayat daftar pengajuan cuti dengan jenis ini
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }
}
