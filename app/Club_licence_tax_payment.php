<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Club_licence_tax_payment extends Model
{
    protected $table = 'club_licence_tax_payments';
    use SoftDeletes;
    // use forceDeletes;

    public function VatPayer()
    {
        return $this->belongsTo('App\Vat_Payer','payer_id'); // a payment belongs to a VAT payer
    }

    public function clubLicenceTax()
    {
        return $this->belongsTo('App\Club_licence_tax', 'club_id');  // a payment belogns to a Club 
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id'); // a payment recieved belongs to a user
    }
}
