<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Advertisement_tax_payment extends Model
{
    protected $table ='advertisement_tax_payment';
    use SoftDeletes;

    public function payer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id');   //a shop/buisness belongs to one vat payer
    }
    public function vatPayer()
    {
        return $this->belongsTo('App\Vat_payer', 'payer_id'); // a payment belongs to a VAT payer
    }
    public function user(){
        return $this->belongsTo('App\User','user_id');        // a payment recieved belongs to a user  
    }

    
    public function advertisementTaxPayment()
    {
        return $this->belongsTo('App\Advertisement_tax','shop_id');    // a payment belogns to a buisness tax shop
    }
   
}
