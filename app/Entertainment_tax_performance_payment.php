<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entertainment_tax_performance_payment extends Model
{
    protected $table = "entertainment_tax_performance_payments";
    use SoftDeletes;
}
