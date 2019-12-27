<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Land_tax_payment extends Model
{
    protected $table = 'Land_taxe_payments';
    use SoftDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public function landTax()
    {
        return $this->belogsTo('App\Land_tax', 'land_id'); //a payment belongs to a separate Land
    }
}
