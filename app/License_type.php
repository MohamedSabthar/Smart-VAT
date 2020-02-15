<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class License_type extends Model
{
    protected $table = 'license_type';

    public function ranges()
    {
        return $this->belongsTo('App\Assessment_range', 'assessment_range_id');
    }

    
}
