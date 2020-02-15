<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Entertainment_tax_tickets_payment extends Model
{
    protected $table = 'entertainment_tax_tickets_payments';
    use SoftDeletes;

    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }

    public static function entertainmentTicketPayers()
    {
        return Entertainment_tax_tickets_payment::all()->map(function ($payment) {
            return $payment->vatPayer;
        })->unique('id'); //collection filtered using unique id
    }

    public static function getEntertainmentPayers()
    {
        return Entertainment_tax_performance_payment::entertainmentPerformancePayers()->merge(Entertainment_tax_tickets_payment::entertainmentTicketPayers())->unique();
    }

    public function type()
    {
        return $this->belongsTo('App\Entertainment_type', 'type_id');
    }
}