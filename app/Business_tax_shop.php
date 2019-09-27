<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business_tax_shop extends Model
{
    protected $table = 'business_tax_shops';

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }

    public static function buisness_tax_payers()    // return vat payers; only related to buisness tax
    {
        return Business_tax_shop::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }

    public function payments()
    {
        return $this->hasMany('App\Business_tax_payment', 'shop_id');   //a shop has many payments
    }
}