<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Vat_payer;

class BusinessTaxNotice extends Mailable
{
    use Queueable, SerializesModels;
    private $id;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($id)
    {
        $this->id=$id;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $vatPayer = Vat_payer::find($this->id);
        return $this->markdown('mail.businessTaxNotice', ['vatPayer'=>$vatPayer]);
    }
}