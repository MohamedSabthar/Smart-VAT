<?php

namespace App\Http\Controllers\vat;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddLandRequest;
use App\Http\Requests\LandTaxReportRequest;
use App\Http\Requests\UpdateLandProfileRequest;

use App\Vat;
use App\Vat_payer;
use App\Land_tax;
use App\Land_tax_payment;
use App\Land_tax_due_payment;
 

use Auth;
use Carbon\Carbon;

//report Generation
use PDF;
use Illuminate\Support\Facades\DB;
use App\Reports\LandReport;

class LandTaxController extends Controller
{
    public function _construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware(['vat']);
    }

    private function calculateTax($landWorth, $dueAmount)
    {
        $currentDate = now()->toArray();
        $landTax = Vat::where('name', 'Land Tax')->firstOrFail();
        
        // Payments have to made yearly, no amounts fines taken forward
        return $landWorth*($landTax->vat_percentage/100)+ $dueAmount;

    }

    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] !=null) {
            $data['duePaymentValue'] = [];
            $data['duePayments'] = [];
            $currentDate = now()->toArray();
            $year = $currentDate['year'];
            $i = 0;

            foreach ($data['payerDetails']->land as $premises) {
                $dueAmount = $premises->due == null ? 0 : $premises->due->due_amount;    //last due ammount which is not yet paid
                $data['duePaymentValue'][$i] = $this->calculateTax($premises->worth, $dueAmount);
                $data['duePayments'][$i] = Land_tax_payment::where('land_id', $land_id)->where('created_at', 'like',"%$year%")->first();  //getting the latest payment if paid else null
                $i++;
            }
        }
        return response()->json($data, 200);
    }

    public function viewQuickPayments()
    {
        return view('vat.land.landQuickPayments');
    }

    public function acceptQuickPayments(Request $request)
    {
        $landIds = $request->except(['_token']);

        if (count($landIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }

        foreach ($landIds as $landId => $val) {
            $landTaxPremises = Land_tax::findOrFail($landId);
            $payerId = $landTaxPremises->payer->id;
            $dueAmount = $landTaxPremises->due == null ? 0 : $landTaxPremises->due->due_amount;
            $duePayment = $this->calculateTax($landTaxPremises->worth, $dueAmount);

            $landTaxPayment = new Land_tax_payment;
            $landTaxPayment->payment = $duePayment;
            $landTaxPayment->land_id = $landId;
            $landTaxPayment->payer_id = $payerId;
            $landTaxPayment->user_id = Auth::user()->id;

            // if there was a duepayment update it to zero
            if ($landTaxPremises->due != null && $landTaxPremises->due->due_amount!=0) {
                $lastDue = Land_tax_due_payment::where('land_id', $landTaxPremises->id)->first();
                $lastDue->due_amount = 0;
                $lastDue->save();
            }

            $landTaxPayment->save();
        }

        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

    public function landProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        return view('vat.land.landProfile', ['vatPayer'=>$vatPayer]);
    }

    public function landPayments($land_id)
    {
        $landTaxPremises = Land_tax::findOrFail($land_id);
        
        $currentDate = now()->toArray();  // get the current date propoties
        $lastPaymentDate = $landTaxPremises->payments->pluck('created_at')->last();  // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid = false;
        $duePayment = 0.0;

        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $dueAmount = $landTaxPremises->due == null ? 0 : $landTaxPremises->due->due_amount;   //last due ammount which is not yet paid
            $duePayment = $this->calculateTax($landTaxPremises->worth, $dueAmount);
        }

         return view('vat.land.landPayments', ['landTaxPremises'=>$landTaxPremises, 'paid'=>$paid,'duePayment'=>$duePayment]);  
    }

    // register new Premises for Land tax
    public function registerLand($id, AddLandRequest $request)
    {
        $vatPayer = Vat_payer:: find($id);  // get vat payer id
        $landTaxPremises = new Land_tax();
        $landTaxPremises->registration_no = $request->assesmentNo;
        $landTaxPremises->worth = $request->assesmentAmount;
        $landTaxPremises->land_name = $request->landName;  // check in blade
        $landTaxPremises->phone = $request->phoneNo;
        $landTaxPremises->door_no = $request->doorNo;
        $landTaxPremises->street = $request->street;
        $landTaxPremises->city = $request->city;
        $landTaxPremises->employee_id =Auth::user()->id; // get releted employee id
        $landTaxPremises->payer_id =$id;

        $landTaxPremises ->save();
        
        return redirect()->route('land-profile', ['id'=>$vatPayer->id])->with('status', 'New Premises Added successfully');
    }

    
    public function updateLandProfile($id, UpdateLandProfileRequest $request)
    {
        $landTaxPremises = Land_tax::findOrFail($id);

        //update business details
        $landTaxPremises->registration_no = $request->assesmentNo;
        $landTaxPremises->worth = $request->assesmentAmount;
        $landTaxPremises->land_name = $request->landName;
        $landTaxPremises->phone = $request->phoneno;
        $landTaxPremises->door_no = $request->doorno;
        $landTaxPremises->street = $request->street;
        $landTaxPremises->city = $request->city;
             
        $landTaxPremises->save();
        return redirect()->back()->with('status', 'Premises details updated successful');
    }

    public function receiveLandPayments($land_id, Request $request)
    {
        $landTaxPremises = Land_tax::findOrFail($land_id);  
        $payerId = $landTaxPremises->payer->id; // getting vat payer Id
        
        $landTaxPayment = new Land_tax_payment();
        $landTaxPayment->payment = $request->payment;
        $landTaxPayment->land_id = $land_id;
        $landTaxPayment->payer_id = $payerId;
        $landTaxPayment->user_id = Auth::user()->id;

        // if there was a duepayment update it to zero
        if ($landTaxPremises->due != null && $landTaxPremises->due->due_amount!=0) {
            $lastDue = Land_tax_due_payment::where('land_id', $landTaxPremises->id)->first();
            $lastDue->due_amount = 0;
            $lastDue->save();
        }

        $landTaxPayment->save();

        return redirect()->back()->with('status','Payment added Successfully'); 
    }

    //Report Generation
    public function landReportGeneration()                                                                       //directs the report genaration view
    {
        return view('vat.land.landReportGeneration');
    }

    public function generateReport(LandTaxReportRequest $request)
    {
        $dates = (object)$request->only(["startDate","endDate"]);
        $reportData = LandReport::generateLandReport($dates);

        $records = Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.land.landReportView', ['dates'=>$dates, 'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.land.landSummaryReport', ['dates'=>$dates, 'records'=>$records, 'reportData'=>$reportData]);
        }

    }

    public function TaxPdf(LandTaxReportRequest $request)
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $PremisesCount=Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->count('land_id');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum, $PremisesCount));
        
        return $pdf->stream();
    }

    public function TaxReportHTML($records, $dates, $Paymentsum, $PremisesCount)
    {
        $output = "
        <h3 align='center'>Land Tax Report from $dates->startDate to $dates->endDate </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
         <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PREMISES</th>
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
          <td style="border: 1px solid; padding:12px;">'.$record->land_id.' - '.$record->landTax->land_name.'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->land_id.' - '.$record->landTax->address.'</td>
          <td style="border: 1px solid; padding:12px;">'.'Rs. '.number_format($record->payment, 2).'</td>
          <td style="border: 1px solid; padding:12px;">'.$record->updated_at.'</td>
           
         </tr>
         ';
        }
        
        $output .= '</table>';
        $output .= "<br>Total Premises hired : ".$PremisesCount;
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

    public function summaryPdf(LandTaxReportRequest $request)
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Land_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($records, $dates, $sum));
        

        return $pdf->stream();

    }

    public function summaryReportHTML($records, $dates, $sum)
    {
        $reportData = LandReport::generateLandReport();
        $output = "
         <h3 align='center'>Land Tax Summary Report from $dates->startDate to $dates->endDate </h3>
         <table width='100%' style='border-collapse: collapse; border: 0px;'>
          <tr>
        <th style='border: 1px solid; padding:12px;' width='20%'>Premises Name</th>
        <th style='border: 1px solid; padding:12px;' width='20%'>Premises Address</th>
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


     //soft delete land payments
    public function removePayment($id)
    {
        $landTaxPayment = Land_tax_payment::find($id);
        $landTaxPremises = $landTaxPayment->landTax;

        //restore the dueAmount
        $restoreDue = Land_tax_due_payment::where('land_id',$landTaxPayment->landTax->id)->first();
        $recalculateDue = $this->calculateTax(-$landTaxPremises->worth, $landTaxPayment->payment);
        if($restoreDue==null) {
           $restoreDue = new Land_tax_due_payment;
           $restoreDue->land_id = $landTaxPayment->land_id;
           $restoreDue->payer_id = $landTaxPayment->payer_id;
        }

        if ($recalculateDue!=0) {
            $restoreDue->due_amount = $recalculateDue;
            $restoreDue->save();
        }
        
        $landTaxPayment -> delete();
        return redirect()->back()->with('status', 'Deleted Successfully');
    }

    //check payments land payments for a given vat payer for quick payment option

    public function trashPayment($id)
    {
        $landTaxPayment = Land_tax_payment::onlyTrashed()->where('payer_id',$id)->get();
        return view('vat.land.trashPayment', ['landTaxPayment'=>$landTaxPayment]);
    }

    public function restorePayment($id)
    {
        $landTaxPayment = Land_tax_payment::onlyTrashed()->where('id',$id);
        $landId = $landTaxPayment->first()->land_id;
        $landTaxPayment->restore($id);
        return redirect()->route('land-payments', ['id'=>$landId])->with('status', 'Payment restored successfully');
    }

    // premanent delete payment
    public function destroy($id)
    {
        $landTaxPayment = Land_tax_payment::onlyTrashed()->where('id',$id)->first();
        $landTaxPayment->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }

    //soft delete Lands(premises)
    public function removeLandPremises($land_id)
    {
        $landTaxPremises = Land_tax::find($land_id);
        $landTaxPremises->delete();
        return redirect()->back()->with('status','Deleted Successfully');

    }

    public function trashLandPremises($payer_id)
    {
        $landTaxPremises = Land_tax::onlyTrashed()->where('payer_id',$payer_id)->get();
        return view('vat.land.trashLandPremises', ['landTaxPremises'=>$landTaxPremises]);
    }

    public function restoreLandPremises($id)
    {
        $landTaxPremises = Land_tax::onlyTrashed()->where('id',$id);
        $payerId = $landTaxPremises->first()->payer_id;
        $landTaxPremises->restore();
        return redirect()->route('land-profile', ['id'=>$payerId])->with('status','Premises restored successfully');
    }

}
