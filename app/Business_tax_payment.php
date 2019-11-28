<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Business_tax_payment extends Model
{
    protected $table = 'business_tax_payments';
    use SoftDeletes;
   // use forceDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function businessTaxShop()
    {
        return $this->belongsTo('App\Business_tax_shop', 'shop_id');    // a payment belogns to a buisness tax shop
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');        // a payment recieved belongs to a user  
    }
}