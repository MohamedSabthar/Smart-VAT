<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Industrial_tax_shop extends Model
{
    protected $table = 'industrial_tax_shops';
    use SoftDeletes;
}