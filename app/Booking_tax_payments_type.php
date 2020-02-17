<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_tax_payments_type extends Model
{
    protected $table = "booking_tax_payments_types";

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function bookingTax()
    {
        return $this->belongsTo('App\booking_tax', 'shop_id');    // a payment belogns to a industrial tax shop
    }
    public static function bookingTaxPayers()    // return vat payers; only related to buisness tax
    {
        return Booking_tax_payments_type::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }
    
}