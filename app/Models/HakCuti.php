<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class HakCuti extends Model
{
    protected $table = 'hak_cuti';

    protected $fillable = [
        'user_id',
        'jenis_cuti_id',
        'tahun',
        'jatah',
        'terpakai',
        'sisa',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function jenisCuti(): BelongsTo
    {
        return $this->belongsTo(JenisCuti::class);
    }
}