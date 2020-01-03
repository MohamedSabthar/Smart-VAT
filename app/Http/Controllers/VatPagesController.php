<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_tax_shop;
use App\Industrial_tax_shop;
use App\Land_tax;
use App\Shop_rent_tax;
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

    public function licence()
    {
        $payers = License_tax_shop::licenseTaxPayers();  // #### not completed the model
        return view('vat.licence');
    }

    public function land()
    {
        $payers = Land_tax::landTaxPayers();  //get all the vat_payers who pay Land tax
        return view('vat.land.land',['payers'=>$payers]);
    }

    public function advertizement()
    {
        return view('vat.advertizement');
    }
    public function booking()
    {
        return view('vat.booking');
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
        $ticketPayers = Entertainment_tax_tickets_payment::entertainmentTicketPayers(); //get all vat_payers who paid ticket taxes
        return view('vat.entertainment.entertainment', ['ticketPayers' => $ticketPayers]);
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