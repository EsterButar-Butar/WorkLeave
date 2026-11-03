<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    // Jalankan migrasi pembuatan tabel
    public function up(): void
    {
        Schema::create('leave_approvals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('leave_request_id')->constrained('leave_requests')->cascadeOnDelete();
            $table->foreignId('action_by')->constrained('users')->cascadeOnDelete(); // Admin yang melakukan aksi
            $table->enum('action', ['approved', 'rejected']);
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    // Batalkan migrasi dan hapus tabel
    public function down(): void
    {
        Schema::dropIfExists('leave_approvals');
    }
};
