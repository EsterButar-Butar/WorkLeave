<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan migrasi pembuatan tabel
    public function up(): void
    {
        Schema::create('leave_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users')->cascadeOnDelete();
            $table->foreignId('leave_type_id')->constrained('leave_types')->cascadeOnDelete();
            $table->date('start_date');
            $table->date('end_date');
            $table->unsignedInteger('total_days'); // Durasi cuti (hari)
            $table->text('reason'); // Keterangan / alasan cuti
            $table->string('attachment_path')->nullable(); // Dokumen pendukung / file lampiran
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled'])->default('pending');
            $table->foreignId('approved_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamp('action_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->timestamps();
        });
    }

    // Batalkan migrasi dan hapus tabel
    public function down(): void
    {
        Schema::dropIfExists('leave_requests');
    }
};
