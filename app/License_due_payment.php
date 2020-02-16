<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;


class License_due_payment extends Model
{
    protected $table = 'license_due_payments';
    protected $primaryKey = ['payer_id','shop_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * overriding base Model primarKeySetting to compostie primary key
    */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('payer_id', '=', $this->getAttribute('payer_id'))
            ->where('shop_id', '=', $this->getAttribute('shop_id'));
        return $query;
    }
}
