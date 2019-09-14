<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

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
        return view('vat.buisness');
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
}