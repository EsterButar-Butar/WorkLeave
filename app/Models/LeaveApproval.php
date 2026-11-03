<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class LeaveApproval extends Model
{
    use HasFactory;

    // Atribut log riwayat persetujuan cuti yang dapat diisi secara massal
    protected $fillable = [
        'leave_request_id',
        'action_by',
        'action',
        'notes',
    ];

    // Relasi pengajuan cuti yang diproses
    public function leaveRequest(): BelongsTo
    {
        return $this->belongsTo(LeaveRequest::class);
    }

    // Relasi akun admin yang memproses aksi
    public function admin(): BelongsTo
    {
        return $this->belongsTo(User::class, 'action_by');
    }
}
