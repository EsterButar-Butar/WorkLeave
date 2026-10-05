<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('leave_types', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // contoh: Cuti Tahunan, Cuti Sakit, Cuti Alasan Penting
            $table->string('code')->unique(); // contoh: ANNUAL, SICK, IMPORTANT
            $table->unsignedInteger('default_quota')->default(0); // kuota default per tahun (misal 12)
            $table->boolean('is_paid')->default(true); // apakah cuti berbayar
            $table->boolean('requires_attachment')->default(false); // apakah wajib upload lampiran (surat dokter dll)
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leave_types');
    }
};
