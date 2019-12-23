<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Industrial_tax_payment extends Model
{
    protected $table = 'industrial_tax_payments';
    use SoftDeletes;
}
