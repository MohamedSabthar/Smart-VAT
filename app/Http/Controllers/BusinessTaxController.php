<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BusinessTaxController extends Controller
{
    public function latestPayment()
    {
        return view('vat.business.latestPay');
    }
}