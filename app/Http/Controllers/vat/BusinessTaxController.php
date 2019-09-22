<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat_payer;

class BusinessTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware('vat');
    }

    public function latestPayment()
    {
        return view('vat.business.latestPayments');
    }
    
    public function buisnessProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vat.business.businessProfile', ['vatPayer'=>$vatPayer]);
    }
}