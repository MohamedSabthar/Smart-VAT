<?php

namespace App\Http\Controllers;
use App\Vat_payer;
use App\Business_type;
use App\Business_tax_shop;

use Illuminate\Http\Request;

class SendEmailController extends Controller
{
    /*
    * Sending red notice for the VAT payer inforning the due Payments
    */
    public function sendEmail()
    {
        return view('vatPayer.sendPayerRedNotice');
    }

    public function send(Request $request)
    {  
        $this->validate($request, [
            'name' => 'required',
            'email'     => 'required|email',
            'address'   => 'required'      
        ]);


    }
}
