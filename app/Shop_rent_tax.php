<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Shop_rent_tax extends Model
{
    //
    protected $table = 'shop_rent_tax';

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }

    public static function shopRentTaxPayers()    // return vat payers; only related to shop rent tax
    {
        return Shop_rent_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }
}
