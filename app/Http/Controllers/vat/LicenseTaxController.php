<?php

namespace App\Http\Controllers\vat;
use Auth;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Arr;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Vat;
use App\Vat_payer;
use App\License_type;
use App\License_tax_shop;
use App\License_tax_payment;
use App\Http\Requests\AddLicenseRequest;
use App\Http\Requests\LicenseTaxReportRequest;
use App\Reports\LicenseReport;
use App\Assessment_range;
use App\License_due_payment;


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

    public function removePayment($id)
    {
        $licenseTaxPyament=License_tax_payment::find($id);
        $licenseTaxShop=$licenseTaxPyament->licenseTaxShop;

        //before deletng permanently, make the current payment as a due payment again

        $restoreDue = License_due_payment::where('shop_id', $licenseTaxPyament->licenseTaxShop->id)->first();
        $recalculatedDue = $this->calculateTax(-$licenseTaxShop->anual_worth, -$licenseTaxShop->licenseType->assessment_ammount, $licenseTaxPyament->payment) ;
        if ($restoreDue==null) {
            $restoreDue = new License_due_payment;
            $restoreDue->shop_id = $licenseTaxPyament->shop_id;
            $restoreDue->payer_id = $licenseTaxPyament->payer_id;
        }
         
        if ($recalculatedDue!=0) {
            $restoreDue->due_ammount =  $recalculatedDue ;
            $restoreDue->save();
        }

         
        $licenseTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful'); 

    }


    //soft delete license duties
    public function removeLicenseDuty($shop_id)
    {
        $licenseTaxShop = License_tax_shop::find($shop_id);
        $licenseTaxShop-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }






    public function getLicensetypes(Request $request)
    {
        $search = $request->search;

       
        $licenseTax = Vat::where('route', 'license')->firstOrFail();
       
        $assessmentRangeId =  Assessment_range::where('vat_id', $licenseTax->id)->where('start_value', '<', $request->assessmentAmmount)
                            ->where(function (Builder $query) use ($request) {
                                $query->where('end_value', '>', $request->assessmentAmmount)
                                ->orWhere('end_value', '=', null);
                            })
                            ->firstOrFail()->id;

        $licenseTypes = License_type::where('assessment_range_id', $assessmentRangeId)->
        where('description', 'like', "%$search%");
      

        $data = $licenseTypes->get(['id','description']);
        // dd( $assessmentRangeId);
        return response()->json(array("results"=>$data
       ), 200);
    }


    public function licenseReportGeneration()
    {
        return view('vat.license.licenseReportGeneration');
    }

    public function generateReport(LicenseTaxReportRequest $request)                                              //get the star date and the end date for the report generation
    {   //dd('pp');
        $dates = (object)$request->only(["startDate","endDate"]);
        $reportData = licenseReport::generateLicenseReport($dates);
        $records = License_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.license.licenseReportView', ['dates'=>$dates,'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.license.licenseSummaryReport', ['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
    }


    public function taxPdf(licenseTaxReportRequest $request)                                                      //pdf generation library function
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = License_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=License_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $ShopCount=License_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->count('shop_id');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum, $ShopCount));
        
        return $pdf->stream();
    }


    public function summaryPdf(licenseTaxReportRequest $request)                         //Summary Report PDF
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = license_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($dates, $sum));
        

        return $pdf->stream();
    }

    public function summaryReportHTML($dates, $sum)
    {
        $reportData = licenseReport::generateLicenseReport($dates);
        $output = "
        <h3 align='center'>
            License Duty Summary Report from $dates->startDate to $dates->endDate
        </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;'>
        <tr>
            <th style='border: 1px solid; padding:12px;' width='20%'>License Type</th>
            <th style='border: 1px solid; padding:12px;' width='10%'>Total Payments</th>
       </tr>";

        foreach ($reportData as $description => $total) {
            $output .= "
        <tr>
           <td style='border: 1px solid; padding:12px;'>".$description."</td>
           <td style='border: 1px solid; padding:12px;'>".'Rs.' .number_format($total, 2)."</td>
        </tr>
          ";
        }
        $output .= '</table>';
        $output .= "<br>Total Payements : Rs. ".number_format($sum, 2)."/=";
        return $output;
    }


    public function TaxReportHTML($records, $dates, $Paymentsum, $ShopCount)
    {
        $output = "
    <h3 align='center'>License Duty Report from $dates->startDate to $dates->endDate </h3>
    <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
    <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>SHOP</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
    </tr>";
        foreach ($records as $record) {
            $output .= "
    <tr>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->nic."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->full_name."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->shop_id.' - '.$record->licenseTaxShop->shop_name."</td>
        <td style='border: 1px solid; padding:12px;'>".'Rs. '.number_format($record->payment, 2)."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->updated_at."</td> 
    </tr>";
        }
        $output .= "</table>";
        $output .= "<br>Total Shops : ".$ShopCount;
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

    
}
