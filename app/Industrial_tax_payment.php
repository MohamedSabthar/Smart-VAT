<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industrial_tax_payment extends Model
{
    protected $table = 'industrial_tax_payments';
    use SoftDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function industrialTaxShop()
    {
        return $this->belongsTo('App\Industrial_tax_shop', 'shop_id');    // a payment belogns to a industrial tax shop
    }
}
