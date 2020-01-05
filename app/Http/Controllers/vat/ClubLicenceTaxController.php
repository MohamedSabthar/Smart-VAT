<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Club_licence_tax;
use App\Club_licence_tax_payment;
use App\AddClubLicenceRequest;

class ClubLicenceTaxController extends Controller
{

    private $records;
    
    public function __contruct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware(['vat']);
    }

    
    //funtion to calculate business tax
    public function calculateTax($anualWorth, $assessmentAmmount)
    {
        $currentDate = now()->toArray();
        $clubLicenceTax = Vat::where('name', 'Club Licence Tax')->firstOrFail();

        return $anualWorth*($clubLicenceTax->vat_percentage/100)+$assessmentAmmount;
    }
    
    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic',$request->nic)->first();
    }

    public function viewQuickPayments()
    {
        return view('vat.clubLicence.clubLicenceQuickPayments');
    }

    // public function acceptQuickPayments()
    // {

    // }

    public function latestPayment()
    {
        $payments = Club_licence_tax_payment::all();
        // $payerName = Business_tax_payment::findOrFail(payer_id)->vatPayer->full_name;
        return view('vat.clubLicence.latestPayments', ['payments'=>$payments]);
    }

    public function clubLicenceProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vat.clubLicence.clubLicenceProfile', ['vatPayer'=>$vatPayer]);

    }

    // register new club
    public function registerClubLicence($id, AddClubLicenceRequest $request)
    {
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $licenceTaxClub = new Club_licence_tax();
        $licenceTaxClub->registration_no = $request->assesmentNo;
        $licenceTaxClub->anual_worth = $request->annualAssesmentAmount;
        $licenceTaxClub->club_name = $request->clubName;
        $licenceTaxClub->phone = $request->phoneno;
        $licenceTaxClub->door_no = $request->doorno;
        $licenceTaxClub->street = $request->street;
        $licenceTaxClub->city = $request->city;
        $licenceTaxClub->employee_id =Auth::user()->id; // get releted employee id
        $licenceTaxClub->payer_id =$id;

        $licenceTaxClub ->save();
        
        return redirect()->route('club-licence-profile', ['id'=>$vatPayer->id])->with('status', 'New club Added successfully');
    }

    //Report Generation
    public function clubLicenceReportGeneration()
    {
        return view('vat.clubLicence.clubLicenceReportGeneration');
    }

    //soft delete a club licence
    public function removeClubLicence($club_id)
    {
        $licenceTaxClub = Club_Licence_tax::find($club_id);
        $licenceTaxClub = delete();
        return redirect()->back->with('status','Deleted successfully');
    }

    //trash club licence
    public function trashClubLicence($payer_id)
    {
        $licenceTaxClub = Club_Licence_tax::onlyTrashed()->where('payer_id',$payer_id)->get();
        return view('vat.clubLicence.trashClubLicence',['licenceTaxClub'=>$licenceTaxClub]); 
    }

    //restore club licence
    public function restoreClubLicence($id)
    {
        $licenceTaxClub = Club_Licence_tax::onlyTrashed()->where('payer_id',$payer_id)->restore($id);
        return redirect()->route('trash-club-licence', ['licenceTaxClub'=>$licenceTaxClub])->with('status', 'Club Licence restore successful');
    }

    //soft delete Club licence payment
    public function removePayment($id)
    {
        $clubLicenceTaxPyament = Club_licence_tax_payment::find($id);
        $clubLicenceTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id)
    {
        $clubLicenceTaxPyament = Club_licence_tax_payment::onlyTrash()->where('id',$id)->restore($id);
        return redirect()->route('trash-payment',['clubLicenceTaxPyament'=>$clubLicenceTaxPyament]);
    }

}
