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
    public function businessPaymentList($id)
    {
        $vatPayer = Vat_payer::find($id);
        $businessTaxShop = Business_tax_shop::find($id);
        return view('vat.business.payerPaymentList',['vatPayer'=>$vatPayer,'businessTaxShops'=>$businessTaxShop]);
    }

    public function updateVATpayerProfile($id, UpdateVATpayerProfileRequest $request)
    {
        $vat_payer = Vat_payer::findOrFail($id);

        //update new VAT Payer details
        $vat_payer->first_name = $request->first_name;
        $vat_payer->middle_name = $request->middle_name;
        $vat_payer->last_name = $request->last_name;
        $vat_payer->nic = $request->nic;
        $vat_payer->email = $request->email;
        $vat_payer->phone = $request->phone;

        $vat_payer->save();
        return redirect()->back()->with('status', 'VAT Payer details updated successful');


    }

}