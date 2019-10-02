<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat_payer;
use App\Business_tax_shop;

class PayerController extends Controller
{
    public function payer()
    {
        return view('vatPayer.payerDashboard');
    }

    public function register()
    {
        $businessTypes = Business_type::all();
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
        $businessTaxShop = Business_tax_shop::find(1);
        // dd($businessTaxShop->shop_name);
        return view('vat.business.payerPaymentList', ['businessTaxShop'=>$businessTaxShop]);
    }

    public function updateVATpayerProfile($id, UpdateVATpayerProfileRequest $request)
    {
        $vat_payer = Vat_payer::findOrFail($id);

        //update new VAT Payer details
        $vat_payer->first_name = $request->first_name;
        $vat_payer->Middle_name = $request->Middle_name;
        $vat_payer->Last_name = $request->Last_name;
        $vat_payer->nic = $request->nic;
        $vat_payer->email = $request->email;
        $vat_payer->phone = $request->phone;

        $vat_payer->save();
        return redirect()->back()->with('status', 'VAT Payer details updated successful');
    }
}