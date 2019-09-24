<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat_payer;
use App\Business_type;

class PayerController extends Controller
{
    public function payer()
    {
        return view('vatPayer.payerDashboard');
    }

    public function register()
    {
        $businessTypes = Business_type::all();
        return view('vatPayer.registerPayer', ['businessTypes'=>$businessTypes]);
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