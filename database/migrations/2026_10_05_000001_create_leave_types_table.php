<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan migrasi pembuatan tabel
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: Cuti Tahunan, Cuti Bersalin, Cuti Sakit
            $table->string('code')->unique(); // contoh: ANNUAL, MATERNITY, SICK
            $table->unsignedInteger('default_quota')->default(0); // kuota default per tahun (misal 12, 90, 7)
            $table->timestamps();
        });
    }

    // Batalkan migrasi dan hapus tabel
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
