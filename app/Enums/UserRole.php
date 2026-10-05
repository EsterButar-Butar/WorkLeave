<?php

namespace App\Enums;

enum UserRole: string
{
    case ADMIN = 'admin';
    case MITRA = 'mitra';

    public function label(): string
    {
        return match ($this) {
            self::ADMIN => 'Administrator / HR',
            self::MITRA => 'Mitra Kerja',
        };
    }
}
