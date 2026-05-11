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
         Schema::table('users', function (Blueprint $table) {

            $table->string('nik')->unique()->after('id');

            $table->string('nama_lengkap')->after('name');

            $table->foreignId('divisi_id')
                ->nullable()
                ->constrained('divisis')
                ->nullOnDelete();

            $table->foreignId('jabatan_id')
                ->nullable()
                ->constrained('jabatans')
                ->nullOnDelete();

            $table->foreignId('lead_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->foreignId('head_id')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();

            $table->boolean('is_active')->default(true);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {

            $table->dropForeign(['divisi_id']);
            $table->dropForeign(['jabatan_id']);
            $table->dropForeign(['lead_id']);
            $table->dropForeign(['head_id']);

            $table->dropColumn([
                'nik',
                'nama_lengkap',
                'divisi_id',
                'jabatan_id',
                'lead_id',
                'head_id',
                'is_active'
            ]);
        });
    }
};
