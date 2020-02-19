<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Slaguhtering_tax_payment extends Model
{
    protected $table = 'slaughtering_tax_payments';

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer','payer_id');
    }

    public function slaughteringType()
    {   
        return $this->belongsTo('App\Slaughtering_type','type_id');
    }

    public static function getSlaughteringTaxPayers()
    {
        return Slaguhtering_tax_payment::all()->map(function($tax){
            return $tax->payer;
        })->unique('id');
  
    }
}
