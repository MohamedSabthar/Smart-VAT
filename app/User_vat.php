<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class User_vat extends Model
{
    protected $table = 'user_vats';
    protected $primaryKey = ['user_id','vat_id'];
    public $incrementing = false;
    public $timestamps = false;

    /**
     * overriding base Model primarKeySetting to compostie primary key
    */
    protected function setKeysForSaveQuery(Builder $query)
    {
        $query
            ->where('user_id', '=', $this->getAttribute('user_id'))
            ->where('vat_id', '=', $this->getAttribute('vat_id'));
        return $query;
    }

    public function vat()
    {
        return $this->belongsTo('App\Vat', 'vat_id');   //each user_vat belongs to exaclty one vat id
    }
}