<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ApprovalCuti extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $table = 'approval_cuti';

    protected $fillable = [
        'pengajuan_cuti_id',
        'approver_id', // user yang melakukan approval/reject
        'status', //disetujui, ditolak
        'catatan', // kalo ditolak
        'created_at', // timestamp approval/reject   
    ];

    protected function casts(): array
    {
        return [
            'created_at' => 'datetime',
        ];
    }

    public function pengajuanCuti(): BelongsTo
    {
        return $this->belongsTo(PengajuanCuti::class);
    }

    public function approver(): BelongsTo
    {
        return $this->belongsTo(User::class, 'approver_id');
    }
}
