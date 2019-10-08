<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Business_type extends Model
{
    protected $table = 'business_types';

    public function ranges()
    {
        return $this->belongsTo('App\Assessment_range', 'assessment_range_id');
    }
}
