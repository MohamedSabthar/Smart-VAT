<?php

namespace App\Http\Controllers\vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;
use App\Business_type;

use App\Http\Requests\AddBusinessRequest;
use App\Business_tax_payment;
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
        $businessTax = Vat::where('name', 'Business Tax')->find(1);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $businessTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $duePayment = $businessTaxShop->anual_worth * ($businessTax->vat_percentage/100);   //Tax due payment ammount
        }
       
        return view('vat.business.businessPayments', ['businessTaxShop'=>$businessTaxShop,'paid'=>$paid,'duePayment'=>$duePayment]);
    }
    
    // register new business
    public function registerBusiness($id, AddBusinessRequest $request)
    {
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $businessTaxShop = new Business_tax_shop();
        $businessTaxShop->registration_no = $request->assesmentNo;
        $businessTaxShop->anual_worth = $request->annualAssesmentAmount;
        $businessTaxShop->shop_name = $request->businessName;
        $businessTaxShop->phone = $request->phoneno;
        $businessTaxShop->door_no = $request->doorno;
        $businessTaxShop->street = $request->street;
        $businessTaxShop->city = $request->city;
        $businessTaxShop->type = $request->type;
        $businessTaxShop->employee_id =Auth::user()->id; // get releted employee id 
        $businessTaxShop->payer_id =$id; 

        $businessTaxShop ->save();
        
        return redirect()->route('business-profile', ['id'=>$vatPayer->id])->with('status', 'New Business Added successfully');
    }

    //delete business
    public function removeBusiness($shop_id)
    {
        $businessTaxShop = Business_tax_shop::find($shop_id);
        $businessTaxShop-> delete();
        return redirect()->back()->with('status','Delete Successful');
    }

    public function reciveBusinessPayments($shop_id, Request $request)
    {
        $payerId=Business_tax_shop::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $businessTaxPyament = new Business_tax_payment;
        $businessTaxPyament->payment = $request->payment;
        $businessTaxPyament->shop_id = $shop_id;
        $businessTaxPyament->payer_id =$payerId;
        $businessTaxPyament->user_id = Auth::user()->id;

        $businessTaxPyament->save();

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }
}