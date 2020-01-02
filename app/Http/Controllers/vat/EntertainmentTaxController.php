<?php

namespace App\Http\Controllers\Vat;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

use App\Http\Requests\AddEntertainmentTicketPaymentRequest;
use App\Http\Requests\UpdateEntertainmentTicketPaymentRequest;

use Auth;

use App\Vat_payer;
use App\Entertainment_type;
use App\Entertainment_tax_tickets_payment;
use App\Entertainment_performance_type;

class EntertainmentTaxController extends Controller
{
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

    public function showOtherTaxForm($id)
    {
        $vatPayer = Vat_payer::find($id);
        $performanceTypes = Entertainment_performance_type::all();
        return view('vat.entertainment.entertainmentOtherTaxes', ['vatPayer'=>$vatPayer,'performanceTypes'=>$performanceTypes]);
    }
}