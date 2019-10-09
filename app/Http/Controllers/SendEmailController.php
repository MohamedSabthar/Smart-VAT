<?php

namespace App\Http\Controllers;

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
            'full_name' => 'required',
            'email'     => 'required|email',
            'message'   => 'required'      
        ]);


    }
}
