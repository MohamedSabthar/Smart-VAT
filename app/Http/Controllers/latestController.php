<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class latestController extends Controller
{
    //
    public function latestPayment(){
        return view('vat.businesstax.latestPay');

    }
}
