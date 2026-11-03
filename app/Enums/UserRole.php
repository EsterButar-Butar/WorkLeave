<?php

namespace App\Enums;

// Peran hak akses akun pengguna dalam sistem
enum UserRole: string
{
    case ADMIN = 'admin';
    case MITRA = 'mitra';

    // Label sebutan peran dalam bahasa Indonesia
    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator / HR',
            self::MITRA => 'Mitra Kerja',
        };
    }
}
