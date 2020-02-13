<?php

namespace App\Http\Controllers\vat;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;
use App\License_type;
use App\License_tax_shop;
use App\License_tax_payment;
use App\Http\Requests\AddLicenseRequest;

class LicenseTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }


    private function calculateTax($anualWorth, $assessmentAmmount, $lastPaymentDate)
    {
        $currentDate = now()->toArray();
        $licenseTax = Vat::where('route', 'license')->firstOrFail();     //something to clarify

        // dd($anualWorth*($industrialTax->vat_percentage/100)+$assessmentAmmount);
        if ($lastPaymentDate!=null) {
            return ($anualWorth*($licenseTax->vat_percentage/100)+$assessmentAmmount)*($currentDate['year']-$lastPaymentDate['year']);
        }
        
        return $anualWorth*($licenseTax->vat_percentage/100)+$assessmentAmmount;
    }

    public function licenseProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $licenseTypes = License_type::all();

        return view('vat.license.licenseProfile', ['vatPayer'=>$vatPayer,'licenseTypes'=>$licenseTypes]);
    }

    public function registerLisenceDuty($id, AddLicenseRequest $request)
    {
        $vatPayer=vat_payer::find($id);
        $licenseTaxShop= new License_tax_shop();
        $licenseTaxShop->shop_name=$request->businessName;
        $licenseTaxShop->anual_worth=$request->annualAssesmentAmount;
        $licenseTaxShop->phone=$request->phoneno;
        $licenseTaxShop->registration_no=$request->assesmentNo;
        $licenseTaxShop->street=$request->street;
        $licenseTaxShop->door_no=$request->doorno;
        $licenseTaxShop->city=$request->city;
        $licenseTaxShop->type_id=$request->type;
        $licenseTaxShop->payer_id=$id;
        $licenseTaxShop->employee_id=Auth::user()->id;

        $licenseTaxShop->save();

        return redirect()->route('license-profile',['id'=>$vatPayer->id])->with('status','New License Duty Added successfully');


    }

    public function licensePayments($shop_id)
    {
        $licenseTaxShop = License_tax_shop::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $licenseTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $licenseTaxShop->assessment_ammount;
            $duePayment = $this->calculateTax($licenseTaxShop->anual_worth, $assessmentAmmount, $lastPaymentDate);
        }
       
        return view('vat.license.licensePayments', ['licenseTaxShop'=>$licenseTaxShop,'paid'=>$paid,'duePayment'=>$duePayment]);
    }


    public function reciveLicensePayments($shop_id,Request $request)
    {
        $payerId=License_tax_shop::findOrFail($shop_id)->payer->id;  //get the VAT payer id
        
        $licenseTaxPyament = new License_tax_payment;

        $licenseTaxPyament->payment = $request->payment;
        $licenseTaxPyament->shop_id = $shop_id;
        $licenseTaxPyament->payer_id =$payerId;
        $licenseTaxPyament->user_id = Auth::user()->id;

        $licenseTaxPyament->save();
    

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }



    
}
