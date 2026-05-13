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
        Schema::create('approval_cuti', function (Blueprint $table) {

            $table->id();

            $table->foreignId('pengajuan_cuti_id')
                ->constrained('pengajuan_cuti')
                ->cascadeOnDelete();

            $table->foreignId('approver_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->integer('level_approval');

            $table->enum('status', [
                'approved',
                'rejected'
            ]);

            $table->text('catatan')
                ->nullable();

            $table->timestamp('approved_at');

            $table->timestamps();

            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('approval_cuti');
    }
};
  