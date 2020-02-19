<?php

namespace App\Http\Controllers\Vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\AddEntertainmentTicketPaymentRequest;
use App\Http\Requests\UpdateEntertainmentTicketPaymentRequest;
use App\Http\Requests\AddEntertainmentPerformancePaymentRequest;
use App\Http\Requests\UpdateEntertainmentPerformancePaymentRequest;

use App;
use Auth;

use App\Vat_payer;
use App\Entertainment_type;
use App\Entertainment_tax_tickets_payment;
use App\Entertainment_performance_type;
use App\Entertainment_tax_performance_payment;

use App\Http\Requests\IndustrialTaxReportRequest;


use App\Reports\EntertainmentTaxTicketReport;
use App\Reports\EntertainmentTaxPerformanceReport;

class EntertainmentTaxController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth'=>'verified']);
        $this->middleware('vat');
    }
    
    private function calculateTicketTax($id, $ticketAmmout, $effectiveTickets)
    {
        $entertainmentType = Entertainment_type::find($id);
        return $effectiveTickets*$ticketAmmout*($entertainmentType->vat_percentage/100);
    }

    public function entertainmentPayments($id)
    {
        $vatPayer = Vat_payer::find($id);
        $ticketTypes = Entertainment_type::all();
        return view('vat.entertainment.entertainmentPayments', ['vatPayer'=>$vatPayer,'ticketTypes'=>$ticketTypes]);
    }

    public function reciveEntertainmentPayments($id, AddEntertainmentTicketPaymentRequest $request)
    {
        $entertainmentTicketPayment = new Entertainment_tax_tickets_payment;
        $entertainmentTicketPayment->type_id = $request->ticketType;
        $entertainmentTicketPayment->payer_id = $id;
        $entertainmentTicketPayment->user_id = Auth::user()->id;
        $entertainmentTicketPayment->place_address = $request->placeAddress;
        $entertainmentTicketPayment->ticket_price = $request->ticketPrice;
        $entertainmentTicketPayment->quoted_tickets = $request->quotedTickets;
        $taxPayment = $this->calculateTicketTax($request->ticketType, $request->ticketPrice, $request->quotedTickets);
        $entertainmentTicketPayment->payment = $taxPayment;
        $entertainmentTicketPayment->save();

        return redirect()->back()->with('status', 'Payments successfully accepted')->with('taxPayment', $taxPayment);
    }

    //softdelete ticket payments
    public function removeTicketPayment($id)
    {
        $entertainmentTicketPayment = Entertainment_tax_tickets_payment::find($id);
        $entertainmentTicketPayment -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function trashTicketPayment($id)
    {
        $entertainmentTicketPayment = Entertainment_tax_tickets_payment::onlyTrashed()->where('payer_id', $id)->get();
        // dd($entertainmentTicketPayment);
        return view('vat.entertainment.trashTicketPayments', ['entertainmentTicketPayment'=>$entertainmentTicketPayment]);
    }

    //restore payment
    public function restoreTicketPayment($id)
    {
        $entertainmentTicketPayment = Entertainment_tax_tickets_payment::onlyTrashed()->where('id', $id)->first();
        $payerId = $entertainmentTicketPayment->payer_id;
        $entertainmentTicketPayment->restore();
        return redirect()->route('entertainment-profile', ['id'=>$payerId])->with('status', 'Payment restored successfully');
    }

    public function updateTicketPayment($id, UpdateEntertainmentTicketPaymentRequest $request)
    {
        $entertainmentTicketPayment= Entertainment_tax_tickets_payment::find($request->paymentId);

        $entertainmentTicketPayment->type_id = $request->updateTicketType;
        $entertainmentTicketPayment->payer_id = $id;
        $entertainmentTicketPayment->user_id = Auth::user()->id;
        $entertainmentTicketPayment->place_address =   $request->updatePlaceAddress;
        $entertainmentTicketPayment->ticket_price = $request->updateTicketPrice;
        $entertainmentTicketPayment->returned_tickets =  $request->updateReturnedTickets;
        $entertainmentTicketPayment->quoted_tickets = $request->updateQuotedTickets;
        $effectiveTickets = $request->updateQuotedTickets - $request->updateReturnedTickets;
        $retunTaxPayment = $this->calculateTicketTax($request->updateTicketType, $request->updateTicketPrice, $request->updateReturnedTickets);
        $taxPayment = $this->calculateTicketTax($request->updateTicketType, $request->updateTicketPrice, $effectiveTickets);
        $entertainmentTicketPayment->payment = $taxPayment;
        $entertainmentTicketPayment->returned_payment = $retunTaxPayment;
        $entertainmentTicketPayment->save();

        return redirect()->back()->with('status', 'Payments successfully accepted')->with('taxPayment', $taxPayment)->with('retunTaxPayment', $retunTaxPayment);
    }

    public function showPerformanceTaxForm($id)
    {
        $vatPayer = Vat_payer::find($id);
        $performanceTypes = Entertainment_performance_type::all();
        return view('vat.entertainment.entertainmentPerformanceTaxes', ['vatPayer'=>$vatPayer,'performanceTypes'=>$performanceTypes]);
    }

    public function recievePerformancePayments($id, AddEntertainmentPerformancePaymentRequest $request)
    {
        $PerformancePayment = new Entertainment_tax_performance_payment;

        $PerformancePayment->type_id   = $request->paymentType;
        $PerformancePayment->place_address   = $request->placeAddress;
        $PerformancePayment->days   = $request->noOfDays;
        $PerformancePayment->payer_id = $id;
        $PerformancePayment->user_id = Auth::user()->id;
        $taxPayment =$this->calculatePerformaceTax($request->noOfDays, $request->paymentType);
        $PerformancePayment->payment = $taxPayment;
        $PerformancePayment->save();

        return redirect()->back()->with('status', 'Payments successfully accepted')->with('taxPayment', $taxPayment);
    }

    private function calculatePerformaceTax($days, $paymentTypeId)
    {
        $type = Entertainment_performance_type::find($paymentTypeId);
        if ($days==1) {
            return $type->amount;
        }
        return $type->amount + ($days-1)*$type->additional_amount;
    }

    public function removePerformancePayment($id)
    {
        $entertainmentPerformancePayment = Entertainment_tax_performance_payment::find($id);
        $entertainmentPerformancePayment -> delete();
        return redirect()->back()->with('status', 'Delete Successful');
    }

    public function trashPerformancePayment($id)
    {
        $entertainmentPerformancePayment = Entertainment_tax_performance_payment::onlyTrashed()->where('payer_id', $id)->get();
        // dd($entertainmentTicketPayment);
        return view('vat.entertainment.trashPerformancePayments', ['entertainmentPerformancePayment'=>$entertainmentPerformancePayment]);
    }

    //restore payment
    public function restorePerformancePayment($id)
    {
        $entertainmentTicketPayment = Entertainment_tax_performance_payment::onlyTrashed()->where('id', $id)->first();
        $payerId = $entertainmentTicketPayment->payer_id;
        $entertainmentTicketPayment->restore();
        return redirect()->route('entertainment-performance-tax', ['id'=>$payerId])->with('status', 'Payment restored successfully');
    }

    // premanent delete payment
    public function destoryTicket($id)
    {
        $entertainmentTaxPyament = Entertainment_tax_tickets_payment::onlyTrashed()->where('id', $id)->first();
        //dd($entertainmentTaxPyament);
        $entertainmentTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }

    // premanent delete payment
    public function destoryPerformance($id)
    {
        $entertainmentTaxPyament = Entertainment_tax_performance_payment::onlyTrashed()->where('id', $id)->first();
        //dd($entertainmentTaxPyament);
        $entertainmentTaxPyament->forceDelete();
        return redirect()->back()->with('status', ' Permanent Delete Successful');
    }

    public function updatePerformancePayment($id, UpdateEntertainmentPerformancePaymentRequest $request)
    {
        $performancePayment = Entertainment_tax_performance_payment::find($request->paymentId);
        
        $performancePayment->type_id   = $request->updatedPerformanceType;
        $performancePayment->place_address   = $request->updatedPlaceAddress;
        $performancePayment->days   = $request->updatedDays;
        $taxPayment =$this->calculatePerformaceTax($request->updatedDays, $request->updatedPerformanceType);
        $performancePayment->payment = $taxPayment;
        $performancePayment->save();

        return redirect()->back()->with('status', 'Payments successfully updated')->with('taxPayment', $taxPayment);
    }

    //-----------------------------------

    public function generateTicketReport(IndustrialTaxReportRequest $request)
    {
        $dates = (object)$request->only(["startDate","endDate"]);
        $reportData = EntertainmentTaxTicketReport::generateEntertainmentTaxTicketReport($dates);
        $records = Entertainment_tax_tickets_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.entertainment.entertainmentTicketReportView', ['dates'=>$dates,'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.entertainment.entertainmentTicketSummaryReport', ['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
    }

    public function entertainmentTicketReportGeneration()
    {
        return view('vat.entertainment.entertainmentTicketReportGeneration');
    }

    public function ticketTaxPdf(IndustrialTaxReportRequest $request)                                                      //pdf generation library function
    {
        $pdf = App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Entertainment_tax_tickets_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Entertainment_tax_tickets_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $pdf->loadHTML($this->ticketTaxReportHTML($records, $dates, $Paymentsum));
        
        return $pdf->stream();
    }


    public function ticketSummaryPdf(IndustrialTaxReportRequest $request)                         //Summary Report PDF
    {
        $pdf = App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Entertainment_tax_tickets_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->ticketSummaryReportHTML($dates, $sum));
        

        return $pdf->stream();
    }

    public function ticketSummaryReportHTML($dates, $sum)
    {
        $reportData = EntertainmentTaxTicketReport::generateEntertainmentTaxTicketReport($dates);
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


    public function ticketTaxReportHTML($records, $dates, $Paymentsum)
    {
        $output = "
    <h3 align='center'>Industrial Tax Report from $dates->startDate to $dates->endDate </h3>
    <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
    <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>TICKET TYPE</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
    </tr>";
        foreach ($records as $record) {
            $output .= "
    <tr>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->nic."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->full_name."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->type->description."</td>
        <td style='border: 1px solid; padding:12px;'>".'Rs. '.number_format($record->payment, 2)."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->updated_at."</td> 
    </tr>";
        }
        $output .= "</table>";
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }

    //----------------------------------------------------------------

    public function generatePerformanceReport(IndustrialTaxReportRequest $request)
    {
        $dates = (object)$request->only(["startDate","endDate"]);
        $reportData = EntertainmentTaxPerformanceReport::generateEntertainmentTaxPerformanceReport($dates);
    
        $records = Entertainment_tax_performance_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        if ($request->has('TaxReport')) {
            return view('vat.entertainment.entertainmentPerformanceReportView', ['dates'=>$dates,'records'=>$records]);
        } elseif ($request->has('SummaryReport')) {
            return view('vat.entertainment.entertainmentPerformanceSummaryReport', ['dates'=>$dates,'records'=>$records,'reportData'=>$reportData]);
        }
    }

    public function entertainmentPerformanceReportGeneration()
    {
        return view('vat.entertainment.entertainmentPerformanceReportGeneration');
    }

    public function performanceTaxPdf(IndustrialTaxReportRequest $request)                                                      //pdf generation library function
    {
        $pdf = App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Entertainment_tax_performance_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();                  //get the records with in the range of given dates
        $Paymentsum=Entertainment_tax_performance_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->sum('payment');
        $pdf->loadHTML($this->performanceTaxReportHTML($records, $dates, $Paymentsum));
        
        return $pdf->stream();
    }


    public function performanceSummaryPdf(IndustrialTaxReportRequest $request)                         //Summary Report PDF
    {
        $pdf = App::make('dompdf.wrapper');
        $dates = (object)$request->only(["startDate","endDate"]);

        $records = Entertainment_tax_performance_payment::whereBetween('created_at', [$dates->startDate,$dates->endDate])->get();   //get the records with in the range of given dates
        $sum=$records->sum('payment');
        $pdf->loadHTML($this->performanceSummaryReportHTML($dates, $sum));
        

        return $pdf->stream();
    }

    public function performanceSummaryReportHTML($dates, $sum)
    {
        $reportData = EntertainmentTaxPerformanceReport::generateEntertainmentTaxPerformanceReport($dates);
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


    public function performanceTaxReportHTML($records, $dates, $Paymentsum)
    {
        $output = "
    <h3 align='center'>Industrial Tax Report from $dates->startDate to $dates->endDate </h3>
    <table width='100%' style='border-collapse: collapse; border: 0px;' class='table'>
    <tr>
       <th style='border: 1px solid; padding:12px;' width='15%'>VAT PAYER'S NIC</th>
       <th style='border: 1px solid; padding:12px;' width='25%'>VAT PAYER'S NAME</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>TICKET TYPE</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT</th>
       <th style='border: 1px solid; padding:12px;' width='20%'>PAYMENT DATE</th>
    </tr>";
        foreach ($records as $record) {
            $output .= "
    <tr>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->nic."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->vatPayer->full_name."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->type->description."</td>
        <td style='border: 1px solid; padding:12px;'>".'Rs. '.number_format($record->payment, 2)."</td>
        <td style='border: 1px solid; padding:12px;'>".$record->updated_at."</td> 
    </tr>";
        }
        $output .= "</table>";
        $output .= "<br>Total Payements : Rs.".number_format($Paymentsum, 2)."/=";
        return $output;
    }
}