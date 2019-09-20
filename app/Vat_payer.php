<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vat_payer extends Model
{
    protected $table = 'vat_payers';

    public function buisness()
    {
        return $this->hasMany('App\Buisness_tax_shop', 'payer_id'); //one VAT payer may have many shops
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a vat payer registered by an employee
    }
}