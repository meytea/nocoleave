<?php

namespace App\Mail;

use App\Models\PengajuanCuti;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PengajuanCutiMail extends Mailable
{
    use Queueable, SerializesModels;

    public $pengajuanCuti;
    public $pesan;

    public function __construct(PengajuanCuti $pengajuanCuti, $pesan)
    {
        $this->pengajuanCuti = $pengajuanCuti;
        $this->pesan = $pesan;
    }

    public function build()
    {
        return $this
            ->subject('Notifikasi Pengajuan Cuti')
            ->view('emails.nocoleave');
    }
}
