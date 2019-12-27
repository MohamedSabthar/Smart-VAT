<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land_tax extends Model
{
    protected $table = 'Land_taxes';
    use SoftDeletes;

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');  //a land belongs to one VAT payer 
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // employee that registered the land tax
    }

    public function landTaxPayers()  // return tax payers only related to Land tax
    {
        return Land_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');   //collection filtered using unique id
    }

    //a Land has many payments
}
