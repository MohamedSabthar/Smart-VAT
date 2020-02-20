<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Vat_payer extends Model
{
    protected $table = 'vat_payers';

    public function buisness()
    {
        return $this->hasMany('App\Business_tax_shop', 'payer_id'); //one VAT payer may have many business shops
    }

    public function industrial()
    {
        return $this->hasMany('App\Industrial_tax_shop', 'payer_id'); //one VAT payer may have many industrial shops
    }
    public function shoprent()
    {
        return $this->hasMany('App\Shop_rent_tax', 'payer_id'); //one VAT payer may have many shop rent
    }
    public function advertisementTaxPayment()
    {
        return $this->hasMany('App\Advertisement_tax_payment', 'payer_id'); //one VAT payer may have many shop rent
    }
    public function booking()
    {
        return $this->hasMany('App\Booking_tax_payment','payer_id');
    }
 

    public function license()
    {
        return $this->hasmany('App\License_tax_shop','payer_id');   //one VAT payer has many license tax duties 
    }
    public function entertainmentTicketPayments()
    {
        return $this->hasMany('App\Entertainment_tax_tickets_payment', 'payer_id'); //one VAT payer may have many entertainment ticket payments
    }

    public function user()
    {
        return $this->belongsTo('App\User', 'employee_id'); // a vat payer registered by an employee
    }

    public function entertainmentPerformancePayments()
    {
        return $this->hasMany('App\Entertainment_tax_performance_payment', 'payer_id'); //one VAT payer may have many entertainment performance payments
    }

    public function bookingPayment()
    {
        return $this->hasMany('App\Booking_tax_payments_type','payer_id');
    }
    public function clubLicence()
    {
        return $this->hasMany('App\Club_licence_tax', 'payer_id'); //one VAT payer may have many clubs
    }

    public function land()
    {
        return $this->hasMany('App\Land_tax', 'payer_id');
    }
    public function slaughtering()
    {
        return $this->hasMany("App\Slaguhtering_tax_payment",'payer_id');
    }
}