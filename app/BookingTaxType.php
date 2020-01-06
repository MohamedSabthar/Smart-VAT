<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class BookingTaxType extends Model
{
    protected $table = "booking_tax_types";

    public function subTypes()
    {
        return $this->hasMany('App\BookingTaxSubType', 'parent_id');
    }
}