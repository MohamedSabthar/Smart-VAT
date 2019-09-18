<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Assessment_range extends Model
{
    protected $table = 'assessment_ranges';
    public $timestamps = false;

    public function vat(){
        return $this->belongsTo('App\Vat','vat_id');
    }
}
