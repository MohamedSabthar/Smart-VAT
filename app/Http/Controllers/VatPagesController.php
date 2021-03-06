<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_tax_shop;
use App\Industrial_tax_shop;
use App\Land_tax;
use App\Shop_rent_tax;
use App\Advertisement_tax;
use App\Booking_tax_payments_type;
use App\Entertainment_tax_tickets_payment;
use App\Club_licence_tax;
use App\Vehicle_park_tax;
use App\License_tax_shop;
use App\Slaguhtering_tax_payment;

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
        $payers=License_tax_shop::liceseTaxPayers();    //all the vat payers who pays the license tax 
        return view('vat.license.license',['payers'=>$payers]);
        

    }

    public function land()
    {
        $payers = Land_tax::landTaxPayers();  //get all the vat_payers who pay Land tax
        return view('vat.land.land', ['payers'=>$payers]);
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
    public function clubLicence()
    {
        $payers = Club_licence_tax::clubLicenceTaxPayers();  //get all the vat_payers who club licence tax
        return view('vat.clubLicence.clubLicence', ['payers'=>$payers]);
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
        // $payers = Vehicle_park_tax::vehicleParkTaxPayers(); //get all vat_payers who pay vehicle park tax
        return view('vat.vehiclePark.vehiclePark');
    }
    
    public function slaughtering()
     {   $payers= Slaguhtering_tax_payment::getSlaughteringTaxPayers();
         return view('vat.slaughtering.slaughtering',['payers'=>$payers]);
     }
}