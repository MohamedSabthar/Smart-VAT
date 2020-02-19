<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Shop_rent_tax_payment extends Model
{
    //
    protected $table = 'shop_rent_tax_payment';
    use SoftDeletes;
   

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function shopRentTax()
    {
        return $this->belongsTo('App\shop_rent_tax', 'shop_id');    // a payment belogns to a shop tax shop
    }
}
