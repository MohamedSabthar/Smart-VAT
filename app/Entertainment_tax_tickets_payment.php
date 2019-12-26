<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entertainment_tax_tickets_payment extends Model
{
    protected $table = 'entertainment_tax_tickets_payments';

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public static function entertainmentTicketPayers()
    {
        return Entertainment_tax_tickets_payment::all()->map(function ($payment) {
            return $payment->vatPayer;
        })->unique('id'); //collection filtered using unique id
    }
}