<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat_payer;
use App\Business_type;

use App\Http\Requests\AddBusinessRequest;
use Auth;

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

    public function businessPayments($shop_id)
    {
        $businessTaxShop = Business_tax_shop::findOrFail($shop_id);

        return view('vat.business.businessPayments', ['businessTaxShop'=>$businessTaxShop]);
    }

    public function registerBusiness($id, AddBusinessRequest $request)
    {
        $vatPayer = Vat_payer :: find($id);
        $businessTaxShop = new Business_tax_shop();
        $businessTaxShop->registration_no = $request->assesmentNo;
        $businessTaxShop->anual_worth = $request->annualAssesmentAmount;
        $businessTaxShop->shop_name = $request->businessName;
        $businessTaxShop->phone = $request->phoneno;
        $businessTaxShop->door_no = $request->doorno;
        $businessTaxShop->street = $request->street;
        $businessTaxShop->city = $request->city;
        $businessTaxShop->type = "1";
        $businessTaxShop->employee_id =$id;
        $businessTaxShop->payer_id =$id;

        $businessTaxShop ->save();
        
     
        return redirect()->route('business-profile', ['id'=>$vatPayer->id])->with('status', 'New Business Added successfully');
    }
}