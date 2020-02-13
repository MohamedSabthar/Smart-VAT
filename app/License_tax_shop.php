<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PharIo\Manifest\License;

class License_tax_shop extends Model
{
    protected $table='license_tax_shops';

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer','payer_id');
    }


    public static function liceseTaxPayers()
    {
        return License_tax_shop::all()->map(function($tax){
            return $tax->payer;
        })->unique('id');
  
    }

    public function payments()
    {
        return $this->hasMany('App\License_tax_payment', 'shop_id');   //a shop has many payments
    }

    public function licenseType()
    {
        return $this->belongsTo('App\license_type','type');
    }

}
 