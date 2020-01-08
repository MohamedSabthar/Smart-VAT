<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industrial_tax_shop extends Model
{
    protected $table = 'industrial_tax_shops';
    use SoftDeletes;

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a shop registered by an employee
    }

    public static function industrialTaxPayers()    // return vat payers; only related to industrial tax
    {
        return Industrial_tax_shop::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }

    public function payments()
    {
        return $this->hasMany('App\Industrial_tax_payment', 'shop_id');   //a shop has many payments
    }

    public function industrialType()
    {
        return $this->belongsTo('App\Industrial_type', 'type');   //a shop belongs to a industrial type
    }

    public function due()
    {
        return $this->hasOne('App\Industrial_tax_due_payment', 'shop_id'); //a shop can have duepayment
    }
}