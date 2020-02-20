<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slaughting_tax_shop extends Model
{
    protected $table ='slaughtering_tax_shops';


    public function payer()
    {
        return $this->belongsTo('App\Vat_payer','payer_id');
    }


    public static function slaughteringTaxPayers()
    {
        return Slaughting_tax_shop::all()->map(function($tax){
            return $tax->payer;
        })->unique('id');
  
    }
}
