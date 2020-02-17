<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Shop_rent_tax_due_payment extends Model
{
    protected $table = 'shop_rent_tax_due_payment';
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
