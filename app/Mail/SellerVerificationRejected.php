<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerVerificationRejected extends Mailable
{
    use Queueable, SerializesModels;

    public Seller $seller;
    public string $reason;

    public function __construct(Seller $seller, string $reason)
    {
        $this->seller = $seller->loadMissing(['user']);
        $this->reason = $reason;
    }

    public function build()
    {
        return $this->subject('SiToko: Verifikasi Penjual Ditolak')
            ->view('emails.seller.verification_rejected');
    }
}
