<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement_tax extends Model
{
    protected $table = 'advertisement_tax';
    use SoftDeletes;

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a advertisement registered by an employee
    }    

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public static function advertisementTaxPayers()    // return vat payers; only related to advertisement tax
    {
        return Advertisement_tax_payment::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }
  
   
}
