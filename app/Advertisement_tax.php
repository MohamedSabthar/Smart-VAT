<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Advertisement_tax extends Model
{
    protected $table = 'advertisement_tax';

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }    

    public static function advertisementTaxPayers()    // return vat payers; only related to industrial tax
    {
        return Advertisement_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }
    public function advertisementTaxPayment()
    {
        return $this->belongsTo('App\Advertisement_tax_payment', 'shop_id');    // a payment belogns to a buisness tax shop
    }
   
}
