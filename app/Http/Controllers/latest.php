<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class latest extends Controller
{
    //
    public function latestPayment(){
        return view('latest.latestPay');

    }
}
