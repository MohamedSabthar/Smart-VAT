<?php

namespace App\Http\Controllers\Vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\AddEntertainmentTicketPaymentRequest;
use App\Http\Requests\UpdateEntertainmentTicketPaymentRequest;
use App\Http\Requests\AddEntertainmentPerformancePaymentRequest;
use App\Http\Requests\UpdateEntertainmentPerformancePaymentRequest;


use Auth;

use App\Vat_payer;
use App\Entertainment_type;
use App\Entertainment_tax_tickets_payment;
use App\Entertainment_performance_type;
use App\Entertainment_tax_performance_payment;

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
}