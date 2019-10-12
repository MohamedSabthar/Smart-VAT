<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Business_tax_shop;

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
        $payers = Business_tax_shop::business_tax_payers(); //get all vat_payers who pay buisness tax
        return view('vat.business.buisness', ['payers' => $payers]);
    }

    public function industrial()
    {
        return view('vat.industrial');
    }

    public function licence()
    {
        return view('vat.licence');
    }

    public function land()
    {
        return view('vat.land');
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
    public function entertancementandperformance()
    {
        return view('vat.entertainmentPerformance');
    }
    public function shoprent()
    {
        return view('vat.shopRent');
    }
    public function threewheelpark()
    {
        return view('vat.threeWheelPark');
    }
    public function vehicalpark()
    {
        return view('vat.vehicalPark');
    }
    
}
