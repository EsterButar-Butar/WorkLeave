<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan migrasi pembuatan tabel
    public function up(): void
    {
        Schema::create('leave_balances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->year('year'); // Tahun periode cuti (e.g. 2026)
            $table->unsignedInteger('initial_quota')->default(0); // Kuota awal tahun
            $table->unsignedInteger('used_quota')->default(0); // Kuota yang sudah disetujui / terpakai
            $table->unsignedInteger('remaining_quota')->default(0); // Sisa kuota cuti aktif
            $table->timestamps();

            // Satu mitra hanya memiliki satu baris kuota per jenis cuti di tahun tertentu
            $table->unique(['user_id', 'leave_type_id', 'year']);
        });
    }

    // Batalkan migrasi dan hapus tabel
    public function down(): void
    {
        Schema::dropIfExists('leave_balances');
    }
};
