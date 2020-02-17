<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddClubLicenceRequest;
use App\Http\Requests\ClubLicenceTaxReportRequest;  //### Implent## //

use Auth;
use Carbon\Carbon;

//report Generation
use PDF;
use Illuminate\Support\Facades\DB;
use App\Reports\ClubLicenceReport;  // ##Implement## //

use App\Vat;
use App\Vat_payer;
use App\Club_licence_tax;
use App\Club_licence_tax_payment;
use App\Club_Licence_tax_due_payment; 

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
                $dueAmount = $club->due == null ? 0 : $club->due->due_amount;   //last due ammount which is not yet paid
                $data['duePaymentValue'][$i] = $this->calculateTax($club->anual_worth, $dueAmount);
                $data['duePayments'][$i] = Club_licence_tax_payment::where('club_id', $club->id)->where('created_at', 'like', "%$year%")->first(); //getting the latest payment if paid else null
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
        $clubIds = $request->except(['_token']);

        if (count($clubIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        foreach ($clubIds as $clubId =>$val) {
            $licenceTaxClub = Club_licence_tax::findOrFail($clubId); //get the VAT payer id
            $payerId = $licenceTaxClub->payer->id;
            $dueAmount = $licenceTaxClub->due == null ? 0 : $licenceTaxClub->due->due_amount;
            $duePayment = $this->calculateTax($licenceTaxClub->anual_worth, $dueAmount);
            
            $clubLicenceTaxPayment = new Club_licence_tax_payment;
            $clubLicenceTaxPayment->payment = $duePayment;
            $clubLicenceTaxPayment->club_id = $clubId;
            $clubLicenceTaxPayment->payer_id = $payerId;
            $clubLicenceTaxPayment->user_id = Auth::user()->id;

            // if there was a duepayment update it to zero
            if ($licenceTaxClub->due != null && $licenceTaxClub->due->due_amount!=0) {
                $lastDue = Club_Licence_tax_due_payment::where('club_id', $licenceTaxClub->id)->first();
                $lastDue->due_amount = 0;
                $lastDue->save();
            }

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
        $licenceTaxClub = Club_licence_tax::findOrFail($club_id);

        $currentDate = now()->toArray(); 
        $lastPaymentDate = $licenceTaxClub->payments->pluck('created_at')->last();  // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null;  // get the last payment date properties
        $paid = false;
        $duePayment = 0.0;

        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) {
            $paid = true;
        }else {
            $dueAmount = $licenceTaxClub->due == null ? 0 : $licenceTaxClub->due->due_amount;
            $duePayment = $this->calculateTax($licenceTaxClub->anual_worth, $dueAmount);
        }

        return view('vat.clubLicence.clubLicencePayments', ['licenceTaxClub'=> $licenceTaxClub, 'paid'=>$paid, 'duePayment'=>$duePayment]);
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

    public function receiveClubLicencePayment($club_id, Request $request)
    {
        $licenceTaxClub = Club_licence_tax::findOrFail($club_id);
        $payerId = $licenceTaxClub->payer->id;  //get the VAT payer id

        $clubLicenceTaxPayment = new Club_licence_tax_payment;
        $clubLicenceTaxPayment->payment = $request->payment;
        $clubLicenceTaxPayment->club_id = $club_id;
        $clubLicenceTaxPayment->payer_id = $payerId;
        $clubLicenceTaxPayment->user_id = Auth::user()->id;

        // if there was a duepayment update it to zero
        if ($licenceTaxClub->due != null && $licenceTaxClub->due->due_amount!=0) {
            $lastDue = Club_licence_tax_due_payment::where('club_id', $licenceTaxClub->id)->first();
            $lastDue->due_amount = 0;
            $lastDue->save();
        }

        $clubLicenceTaxPayment->save();

        return redirect()->back()->with('status', 'Payment added successfully');
    }

    //Report Generation
    public function clubLicenceReportGeneration()
    {
        return view('vat.clubLicence.clubLicenceReportGeneration');
    }


    // HAVA TO CORRECT WHEN REPORT IS GENERATED
    public function generateReport(ClubLicenceTaxReportRequest $request)                                              //get the star date and the end date for the report generation
    {
        $reportData = ClubLicenceReport::generateClubLicenceReport();
        $dates = (object)$request->only(["startDate","endDate"]);
          
        $records = Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.clubLicence.clubLicenceReportView', ['dates'=>$dates, 'records'=>$records]);
        } elseif ($request->has(SummaryReport)) {
            return view('vat.clubLicence.clubLicenceSummaryReport', ['dates'=>$dates, 'records'=>$records, 'reportData'=>$reportData]);
        }
    }

    public function TaxPdf(ClubLicenceTaxReportRequest $request)
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $ClubsCount=Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->count('club_id');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum, $ClubsCount));
        
        return $pdf->stream();
    }

    public function TaxReportHTML($records, $dates, $Paymentsum, $ClubsCount)
    {
        $output = "
        <h3 align='center'>Club Licence Tax Report from $dates->startDate to $dates->endDate </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
         <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>CLUB</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>ADDRESS</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
   
       
       
      </tr>
        ";
        foreach ($records as $record) {
            $output .= '
         <tr>
         <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->nic.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->vatPayer->full_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->club_id.' - '.$record->clubLicenceTax->club_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->club_id.' - '.$record->clubLicenceTax->address.'</td>
          <td style="border: 1px solid; padding:12px;">'.'Rs. '.number_format($record->payment, 2).'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->updated_at.'</td>
           
         </tr>
         ';
        }
        
        $output .= '</table>';
        $output .= "<br>Total Club Licences : ".$ClubsCount;
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

    public function summaryPdf(ClubLicenceTaxReportRequest $request)
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Club_licence_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($records, $dates, $sum));
        
        return $pdf->stream();

    }

    public function summaryReportHTML($records, $dates, $sum)
    {
        $reportData = ClubLicenceReport::generateClubLicenceReport();
        $output = "
         <h3 align='center'>Club Licence Tax Summary Report from $dates->startDate to $dates->endDate </h3>
         <table width='100%' style='border-collapse: collapse; border: 0px;'>
          <tr>
        <th style='border: 1px solid; padding:12px;' width='20%'>Club Name</th>
        <th style='border: 1px solid; padding:12px;' width='20%'>Clubs' Address</th>
        <th style='border: 1px solid; padding:12px;' width='10%'>Total Payments</th>
    
    
       </tr>
         ";
        foreach ($reportData as $description => $total) {
            $output .= '
          <tr>
           <td style="border: 1px solid; padding:12px;">'.$description.'</td>
           <td style="border: 1px solid; padding:12px;">'.'Rs.' .number_format($total, 2).'.00</td>
           
          </tr>
          ';
        }
       
        
        $output .= '</table>';
        $output .= "<br>Total Payements : Rs. ".number_format($sum, 2)."/=";
        return $output;
    }

    //soft delete a club licence
    public function removeClubLicence($club_id)
    {
        $licenceTaxClub = Club_licence_tax::find($club_id);
        $licenceTaxClub -> delete();
        return redirect()->back()->with('status','Deleted successfully');
    }

    //trash club licence
    public function trashClubLicence($payer_id)
    {
        $licenceTaxClub = Club_licence_tax::onlyTrashed()->where('payer_id',$payer_id)->get();
        return view('vat.clubLicence.trashClubLicence',['licenceTaxClub'=>$licenceTaxClub]); 
    }

    //restore club licence
    public function restoreClubLicence($id)
    {
        $licenceTaxClub = Club_licence_tax::onlyTrashed()->where('payer_id',$payer_id)->restore($id);
        return redirect()->route('trash-club-licence', ['licenceTaxClub'=>$licenceTaxClub])->with('status', 'Club Licence restore successful');
    }

    //soft delete Club licence payment
    public function removePayment($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::find($id);
        $licenceTaxClub = $clubLicenceTaxPayment->clubLicenceTax;

        //restore the dueAmount
        $restoreDue = Club_licence_tax_due_payment::where('club_id',$clubLicenceTaxPayment->clubLicenceTax->id)->first();
        $recalculateDue = $this->calculateTax(-$licenceTaxClub->anual_worth, $clubLicenceTaxPayment->payment);
        if($restoreDue==null) {
           $restoreDue = new Club_licence_tax_due_payment;
           $restoreDue->club_id = $clubLicenceTaxPayment->club_id;
           $restoreDue->payer_id = $clubLicenceTaxPayment->payer_id;
        }

        if ($recalculateDue!=0) {
            $restoreDue->due_amount = $recalculateDue;
            $restoreDue->save();
        }

        $clubLicenceTaxPayment -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //trash payment
    public function trashPayment($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrashed()->where('payer_id',$id)->get();
        return view('vat.clubLicence.trashPayment',['clubLicenceTaxPayment'=>$clubLicenceTaxPayment]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrashed()->where('id',$id);
        $clubId = $clubLicenceTaxPayment->first()->club_id;
        $clubLicenceTaxPayment->restore($id);
        return redirect()->route('club-licence-payments',['id'=>$clubId])->with('status', 'Payment restored successfully');
    }

    // permanent delete payment
    public function destroy($id)
    {
        $clubLicenceTaxPayment = Club_licence_tax_payment::onlyTrashed()->where('id',$id)->first();
        $clubLicenceTaxPayment->forceDelete();
        return redirect()->back()->with('status', 'Permanent Delete successful');
    }

}
