<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerVerificationApproved extends Mailable
{
    use Queueable, SerializesModels;

    public Seller $seller;

    public function __construct(Seller $seller)
    {
        $this->seller = $seller->loadMissing(['user']);
    }

    public function build()
    {
        return $this->subject('SiToko: Verifikasi Penjual Disetujui')
            ->view('emails.seller.verification_approved');
    }
}
