<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_tax_shop;
use App\Industrial_tax_shop;
use App\Shop_rent_tax;
use App\Advertisement_tax;
use App\Booking_tax_payments_type;
use App\Entertainment_tax_tickets_payment;

class VatPagesController extends Controller
{
    /**
     * this controller maps and return views for vat-routes
     */
    
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    public function business()
    {
        $payers = Business_tax_shop::businessTaxPayers(); //get all vat_payers who pay buisness tax
        return view('vat.business.buisness', ['payers' => $payers]);
    }

    public function industrial()
    {
        $payers = Industrial_tax_shop::industrialTaxPayers(); //get all vat_payers who pay industrial tax
        return view('vat.industrial.industrial', ['payers' => $payers]);
    }

    public function license()
    {
        //$payers=License_tax_shop::liceseTaxPayers();    //all the vat payers who pays the license tax 
        //return view('vat.license.license',['payers'=>$payers]);
        return view('vat.licence');

    }

    public function land()
    {
        return view('vat.land');
    }

    public function advertisement()
    {  
        $payers = Advertisement_tax::advertisementTaxPayers();
        return view('vat.advertisement.advertisement',['payers'=>$payers]);
    }
    public function booking()
    {
        $payers = Booking_tax_payments_type::bookingTaxPayers(); //get all vat_payers who pay booking tax
        return view('vat.booking.booking', ['payers' => $payers]);
    }
    public function clubhouselicence()
    {
        return view('vat.clubHouseLicence');
    }
    public function landauction()
    {
        return view('vat.landAuction');
    }
    public function entertainment()
    {
        $entertainmentPayers = Entertainment_tax_tickets_payment::getEntertainmentPayers(); //get all vat_payers who paid ticket taxes
        return view('vat.entertainment.entertainment', ['entertainmentPayers' => $entertainmentPayers]);
    }
    public function shoprent()
    {
        $payers = Shop_rent_tax::shopRentTaxPayers(); //get all vat_payers who pay industrial tax
        return view('vat.shopRent.shopRent', ['payers' => $payers]);
    }
    public function threewheelpark()
    {
        return view('vat.threeWheelPark');
    }
    public function vehicalpark()
    {
        return view('vat.vehicalPark');
    }
    public function slaughtering()
    {
        return view('vat.slaughtering');
    }
}