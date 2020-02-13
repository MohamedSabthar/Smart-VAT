<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Club_licence_tax_payment extends Model
{
    protected $table = 'club_licence_tax_payments';
    use SoftDelete;
    // use forceDeletes;

    public function VatPayer()
    {
        return $this->belongsTo('App\Vat_Payer','payer_id'); // a payment belongs to a VAT payer
    }

    public function clubLicenceTaxClub()
    {
        return $this->belongsTo('App\Club_licence_tax', 'club_id');  // a payment belogns to a Club 
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'user_id'); // a payment recieved belongs to a user
    }
}
