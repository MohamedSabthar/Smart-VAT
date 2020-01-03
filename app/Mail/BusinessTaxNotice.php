<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Business_tax_shop;

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
        $vatPayer = Business_tax_shop::find($this->id)->payer;
        return $this->markdown('mail.businessTaxNotice', ['vatPayer'=>$vatPayer]);
    }
}