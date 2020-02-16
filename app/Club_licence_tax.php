<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club_licence_tax extends Model
{
    protected $table = 'club_licence_tax_clubs';
    use SoftDeletes;

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer','payer_id'); //a club licence belongs to one vat payer
    }

    public function user()
    {
        return $this->belongsTo('App\User','emloyee_id'); //a club licence registered by an employee
    } 

    public static function clubLicenceTaxPayers()  // return vat payers only related to club licence tax
    {
        return Club_licence_tax::all()->map(function ($tax) {
            return $tax->payer;
        })->unique('id'); //collection filtered using unique id
    }

    public function payments()
    {
        return $this->hasMany('App\Club_licence_tax_payment', 'club_id');
    }

    public function due()
    {
        return $this->hasOne('App\Club_licence_tax_due_payment', 'club_id');  //licences can have due payment
    }
}
