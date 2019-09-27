<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business_tax_payment extends Model
{
    protected $table = 'business_tax_payments';

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function businessTaxShop()
    {
        return $this->belongsTo('App\Business_tax_shop', 'shop_id');    // a payment belogns to a buisness tax shop
    }
}