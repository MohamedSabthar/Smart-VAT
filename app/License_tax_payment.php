<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class License_tax_payment extends Model
{

    protected $table='license_tax_payments';
    use SoftDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function licenseTaxShop()
    {
        return $this->belongsTo('App\License_tax_shop','shop_id');
    }

    public function user(){
        return $this->belongsTo('App\User','user_id');        // a payment recieved belongs to a user  
    }
}
