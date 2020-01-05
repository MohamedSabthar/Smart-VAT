<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking_tax extends Model
{
    //
    protected $table = 'booking_tax';
    use SoftDeletes;
    
    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }
    public function bookingTax()
    {
        return $this->belongsTo('App\booking_tax', 'shop_id'); 
    }

    public static function bookingTaxPayers()    // return vat payers; only related to shop rent tax
    {
        return Booking_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }
    public function payments()
    {
        return $this->hasMany('App\Booking_tax_payment', 'shop_id');   //a shop has many payments
    }
    

}
