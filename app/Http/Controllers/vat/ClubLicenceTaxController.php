<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Requests\AddClubLicenceRequest;
use App\Http\Controllers\Controller;
use Auth;
//report Generation
use PDF;

use App\Vat;
use App\Vat_payer;
use App\Club_licence_tax;
use App\Club_licence_tax_payment;

class ClubLicenceTaxController extends Controller
{

    private $records;
    
    public function __contruct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware(['vat']);
    }

    
    //funtion to calculate Club licence tax
    public function calculateTax($anualWorth, $dueAmount)
    {
        $currentDate = now()->toArray();
        $clubLicenceTax = Vat::where('name', 'Club Licence Tax')->firstOrFail();

        return $anualWorth*($clubLicenceTax->vat_percentage/100)+$dueAmount;
    }
    
    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic',$request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayment']= [];
            $currentDate = now()->toArray();  //get the currrent date properties
            $year = $currentDate['year'];
            $i = 0;

            foreach ($data['payerDetails']->clubLicence as $club) {
                // $assessmentAmmount = $shop->businessType->assessment_ammount;
                $assessmentAmmount = $club->assessment_ammount;
                $data['duePaymentValue'][$i] = $this->calculateTax($club->anual_worth, $assessmentAmmount);
                $data['duePayments'][$i] = Club_licence_tax_payment::where('club_id', $club->id);
                $i++;
            }
        }
        return response()->json($data, 200);
    }

    public function viewQuickPayments()
    {
        return view('vat.clubLicence.clubLicenceQuickPayments');
    }

    public function acceptQuickPayments(Request $request)
    {
        $clubId = $request->ecept(['_token']);

        if (count($clubId)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        foreach ($clubId as $clubId =>$val) {
            $licenceTaxClub = Club_licence_tax::findOrFail($clubId); //get the VAT payer id
            $payerId = $licenceTaxClub->payer->id;
            // $assessmentAmmount = $licenceTaxClub->businessType->assessment_ammount;
            $assessmentAmmount = $licenceTaxClub->assessment_ammount;

            $duePayment = $this->calculateTax($licenceTaxClub->anual_worth, $assessmentAmmount);
            $clubLicenceTaxPayment = new Club_licence_tax_payment;
            $clubLicenceTaxPayment->payment = $duePayment;
            $clubLicenceTaxPayment->club_id = $clubId;
            $clubLicenceTaxPayment->payer_id = $payerId;
            $clubLicenceTaxPayment->user_id = Auth::user()->id;

            $clubLicenceTaxPayment->save();
        }

        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

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

    public function clubLicencePayments($club_id)
    {
        //
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


    // HAVA TO CORRECT WHEN REPORT IS GENERATED
    public function generateReport(BusinessTaxReportRequest $request)                                              //get the star date and the end date for the report generation
    {
        $reportData = BusinessReport::generateBusinessReport();
        $dates = (object)$request->only(["startDate","endDate"]);
          
        // $records = Club_licence_tax_payment::
        $records=Business_tax_payment::whereBetween('created_at',[$dates->startDate,$dates->endDate])->get();
    
        $records = Business_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates       
    //    if($request->has('TaxReport'))
        {
            return view('vat.land.clubLicenceReportView',['dates'=>$dates,'records'=>$records]);
        }
        // else if($request->has('SummaryReport'))
        // {
        //     return view('vat.business.businessSummaryReport',['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        // }
      
        
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
        $clubLicenceTaxPayment = Club_licence_tax_payment::find($id);
        $clubLicenceTaxPayment -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrash()->where('id',$id)->get();
        return view('vat.clubLicence.trashPayment',['clubLicenceTaxPayment'=>$clubLicenceTaxPayment]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrash()->where('id',$id)->restore($id);
        return redirect()->route('trash-payment',['clubLicenceTaxPayment'=>$clubLicenceTaxPayment]);
    }

    // permanent delete payment
    public function destroy()
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrash()->where('id',$id)->get();
        //dd($clubLicenceTaxPayment);
        $clubLicenceTaxPayment->forceDelete();
        return redirect()->back()->with('status', 'Permanent Delete successful');
    }

    public function recieveClubLicencePayment($club_id, Request $request)
    {
        $payerId = Club_Licence_tax::findOrFail($club_id)->payer->id;  //get the VAT payer id

        $clubLicenceTaxPayment = new Club_licence_tax_payment;
        $clubLicenceTaxPayment->payment = $request->payment;
        $clubLicenceTaxPayment->club_id = $club_id;
        $clubLicenceTaxPayment->payer_id = $payerId;
        $clubLicenceTaxPayment->user_id = Auth::user()->id;

        return redirect()->back()->with('status', 'Payment added successfully');
    }

}
