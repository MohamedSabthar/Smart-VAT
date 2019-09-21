<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PayerController extends Controller
{
    public function payer()
    {
        return view('vatPayer.payerDashboard');
    }

    public function register()
    {
        return view('vatPayer.registerPayer');
    }

    public function profile()
    {
        return view('vatPayer.payerProfile');
    }

    public function businesslist()
    {
        return view('vatPayer.payerBusinessList');
    }
    public function businessPaymentList()
    {
        return view('vatPayer.payerPaymentList');
    }
}