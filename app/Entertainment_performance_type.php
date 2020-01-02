<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Entertainment_performance_type extends Model
{
    protected $table = 'entertainment_performance_types';
    use SoftDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }
}