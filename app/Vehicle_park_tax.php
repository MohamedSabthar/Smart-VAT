<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vehicle_park_tax extends Model
{
    protected $table = 'vehicle_park_tax_parks';
    use SoftDeletes;
    
    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');  //a vat payer belogs to one vehicle park
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id'); //a vehicle registerd by an employee
    }
    
    public  static function vehicleParkTaxPayers()   // return vat payers, only related to vehicle park tax
    {
        return Vehicle_park_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id');  //collection filtered using unique id 
    }

    // public function vehiceType()
    // {
    //     return $this->belongsTo('App\Vehicle_type', 'type');   //a vehicle belongs to a vehicle type
    // }
}
