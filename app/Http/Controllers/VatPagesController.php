<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Buisness_tax_shop;

class VatPagesController extends Controller
{
    /**
     * this controller maps and return views for vat-routes
     */
    
    public function __construct()
    {
        $this->middleware('vat');
    }

    public function buisness()
    {
        $payers = Buisness_tax_shop::buisness_tax_payers(); //get all vat_payers who pay buisness tax
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
}
