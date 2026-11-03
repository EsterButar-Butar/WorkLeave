<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveBalance extends Model
{
    use HasFactory;

    // Atribut kuota cuti pegawai yang dapat diisi secara massal
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'year',
        'initial_quota',
        'used_quota',
        'remaining_quota',
    ];

    // Casting tipe data numerik integer untuk kuota cuti
    protected function casts(): array
    {
        return [
            'year' => 'integer',
            'initial_quota' => 'integer',
            'used_quota' => 'integer',
            'remaining_quota' => 'integer',
        ];
    }

    // Relasi kepemilikan kuota ke data pengguna / mitra
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi kategori jenis cuti (tahunan, bersalin, sakit)
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }
}
