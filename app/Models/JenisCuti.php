<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class JenisCuti extends Model
{
    protected $table = 'jenis_cuti';

    protected $fillable = [
        'nama_cuti',
        'kuota',
        'is_tahunan',
    ];

    public function hakCuti(): HasMany
    {
        return $this->hasMany(HakCuti::class);
    }

    public function pengajuanCuti(): HasMany
    {
        return $this->hasMany(PengajuanCuti::class);
    }
}