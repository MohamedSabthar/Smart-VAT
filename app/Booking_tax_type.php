<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Booking_tax_type extends Model
{
    protected $table = "booking_tax_types";

    public function subTypes()
    {
        return $this->hasMany('App\Booking_tax_sub_type', 'parent_id');
    }

    
}