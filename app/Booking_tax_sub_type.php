<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_tax_sub_type extends Model
{
    protected $table = "booking_tax_sub_types";

    public function subTypes()
    {
        return $this->hasMany('App\Booking_tax_type', 'parent_id');
    }
}
