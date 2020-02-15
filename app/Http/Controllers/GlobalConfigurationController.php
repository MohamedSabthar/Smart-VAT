<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat;
use App\Assessment_range;
use App\Business_type;
use App\Industrial_type;
use App\Vats_old_percentage;
use App\Entertainment_performance_type;

use App\Http\Requests\UpdateEntertainmentPerformanceTypeRequest;
use App\Http\Requests\AddEntertainmentPerformanceTypeRequest;
use App\Http\Requests\AddIndustrialTypeRequest;
use App\Http\Requests\AddEntertainmentTicketTypeRequest;
use App\Http\Requests\UpdateIndustrialTypeRequest;
use App\Http\Requests\AddAssessmentRangeRequest;
use App\Http\Requests\UpdateBusinessTaxPercentageRequest;
use App\Http\Requests\UpdateIndustrialTaxPercentageRequest;
use App\Http\Requests\UpdateLandTaxPercentageRequest;
use App\Http\Requests\AddBusinessTypeRequest;
use App\Http\Requests\UpdateBusinessTypeRequest;
use App\Http\Requests\UpdateEntertainmentTicketTypeRequest;
use Carbon\Carbon;
use App\Entertainment_type;

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



    /**
     *
     *
     *
     *
     */

    public function updateIndustrialTaxForm()
    {
        $industrial = Vat::where('route', 'industrial')->first();
        return view('admin.globalConfigurationIndustrial', ['industrial'=>$industrial]);
    }

    public function updateIndustrialPercentage(UpdateIndustrialTaxPercentageRequest $request)
    {
        $industrial = Vat::where('route', 'industrial')->first();
        //moving the old data to Vats_old_percentages table
        if ($industrial->vat_percentage==$request->vatPercentage && $industrial->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details entered are not updated');
        }

        $oldIndustrial = new Vats_old_percentage;
        $oldIndustrial->name = $industrial->name;
        $oldIndustrial->vat_percentage = $industrial->vat_percentage;
        $oldIndustrial->created_at = $industrial->created_at;
        $oldIndustrial->due_date = $industrial->due_date;
        $oldIndustrial->updated_at = Carbon::now();

        
        $oldIndustrial->save();
      

        //updating the new vat percentage and due date
        $industrial->vat_percentage = $request->vatPercentage;
        $industrial->due_date=$request->dueDate;
        $industrial->save();

        return redirect()->back()->with('status', 'Industrial Tax Details updated successfully');
    }

    

    public function viewIndustrialRangeTypes($id)
    {
        $assessmentRange = Assessment_range::find($id);
        return view('admin.globalConfigurationIndustrialTypes', ['assessmentRange'=>$assessmentRange]);
    }

    public function addIndustrialType($id, AddIndustrialTypeRequest $request)
    {
        $industrialType = new Industrial_type;
        $industrialType->description = $request->description;
        $industrialType->assessment_ammount = $request->amount;
        $industrialType->assessment_range_id = $id;
        $industrialType->save();

        return redirect()->back()->with('status', 'New Industrial Tax type added successfully');
    }

    public function updateIndustrialType(UpdateIndustrialTypeRequest $request)
    {
        $industrialType = Industrial_type::find($request->updateId);
        $industrialType->assessment_ammount = $request->updatedAmount;
        $industrialType->description = $request->updatedDescription;

        $industrialType->save();
        return redirect()->back()->with('status', ' Industrial Tax type updated successfully');
    }


    public function viewEntertainmentTicketTax()
    {
        $entertainmentTypes = Entertainment_type::all();
        return view('admin.globalConfigurationEntertainmentTicket', ['entertainmentTypes'=>$entertainmentTypes]);
    }

    public function viewEntertainmentPerformanceTax()
    {
        $entertainmentTypes = Entertainment_performance_type::all();
        return view('admin.globalConfigurationEntertainmentPerformance', ['entertainmentTypes'=>$entertainmentTypes]);
    }

    public function addEnterainmentPerformanceType(AddEntertainmentPerformanceTypeRequest $request)
    {
        $entertainmentTicketType = new Entertainment_performance_type;
        $entertainmentTicketType->description = $request->description;
        $entertainmentTicketType->amount  = $request->amount;
        $entertainmentTicketType->additional_amount  = $request->additionalAmmount;
        $entertainmentTicketType->save();

        return redirect()->back()->with('status', 'New Perfomance Tax type added successfully');
    }

    public function updateEntertainmentPerformanceTaxDetails(UpdateEntertainmentPerformanceTypeRequest $request)
    {
        $entertainmentTicketType = Entertainment_performance_type::findOrFail($request->updateId);
        $entertainmentTicketType->description = $request->updateDescription;
        $entertainmentTicketType->amount  = $request->updateAmount;
        $entertainmentTicketType->additional_amount  = $request->updateAdditionalAmount;
        $entertainmentTicketType->save();

        return redirect()->back()->with('status', 'Ticket Tax updated successfully');
    }

    public function addEnterainmentTicketType(AddEntertainmentTicketTypeRequest $request)
    {
        $entertainmentTicketType = new Entertainment_type;
        $entertainmentTicketType->description = $request->description;
        $entertainmentTicketType->vat_percentage  = $request->percentage;
        $entertainmentTicketType->save();

        return redirect()->back()->with('status', 'New Ticket Tax type added successfully');
    }

    public function updateEntertainmentTicketPercentage(UpdateEntertainmentTicketTypeRequest $request)
    {
        $entertainmentTicketType = Entertainment_type::findOrFail($request->updateId);
        $entertainmentTicketType->description = $request->updateDescription;
        $entertainmentTicketType->vat_percentage  = $request->updatePercentage;
        $entertainmentTicketType->save();

        return redirect()->back()->with('status', 'Ticket Tax updated successfully');
    }

    /*
    * Land tax details update
    */
    public function updateLandTaxForm()
    {
        $land = Vat::where('route', 'land')->first();
        return view('admin.globalConfigurationLand', ['land'=>$land]);
    }

    public function updateLandPercentage(UpdateLandTaxPercentageRequest $request)
    {
        $land = Vat::where('route', 'land')->first();
        //moving the old data to Vats_old_percentages table
        if ($land->vat_percentage==$request->vatPercentage && $land->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details sre not updated');
        }

        $oldLand = new Vats_old_percentage;
        $oldLand->name = $land->name;
        $oldLand->created_at= $land->created_at;
        $oldLand->due_date = $land->due_date;
        $oldLand->updated_at = Carbon::now();

        $oldLand->save();

        //updating the new vat percentage and due date
        $land->vat_percentage = $request->vatPercentage;
        $land->due_date = $request->dueDate;
        $land->save();

        return redirect()->back()->with('status', 'Land tax details updated successfully');
    }


    private function getVatDetails()
    {
        $vatDetails = new VatDetails;
        $vatDetails->business = Vat::where('route', 'business')->first();
        $vatDetails->industrial = Vat::where('route', 'industrial')->first();
        $vatDetails->entertainment = Vat::where('route', 'entertainment')->first();
        $vatDetails->land = Vat::where('route', 'land')->first();
        $vatDetails->clubLicence = Vat::where('route', 'clubLicence')->first();
        return $vatDetails;
    }


    public function addIndustrialRange(AddAssessmentRangeRequest $request)
    {
        $industrialId = Vat::where('route', 'industrial')->first()->id;
        $assessmentRange = Assessment_range::where('vat_id', $industrialId)->where('start_value', $request->oldLimit)->first();
        $assessmentRange->end_value = $request->newLimit;
     
        $assessmentRange->save();
       
        $assessmentRange = new Assessment_range;
        $assessmentRange->start_value = $request->newLimit;
        $assessmentRange->vat_id = $industrialId;
        $assessmentRange->save();

        return redirect()->back()->with('status', 'Assessment range added successfully');
    }


    public function addBusinessRange(AddAssessmentRangeRequest $request)
    {
        $businessId = Vat::where('route', 'business')->first()->id;
        $assessmentRange = Assessment_range::where('vat_id', $businessId)->where('start_value', $request->oldLimit)->first();
        $assessmentRange->end_value = $request->newLimit;
     
        $assessmentRange->save();
       
        $assessmentRange = new Assessment_range;
        $assessmentRange->start_value = $request->newLimit;
        $assessmentRange->vat_id = $businessId;
        $assessmentRange->save();

        return redirect()->back()->with('status', 'Assessment range added successfully');
    }
}

class VatDetails
{
};