<?php

namespace App\Models;

use App\Enums\UserRole;
use Database\Factories\UserFactory;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasFactory, Notifiable;

    // Nonaktifkan remember_token karena kolom tersebut tidak digunakan di database
    protected $rememberTokenName = '';

    // Atribut model yang dapat diisi secara mass-assignment
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'is_active',
    ];

    // Atribut yang disembunyikan saat serialisasi data
    protected $hidden = [
        'password',
    ];

    // Definisi casting tipe data atribut model
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'role' => UserRole::class,
            'is_active' => 'boolean',
        ];
    }

    // Cek apakah user memiliki hak akses Administrator
    public function isAdmin(): bool
    {
        return $this->role === UserRole::ADMIN;
    }

    // Cek apakah user adalah Pegawai / Mitra Kerja
    public function isMitra(): bool
    {
        return $this->role === UserRole::MITRA;
    }

    // Relasi ke data kuota cuti pegawai
    public function leaveBalances(): HasMany
    {
        return $this->hasMany(LeaveBalance::class);
    }

    // Relasi ke seluruh pengajuan cuti yang diajukan oleh user ini
    public function leaveRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class);
    }

    // Relasi ke pengajuan cuti yang diproses oleh user ini (sebagai admin)
    public function approvedRequests(): HasMany
    {
        return $this->hasMany(LeaveRequest::class, 'approved_by');
    }
}
