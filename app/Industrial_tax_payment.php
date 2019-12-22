<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industrial_tax_payment extends Model
{
    protected $table = 'industrial_tax_payments';
    use SoftDeletes;
}
