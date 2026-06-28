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
        Schema::create('pengajuan_cuti', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('jenis_cuti_id')
                ->constrained('jenis_cuti')
                ->cascadeOnDelete();

            $table->date('tanggal_mulai');

            $table->date('tanggal_selesai');

            $table->date('tanggal_masuk')
                ->nullable();

            $table->integer('jumlah_hari');

            $table->text('alasan');

            $table->enum('status', [
                'pending_lead',
                'pending_hrd',
                'pending_head',
                'pending_direktur',
                'disetujui',
                'ditolak',
            ])->default('pending_lead');

            $table->foreignId('current_approver_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('ditolak_oleh')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->text('alasan_penolakan')
                ->nullable();

            $table->timestamp('approved_at')
                ->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengajuan_cuti');
    }
};
