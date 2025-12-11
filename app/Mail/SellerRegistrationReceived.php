<?php

namespace App\Mail;

use App\Models\Seller;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SellerRegistrationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public Seller $seller;

    /**
     * Create a new message instance.
     */
    public function __construct(Seller $seller)
    {
        $this->seller = $seller->loadMissing(['user']);
    }

    public function build()
    {
        return $this->subject('SiToko: Pengajuan Registrasi Toko Diterima')
            ->view('emails.seller.registration_received');
    }
}
