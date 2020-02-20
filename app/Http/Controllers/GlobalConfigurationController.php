<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Vat;
use App\Assessment_range;
use App\Business_type;
use App\Industrial_type;
use App\Vats_old_percentage;
use App\Entertainment_performance_type;
use App\License_type;

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
use App\Http\Requests\UpdateClubLicenceTaxPercentageRequest;


use App\Http\Requests\UpdateLicenseTaxPercentageRequest;
use App\Http\Requests\AddLicenseTypeRequest;
use App\Http\Requests\UpdateLicenseTypeRequest;




use Carbon\Carbon;
use App\Entertainment_type;
use Auth;

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
        $oldBusiness->user_id = Auth::user()->id;
        $oldBusiness->save();
      

        //updating the new vat percentage and due date
        $business->vat_percentage = $request->vatPercentage;
        $business->due_date=$request->dueDate;
        $business->save();

        return redirect()->back()->with('status', 'Business Tax Details updated successfully');
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
        $oldIndustrial->user_id = Auth::user()->id;

        
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
            return redirect()->back()->with('error', 'Details are not updated');
        }

        $oldLand = new Vats_old_percentage;
        $oldLand->name = $land->name;
        $oldLand->created_at= $land->created_at;
        $oldLand->due_date = $land->due_date;
        $oldLand->updated_at = Carbon::now();
        $oldLand->user_id = Auth::user()->id;

        $oldLand->save();

        //updating the new vat percentage and due date
        $land->vat_percentage = $request->vatPercentage;
        $land->due_date = $request->dueDate;
        $land->save();

        return redirect()->back()->with('status', 'Land tax details updated successfully');
    }




    /*
    * Club Licence Tax percentage update
    */
    public function updateClubLicenceTaxForm()
    {
        $clubLicence = Vat::where('route', 'clubLicence')->first();
        return view('admin.globalConfigurationClubLicence', ['clubLicence'=>$clubLicence]);
    }

    public function updateClubLicencePercentage(UpdateClubLicenceTaxPercentageRequest $request)
    {
        $clubLicence = Vat::where('route', 'clubLicence')->first();

        if ($clubLicence->vat_percentage== $request->vatPercentage && $clubLicence->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details are not updated');
        }

        $oldClubLicence = new Vats_old_percentage;
        $oldClubLicence->name = $clubLicence->name;
        $oldClubLicence->created_at = $clubLicence->created_at;
        $oldClubLicence->due_date = $clubLicence->due_date;
        $oldClubLicence->updated_at = Carbon::now();
        $oldClubLicence->user_id = Auth::user()->id;

        $oldClubLicence->save();

        //updateing the new vat percentage and due date
        $clubLicence->vat_percentage = $request->vatPercentage;
        $clubLicence->due_date = $request->dueDate;
        $clubLicence->save();

        return redirect()->back()->with('status', 'Club Licence tax percentages updated successfully');
    }

    /*
    * Shop Rent Tax percentage update
    */
    public function updateShopRentTaxForm()
    {
        $shopRentTax = Vat::where('route', 'shoprent')->first();
        return view('admin.globalConfigurationShopRent', ['shopRentTax'=>$shopRentTax]);
    }

    public function updateShopRentPercentage(UpdateBusinessTaxPercentageRequest $request)
    {
        // dd($request->all());
        $shopRentTax = Vat::where('route', 'shoprent')->first();

        if ($shopRentTax->vat_percentage== $request->vatPercentage && $shopRentTax->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details are not updated');
        }

        $oldShopRentTax = new Vats_old_percentage;
        $oldShopRentTax->name = $shopRentTax->name;

        $oldShopRentTax->created_at = $shopRentTax->created_at;
        $oldShopRentTax->vat_percentage = $shopRentTax->vat_percentage;
        $oldShopRentTax->due_date = $shopRentTax->due_date;
        $oldShopRentTax->updated_at = Carbon::now();
        $oldShopRentTax->user_id = Auth::user()->id;
        $oldShopRentTax->save();

        //updateing the new vat percentage and due date
        $shopRentTax->vat_percentage = $request->vatPercentage;
        $shopRentTax->due_date = $request->dueDate;
        $shopRentTax->save();

        return redirect()->back()->with('status', 'Shop Rent tax percentages updated successfully');
    }

    /*
    * Advertisement Tax percentage update
    */
    public function updateAdvertisementTaxForm()
    {
        $advertisementTaxPayment = Vat::where('route', 'advertisement')->first();
        return view('admin.globalConfigurationAdvertisement', ['advertisementTaxPayment'=>$advertisementTaxPayment]);
    }

    public function updateAdvertisementPercentage(UpdateBusinessTaxPercentageRequest $request)
    {
        $advertisementTaxPayment = Vat::where('route', 'advertisement')->first();

        if ($advertisementTaxPayment->vat_percentage== $request->vatPercentage && $advertisementTaxPayment->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details are not updated');
        }

        $oldAdvertisementTaxPayment = new Vats_old_percentage;
        $oldAdvertisementTaxPayment->name = $advertisementTaxPayment->name;

        $oldAdvertisementTaxPayment->vat_percentage =$advertisementTaxPayment->vat_percentage;
        $oldAdvertisementTaxPayment->due_date = $advertisementTaxPayment->due_date;
        $oldAdvertisementTaxPayment->created_at = $advertisementTaxPayment->created_at;
        $oldAdvertisementTaxPayment->updated_at = Carbon::now();
        $oldAdvertisementTaxPayment->user_id = Auth::user()->id;

        $oldAdvertisementTaxPayment->save();

        //updateing the new vat percentage and due date
        $advertisementTaxPayment->vat_percentage = $request->vatPercentage;
        $advertisementTaxPayment->due_date = $request->dueDate;
        $advertisementTaxPayment->save();

        return redirect()->back()->with('status', 'Advertisement tax percentages updated successfully');
    }


    private function getVatDetails()
    {
        $vatDetails = new VatDetails;
        $vatDetails->business = Vat::where('route', 'business')->first();
        $vatDetails->industrial = Vat::where('route', 'industrial')->first();
        $vatDetails->entertainment = Vat::where('route', 'entertainment')->first();
        $vatDetails->land = Vat::where('route', 'land')->first();
        $vatDetails->clubLicence = Vat::where('route', 'clubLicence')->first();
        $vatDetails->shoprent = Vat::where('route', 'shoprent')->first();
        $vatDetails->advertisement = Vat::where('route', 'advertisement')->first();
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

/***
 * License Tax related configurations
 */



    public function updateLicenseTaxForm()
    {
        $license = Vat::where('route', 'license')->first();
        return view('admin.globalConfigurationLicense', ['license'=>$license]);
    }

    public function updatelicensePercentage(UpdateLicenseTaxPercentageRequest $request)
    {
        $license = Vat::where('route', 'license')->first();
        //moving the old data to Vats_old_percentages table
        if ($license->vat_percentage==$request->vatPercentage && $license->due_date==$request->dueDate) {
            return redirect()->back()->with('error', 'Details entered are not updated');
        }

        $oldlicense = new Vats_old_percentage;
        $oldlicense->name = $license->name;
        $oldlicense->vat_percentage = $license->vat_percentage;
        $oldlicense->created_at = $license->created_at;
        $oldlicense->due_date = $license->due_date;
        $oldlicense->updated_at = Carbon::now();

        
        $oldlicense->save();
      

        //updating the new vat percentage and due date
        $license->vat_percentage = $request->vatPercentage;
        $license->due_date=$request->dueDate;
        $license->save();

        return redirect()->back()->with('status', 'Licnese Tax Details updated successfully');
    }

    public function viewLicenseRangeTypes($id)
    {
        $assessmentRange = Assessment_range::find($id);
        return view('admin.globalConfigurationLicenseTypes', ['assessmentRange'=>$assessmentRange]);
    }

    public function addLicenseType($id, AddLicenseTypeRequest $request)
    {
        $licenseType = new License_type;
        $licenseType->description = $request->description;
        $licenseType->assessment_ammount = $request->amount;
        $licenseType->assessment_range_id = $id;
        $licenseType->save();

        return redirect()->back()->with('status', 'New License Tax type added successfully');
    }

    public function updateLicenselType(UpdateLicenseTypeRequest $request)
    {
        $licenseType = Industrial_type::find($request->updateId);
        $licenseType->assessment_ammount = $request->updatedAmount;
        $licenseType->description = $request->updatedDescription;

        $licenseType->save();
        return redirect()->back()->with('status', ' Industrial Tax type updated successfully');
    }

    public function addLicenseRange(AddAssessmentRangeRequest $request)
    {
        $licenseId = Vat::where('route', 'license')->first()->id;
        $assessmentRange = Assessment_range::where('vat_id', $licenseId)->where('start_value', $request->oldLimit)->first();
        $assessmentRange->end_value = $request->newLimit;
     
        $assessmentRange->save();
       
        $assessmentRange = new Assessment_range;
        $assessmentRange->start_value = $request->newLimit;
        $assessmentRange->vat_id = $licenseId;
        $assessmentRange->save();

        return redirect()->back()->with('status', 'Assessment range added successfully');
    }
}




class VatDetails
{
};