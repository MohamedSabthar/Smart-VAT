<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business_tax_shop extends Model
{
    protected $table = 'business_tax_shops';
    use SoftDeletes;

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }

    public static function business_tax_payers()    // return vat payers; only related to buisness tax
    {
        return Business_tax_shop::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }

    public function payments()
    {
        return $this->hasMany('App\Business_tax_payment', 'shop_id');   //a shop has many payments
    }

    public function businessType()
    {
        return $this->belongsTo('App\Business_type', 'type');   //a shop belongs to a business type
    }
}