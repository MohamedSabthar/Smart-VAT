<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_tax_payment extends Model
{
    protected $table = "booking_tax_payments";

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function bookingTax()
    {
        return $this->belongsTo('App\booking_tax', 'shop_id');    // a payment belogns to a industrial tax shop
    }
   


}
