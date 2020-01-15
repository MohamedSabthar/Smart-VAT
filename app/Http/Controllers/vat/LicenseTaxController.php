<?php

namespace App\Http\Controllers\vat;
use Auth;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Vat_payer;
use App\License_type;
use App\License_tax_shop;
use App\Http\Requests\AddLicenseRequest;

class LicenseTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
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
}
