<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat_payer;
use App\Business_type;
use App\Http\Requests\AddBusinessRequest;

class BusinessTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    public function latestPayment()
    {
        return view('vat.business.latestPayments');
    }
    
    public function buisnessProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $businessTypes = Business_type::all();

        return view('vat.business.businessProfile', ['vatPayer'=>$vatPayer,'businessTypes'=>$businessTypes]);
    }

    public function registerBusiness($id,AddBusinessRequest $request){
        dd('job');
    }
 }