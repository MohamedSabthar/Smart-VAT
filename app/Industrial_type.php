<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industrial_type extends Model
{
    protected $table = 'industrial_types';

    public function ranges()
    {
        return $this->belongsTo('App\Assessment_range', 'assessment_range_id');
    }
}
