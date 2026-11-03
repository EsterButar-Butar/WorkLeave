<?php

namespace App\Models;

use App\Enums\LeaveStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class LeaveRequest extends Model
{
    use HasFactory;

    // Atribut pengajuan cuti yang dapat diisi secara mass-assignment
    protected $fillable = [
        'user_id',
        'leave_type_id',
        'start_date',
        'end_date',
        'total_days',
        'reason',
        'attachment_path',
        'status',
        'approved_by',
        'action_at',
        'rejection_reason',
    ];

    // Casting tipe data tanggal, integer, status enum, dan datetime
    protected function casts(): array
    {
        return [
            'start_date' => 'date',
            'end_date' => 'date',
            'total_days' => 'integer',
            'status' => LeaveStatus::class,
            'action_at' => 'datetime',
        ];
    }

    // Relasi pemohon cuti ke data user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    // Relasi jenis cuti yang diajukan
    public function leaveType(): BelongsTo
    {
        return $this->belongsTo(LeaveType::class);
    }

    // Relasi admin yang menyetujui / menolak pengajuan
    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approved_by');
    }

    // Relasi riwayat catatan aksi persetujuan
    public function approvals(): HasMany
    {
        return $this->hasMany(LeaveApproval::class);
    }

    // Cek apakah status pengajuan masih pending
    public function isPending(): bool
    {
        return $this->status === LeaveStatus::PENDING;
    }

    // Cek apakah status pengajuan telah disetujui
    public function isApproved(): bool
    {
        return $this->status === LeaveStatus::APPROVED;
    }

    // Cek apakah status pengajuan telah ditolak
    public function isRejected(): bool
    {
        return $this->status === LeaveStatus::REJECTED;
    }
}
