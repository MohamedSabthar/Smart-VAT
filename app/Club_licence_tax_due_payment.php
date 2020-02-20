<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Club_licence_tax_due_payment extends Model
{
    protected $table = 'club_licence_tax_due_payments';
    protected $primaryKey = ['payer_id','club_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * overriding base Model primarKeySetting to compostie primary key
    */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('payer_id', '=', $this->getAttribute('payer_id'))
            ->where('club_id', '=', $this->getAttribute('club_id'));
        return $query;
    }

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');
    }

    public function clubLicenceTax()
    {
        return $this->belongsTo('App\Club_licence_tax', 'club_id');  // a payment belogns to a Club 
    }
}
