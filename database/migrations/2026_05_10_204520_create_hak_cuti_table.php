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
        Schema::create('hak_cuti', function (Blueprint $table) {

            $table->id();

            $table->foreignId('user_id')
                ->constrained('users')
                ->cascadeOnDelete();

            $table->foreignId('jenis_cuti_id')
                ->constrained('jenis_cuti')
                ->cascadeOnDelete();

            $table->year('tahun');

            $table->integer('terpakai')->default(0);

            $table->integer('sisa')->default(0);

            $table->timestamps();

            
            $table->unique([
                'user_id',
                'jenis_cuti_id',
                'tahun'
            ]);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hak_cuti');
    }
};
