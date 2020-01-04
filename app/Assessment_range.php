<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment_range extends Model
{
    protected $table = 'assessment_ranges';
    public $timestamps = false;

    public function vat()
    {
        return $this->belongsTo('App\Vat', 'vat_id');       // an assessment range belongs to a VAT
    }

    public function businessRangeTypes()
    {
        return $this->hasMany('App\Business_type', 'assessment_range_id');
    }

    public function industrialRangeTypes()
    {
        return $this->hasMany('App\Industrial_type', 'assessment_range_id');
    }
}