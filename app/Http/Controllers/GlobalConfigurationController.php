<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat;
use App\Assessment_range;
use App\Business_type;
use App\Vats_old_percentage;

use App\Http\Requests\UpdateBusinessTaxPercentageRequest;
use App\Http\Requests\AddBusinessTypeRequest;
use App\Http\Requests\UpdateBusinessTypeRequest;
use Carbon\Carbon;

class GlobalConfigurationController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);  //checking for email verification
        $this->middleware('admin');               //allow if user is admin
    }

    public function globalConfiguration()
    {
        $vats = Vat::whereNotNull('vat_percentage')->get();
        $assessment_ranges = Assessment_range::all();
        $vatDetails = $this->getVatDetails();
        return view('admin.globalConfiguration', ['vats'=>$vats , 'assessment_ranges'=>$assessment_ranges, 'vatDetails'=>$vatDetails]);
    }

    public function updateBusinessTaxForm()
    {
        $business = Vat::where('route', 'business')->first();
        return view('admin.globalConfigurationBusiness', ['business'=>$business]);
    }

    public function updateBusinessPercentage(UpdateBusinessTaxPercentageRequest $request)
    {
        $business = Vat::where('route', 'business')->first();
        //moving the old data to Vats_old_percentages table
        if ($business->vat_percentage==$request->vatPercentage && $business->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details entered are not updated');
        }

        $oldBusiness = new Vats_old_percentage;
        $oldBusiness->name = $business->name;
        $oldBusiness->vat_percentage = $business->vat_percentage;
        $oldBusiness->created_at = $business->created_at;
        $oldBusiness->due_date = $business->due_date;
        $oldBusiness->updated_at = Carbon::now();

        
        $oldBusiness->save();
      

        //updating the new vat percentage and due date
        $business->vat_percentage = $request->vatPercentage;
        $business->due_date=$request->dueDate;
        $business->save();

        return redirect()->back()->with('status', 'Business Tax Details updated successfully');
    }

    public function updateBusinessAssessmentRanges()
    {
        dd('test');
    }

    public function viewBusinessRangeTypes($id)
    {
        $assessmentRange = Assessment_range::find($id);
        return view('admin.globalConfigurationBusinessTypes', ['assessmentRange'=>$assessmentRange]);
    }

    public function addBusinessType($id, AddBusinessTypeRequest $request)
    {
        $businessType = new Business_type;
        $businessType->description = $request->description;
        $businessType->assessment_ammount = $request->amount;
        $businessType->assessment_range_id = $id;
        $businessType->save();

        return redirect()->back()->with('status', 'New Business Tax type added successfully');
    }


    public function updateBusinessType(UpdateBusinessTypeRequest $request)
    {
        $businessType = Business_type::find($request->updateId);
        $businessType->assessment_ammount = $request->updatedAmount;
        $businessType->description = $request->updatedDescription;

        $businessType->save();
        return redirect()->back()->with('status', ' Business Tax type updated successfully');
    }

    private function getVatDetails()
    {
        $vatDetails = new VatDetails;
        $vatDetails->business = Vat::where('route', 'business')->first();
        
        return $vatDetails;
    }
}

class VatDetails
{
};