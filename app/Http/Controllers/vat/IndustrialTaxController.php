<?php

namespace App\Http\Controllers\vat;

use Illuminate\Database\Eloquent\Builder;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Auth;
use App\Vat;
use App\Vat_payer;
use App\Industrial_type;
use App\Assessment_range;
use App\Industrial_tax_shop;
use App\Industrial_tax_payment;
use App\Http\Requests\AddIndustrialShopRequest;
use App\Reports\IndustrialReport;
use App\Http\Requests\IndustrialTaxReportRequest;
use App\Http\Requests\UpdateIndustrialShopRequest;

use App\Industrial_tax_due_payment;
use Carbon\Carbon;
use Industrial_tax_due_payments;

class IndustrialTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }

    
    private function calculateTax($anualWorth, $assessmentAmmount, $dueAmount)
    {
        $currentDate = now()->toArray();
        $industrialTax = Vat::where('route', 'industrial')->firstOrFail();

        return $anualWorth*($industrialTax->vat_percentage/100)+$assessmentAmmount+$dueAmount;
    }

    public function industrialProfile($id)
    {
        $vatPayer = Vat_payer::find($id);
        $industrialTypes = Industrial_type::all();

        return view('vat.industrial.industrialProfile', ['vatPayer'=>$vatPayer,'industrialTypes'=>$industrialTypes]);
    }

    public function getIndustrialtypes(Request $request)
    {
        $search = $request->search;
       
        $industrialTax = Vat::where('route', 'industrial')->firstOrFail();
       
        $assessmentRangeId =  Assessment_range::where('vat_id', $industrialTax->id)->where('start_value', '<', $request->assessmentAmmount)
                            ->where(function (Builder $query) use ($request) {
                                $query->where('end_value', '>', $request->assessmentAmmount)
                                ->orWhere('end_value', '=', null);
                            })
                            ->firstOrFail()->id;

        $industrialTypes = Industrial_type::where('assessment_range_id', $assessmentRangeId)->
        where('description', 'like', "%$search%");
        $data = $industrialTypes->get(['id','description']);
        return response()->json(array("results"=>$data
       ), 200);
    }

    public function industrialPayments($shop_id)
    {
        $industrialTaxShop = Industrial_tax_shop::findOrFail($shop_id);
        $currentDate = now()->toArray();    // get the currrent date properties
        $lastPaymentDate = $industrialTaxShop->payments->pluck('created_at')->last(); // get the last payment date
        $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
        $paid=false;
        $duePayment = 0.0;
        
        if ($lastPaymentDate!=null && $currentDate['year'] == $lastPaymentDate['year']) { //if last_payment year matchess current year
            $paid=true; // then this year has no due
        } else {
            $assessmentAmmount = $industrialTaxShop->industrialType->assessment_ammount;
            $dueAmount = $industrialTaxShop->due == null ? 0 : $industrialTaxShop->due->due_ammount;   //last due ammount which is not yet paid

            $duePayment = $this->calculateTax($industrialTaxShop->anual_worth, $assessmentAmmount, $dueAmount);
        }
       
        return view('vat.industrial.industrialPayments', ['industrialTaxShop'=>$industrialTaxShop,'paid'=>$paid,'duePayment'=>$duePayment]);
    }

    // register new industrial shop
    public function registerIndustrialShop($id, AddIndustrialShopRequest $request)
    {
        // dd('indus');
        $vatPayer = Vat_payer :: find($id); // get vat payer id
        $industrialTaxShop = new Industrial_tax_shop();
        $industrialTaxShop->registration_no = $request->assesmentNo;
        $industrialTaxShop->anual_worth = $request->annualAssesmentAmount;
        $industrialTaxShop->shop_name = $request->businessName;
        $industrialTaxShop->phone = $request->phoneno;
        $industrialTaxShop->door_no = $request->doorno;
        $industrialTaxShop->street = $request->street;
        $industrialTaxShop->city = $request->city;
        $industrialTaxShop->type = $request->type;
        $industrialTaxShop->employee_id =Auth::user()->id; // get releted employee id
        $industrialTaxShop->payer_id =$id;
 
        $industrialTaxShop ->save();
         
        return redirect()->route('industrial-profile', ['id'=>$vatPayer->id])->with('status', 'New Industrial shop Added successfully');
    }

    public function reciveIndustrialPayments($shop_id, Request $request)
    {
        // dd('indus');
        $industrialTaxShop=Industrial_tax_shop::findOrFail($shop_id);  //get the VAT payer id
        $payerId =  $industrialTaxShop->payer->id;  //get the VAT payer id
        
        $industrialTaxPyament = new Industrial_tax_payment;
        $industrialTaxPyament->payment = $request->payment;
        $industrialTaxPyament->shop_id = $shop_id;
        $industrialTaxPyament->payer_id =$payerId;
        $industrialTaxPyament->user_id = Auth::user()->id;

        // if there was a duepayment update it to zero
        if ($industrialTaxShop->due != null && $industrialTaxShop->due->due_ammount!=0) {
            $lastDue = Industrial_tax_due_payment::where('shop_id', $industrialTaxShop->id)->first();
            $lastDue->due_ammount = 0;
            $lastDue->save();
        }

        
        $industrialTaxPyament->save();

        return redirect()->back()->with('sucess', 'Payment added successfuly');
    }

    //soft delete industrial payment
    public function removePayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::find($id);
        $industrialTaxShop = $industrialTaxPyament->industrialTaxShop;

        //restore the dueAmout
        $restoreDue = Industrial_tax_due_payment::where('shop_id', $industrialTaxPyament->industrialTaxShop->id)->first();
        $recalculatedDue = $this->calculateTax(-$industrialTaxShop->anual_worth, -$industrialTaxShop->industrialType->assessment_ammount, $industrialTaxPyament->payment) ;
        if ($restoreDue==null) {
            $restoreDue = new Industrial_tax_due_payment;
            $restoreDue->shop_id = $industrialTaxPyament->shop_id;
            $restoreDue->payer_id = $industrialTaxPyament->payer_id;
        }
         
        if ($recalculatedDue!=0) {
            $restoreDue->due_ammount =  $recalculatedDue ;
            $restoreDue->save();
        }

         
        $industrialTaxPyament -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    //soft delete industrial shop
    public function removeIndustrialShop($shop_id)
    {
        $industrialTaxShop = Industrial_tax_shop::find($shop_id);
        $industrialTaxShop-> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function viewQuickPayments()
    {
        return view('vat.industrial.industrialQuickPayments');
    }

    public function checkPayments(Request $request)
    {
        $data['payerDetails'] = Vat_payer::where('nic', $request->nic)->first();
        if ($data['payerDetails'] != null) {
            $data['duePaymentValue'] = [];
            $data['duePayments']=[];
            $currentDate = now()->toArray();    // get the currrent date properties
            $year = $currentDate['year'];
            $i =0;
            
            foreach ($data['payerDetails']->industrial as $shop) {
                $lastPaymentDate = $shop->payments->pluck('created_at')->last(); // get the last payment date
                $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
                $assessmentAmmount = $shop->industrialType->assessment_ammount;
                $dueAmount = $shop->due == null ? 0 : $shop->due->due_ammount;      //last due ammount which is not yet paid
                $data['duePaymentValue'][$i] = $this->calculateTax($shop->anual_worth, $assessmentAmmount, $dueAmount);
                $data['duePayments'][$i]=  Industrial_tax_payment::where('shop_id', $shop->id)->where('created_at', 'like', "%$year%")->first(); //getting the latest payment if paid else null
                $i++;
            }
        }
        return response()->json($data, 200);
    }


    public function acceptQuickPayments(Request $request)
    {
        $shopIds = $request->except(['_token']);
        
        if (count($shopIds)==0) {
            return redirect()->back()->with('error', 'No payments selected');
        }
        
        foreach ($shopIds as $shopId => $val) {
            $industrialTaxShop=Industrial_tax_shop::findOrFail($shopId);  //get the VAT payer id
            $payerId = $industrialTaxShop->payer->id;
            $lastPaymentDate = $industrialTaxShop->payments->pluck('created_at')->last(); // get the last payment date
            $lastPaymentDate = $lastPaymentDate!=null ? $lastPaymentDate->toArray() : null; // get the last payment date properties
            $assessmentAmmount = $industrialTaxShop->industrialType->assessment_ammount;
            $dueAmount = $industrialTaxShop->due == null ? 0 : $industrialTaxShop->due->due_ammount;   //last due ammount which is not yet paid
            $duePayment = $this->calculateTax($industrialTaxShop->anual_worth, $assessmentAmmount, $lastPaymentDate);
            $industrialTaxPyament = new Industrial_tax_payment;
            $industrialTaxPyament->payment = $duePayment;
            $industrialTaxPyament->shop_id = $shopId;
            $industrialTaxPyament->payer_id =$payerId;
            $industrialTaxPyament->user_id = Auth::user()->id;
    
            $industrialTaxPyament->save();
        }
    
        return redirect()->back()->with('status', 'Payments successfully accepted');
    }

    public function trashPayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('payer_id', $id)->get();
        return view('vat.industrial.trashPayment', ['industrialTaxPyament'=>$industrialTaxPyament]);
    }

    //restore payment
    public function restorePayment($id)
    {
        $industrialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('id', $id);
        $shopId = $industrialTaxPyament->first()->shop_id;
        $industrialTaxPyament->restore();
        return redirect()->route('industrial-payments', ['shop_id'=>$shopId])->with('status', 'Payment restored successfully');
    }

    public function trashIndustrialShop($payer_id)
    {
        $industrialTaxShop = Industrial_tax_shop::onlyTrashed()->where('payer_id', $payer_id)->get();
        return view('vat.industrial.trashIndustrialShop', ['industrialTaxShop'=>$industrialTaxShop]);
    }


    public function restoreIndustrialShop($id)
    {
        $industrialTaxShop = Industrial_tax_shop::onlyTrashed()->where('id', $id);
        $payerId = $industrialTaxShop->first()->payer_id;
        $industrialTaxShop->restore();
        return redirect()->route('industrial-profile', ['id'=>$payerId])->with('status', 'Industrial shop restored successfully');
    }

    // premanent delete payment
    public function destory($id)
    {
        $indusrtialTaxPyament = Industrial_tax_payment::onlyTrashed()->where('id', $id)->first();
        //dd($indusrtialTaxPyament);
        $indusrtialTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }

    public function generateReport(IndustrialTaxReportRequest $request)
    {
        $dates = (object)$request->only(["startDate","endDate"]);
        $reportData = IndustrialReport::generateIndustrialReport($dates);
    
        $records = Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.industrial.industrialReportView', ['dates'=>$dates,'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.industrial.industrialSummaryReport', ['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
    }

    public function industrialReportGeneration()
    {
        return view('vat.industrial.industrialReportGeneration');
    }

    public function taxPdf(IndustrialTaxReportRequest $request)                                                      //pdf generation library function
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $ShopCount=Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->count('shop_id');
        $pdf->loadHTML($this->TaxReportHTML($records, $dates, $Paymentsum, $ShopCount));
        
        return $pdf->stream();
    }


    public function summaryPdf(IndustrialTaxReportRequest $request)                         //Summary Report PDF
    {
        $pdf = \App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Industrial_tax_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->summaryReportHTML($dates, $sum));
        

        return $pdf->stream();
    }

    public function summaryReportHTML($dates, $sum)
    {
        $reportData = IndustrialReport::generateIndustrialReport($dates);
        $output = "
        <h3 align='center'>
            Industrial Summary Report from $dates->startDate to $dates->endDate
        </h3>
        <table width='100%' style='border-collapse: collapse; border: 0px;'>
        <tr>
            <th style='border: 1px solid; padding:12px;' width='20%'>Industrial Type</th>
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
    <h3 align='center'>Industrial Tax Report from $dates->startDate to $dates->endDate </h3>
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
        <td style='border: 1px solid; padding:12px;'>".$record->shop_id.' - '.$record->industrialTaxShop->shop_name."</td>
        <td style='border: 1px solid; padding:12px;'>".'Rs. '.number_format($record->payment, 2)."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->updated_at."</td> 
    </tr>";
        }
        $output .= "</table>";
        $output .= "<br>Total Shops : ".$ShopCount;
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

    public function getUnpaidVatPayer()
    {
        $payersDue = Industrial_tax_due_payment::where('due_ammount', '!=', 0)->get();
        $year = Carbon::now()->toArray()['year'];
        return view('vat.industrial.industrialTaxUnPaidPayers', ['year'=>$year,'payersDue'=>$payersDue]);
    }

    public function getUnpaidVatPayerPdf()
    {
        $pdf = \App::make('dompdf.wrapper');

        $payersDue = Industrial_tax_due_payment::where('due_ammount', '!=', 0)->get();
        $year = Carbon::now()->toArray()['year'];
         
        $pdf->loadView('vat.industrial.industrialTaxUnPaidPayersPdf', ['year'=>$year,'payersDue'=>$payersDue]);
   
        return $pdf->stream();
    }

    public function updateIndustrialShop(UpdateIndustrialShopRequest $request)
    {
        $industrialTaxShop = Industrial_tax_shop::find($request->id);
        $industrialTaxShop->anual_worth = $request->anual_worth;
        $industrialTaxShop->shop_name = $request->industrialName;
        $industrialTaxShop->phone = $request->phoneno;
        $industrialTaxShop->door_no = $request->doorno;
        $industrialTaxShop->street = $request->street;
        $industrialTaxShop->city = $request->city;
        $industrialTaxShop->save();
        return redirect()->back();
    }
}