<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Land_tax_due_payment extends Model
{
    protected $table = 'business_tax_due_payments';
    protected $primaryKey = ['payer_id','land_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * overriding base Model primarKeySetting to compostie primary key
    */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('payer_id', '=', $this->getAttribute('payer_id'))
            ->where('land_id', '=', $this->getAttribute('land_id'));
        return $query;
    }
}
